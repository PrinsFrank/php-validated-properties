<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels;

use PrinsFrank\PhpStrictModels\Enum\ModelStrictness;
use PrinsFrank\PhpStrictModels\Enum\Types;
use PrinsFrank\PhpStrictModels\Enum\Visibility;
use PrinsFrank\PhpStrictModels\Exception\NonExistingPropertyException;
use PrinsFrank\PhpStrictModels\Exception\TypeException;
use PrinsFrank\PhpStrictModels\Exception\VisibilityException;
use Reflection;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class Model
{
    protected const STRICTNESS = ModelStrictness::STRICT;

    /**
     * @throws VisibilityException
     */
    final public function __construct()
    {
        $publicPropertyNames = array_map(
            static fn (ReflectionProperty $publicProperty) => $publicProperty->name,
            array_filter(
                (new ReflectionClass(static::class))->getProperties(),
                static fn (ReflectionProperty $reflectionProperty) => in_array(Visibility::PUBLIC->value, Reflection::getModifierNames($reflectionProperty->getModifiers()), true)
            )
        );

        if (count($publicPropertyNames) !== 0) {
            throw new VisibilityException('Model should not have public properties, but has "' . implode(',', $publicPropertyNames) . '"');
        }
    }

    public function __isset(string $name): bool
    {
        return property_exists($this, $name);
    }

    /**
     * @throws NonExistingPropertyException
     * @throws TypeException
     * @throws ReflectionException
     */
    public function __set(string $name, mixed $value): void
    {
        if (property_exists($this, $name) === false) {
            throw new NonExistingPropertyException('Property with name "' . $name . '" does not exist');
        }

        $valueType = gettype($value);
        $propertyType = (new ReflectionClass(static::class))->getProperty($name)->getType();
        if ($valueType === Types::INT->value && $propertyType === Types::FLOAT->value && static::STRICTNESS !== ModelStrictness::STRICT) {
            settype($value, Types::FLOAT->value);
            // todo: double/float
            $valueType = gettype($value);
        }

        // Todo lossless type conversion
        if ($propertyType !== $valueType) {
            if (static::STRICTNESS === ModelStrictness::LAX) {
                $this->{$name} = null;

                return; // ignore the value and simply don't set it.
            }

            throw new TypeException('Type of property with name "' . $name . '" is set to "' . $propertyType . '", "' . $valueType . '" given');
        }

        $this->{$name} = $value;
    }

    public function __get(string $name): mixed
    {
        return $this->{$name};
    }
}

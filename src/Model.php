<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels;

use PrinsFrank\PhpStrictModels\Enum\ModelStrictness;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Enum\Visibility;
use PrinsFrank\PhpStrictModels\Exception\NonExistingPropertyException;
use PrinsFrank\PhpStrictModels\Exception\TypeException;
use PrinsFrank\PhpStrictModels\Exception\ValidationFailedException;
use PrinsFrank\PhpStrictModels\Exception\VisibilityException;
use PrinsFrank\PhpStrictModels\Validation\RuleValidator;
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
     * @throws ValidationFailedException
     */
    public function __set(string $name, mixed $value): void
    {
        if (property_exists($this, $name) === false) {
            throw new NonExistingPropertyException('Property with name "' . $name . '" does not exist');
        }

        $reflectionProperty = (new ReflectionClass(static::class))->getProperty($name);

        $valueType = Type::from(gettype($value))->name;
        $propertyType = (string) $reflectionProperty->getType();
        if (($valueType === Type::int->value) && ($propertyType === Type::float->value) && (static::STRICTNESS !== ModelStrictness::STRICT)) {
            settype($value, Type::float->value);
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

        $validationResult = RuleValidator::validateProperty($reflectionProperty, $value);
        if ($validationResult->passes() === false) {
            throw new ValidationFailedException('Value "' . $value . '" for property "' . $name . '" is invalid: "' . implode('","', $validationResult->getErrors()) .  '"');
        }

        $this->{$name} = $value;
    }

    public function __get(string $name): mixed
    {
        return $this->{$name};
    }
}

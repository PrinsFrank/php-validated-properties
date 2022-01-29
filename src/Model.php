<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels;

use PrinsFrank\PhpStrictModels\Enum\ModelStrictness;
use PrinsFrank\PhpStrictModels\Exception\InvalidModelException;
use PrinsFrank\PhpStrictModels\Exception\NonExistingPropertyException;
use PrinsFrank\PhpStrictModels\Exception\ValidationFailedException;
use PrinsFrank\PhpStrictModels\Validation\ModelValidator;
use PrinsFrank\PhpStrictModels\Validation\RuleValidator;
use ReflectionClass;
use ReflectionException;

abstract class Model
{
    protected const STRICTNESS = ModelStrictness::STRICT;

    /**
     * @throws InvalidModelException
     */
    public function __construct()
    {
        $validationResult = ModelValidator::validateModel(new ReflectionClass(static::class));
        if ($validationResult->passes() === false) {
            throw new InvalidModelException('Model is invalid: "' . implode('","', $validationResult->getErrors()) . '"');
        }
    }

    public function __isset(string $name): bool
    {
        return property_exists($this, $name);
    }

    /**
     * @throws NonExistingPropertyException
     * @throws ReflectionException
     * @throws ValidationFailedException
     */
    public function __set(string $name, mixed $value): void
    {
        if (property_exists($this, $name) === false) {
            throw new NonExistingPropertyException('Property with name "' . $name . '" does not exist');
        }

        $reflectionProperty = (new ReflectionClass(static::class))->getProperty($name);
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

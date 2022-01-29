<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Validation;

use PrinsFrank\PhpStrictModels\Enum\Visibility;
use PrinsFrank\PhpStrictModels\Model;
use PrinsFrank\PhpStrictModels\Rule\Rule;
use Reflection;
use ReflectionClass;

class ModelValidator
{
    /**
     * @param ReflectionClass<Model> $reflectionClass
     */
    public static function validateModel(ReflectionClass $reflectionClass): ValidationResult
    {
        $validationResult = new ValidationResult();
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            if (in_array(Visibility::PUBLIC->value, Reflection::getModifierNames($reflectionProperty->getModifiers()), true) === false) {
                continue;
            }

            foreach ($reflectionProperty->getAttributes() as $reflectionAttribute) {
                if ($reflectionAttribute->newInstance() instanceof Rule) {
                    $validationResult->addError('Public properties can\'t have validation rules, but a public property with name "' . $reflectionProperty->getName() . '" does.');

                    break;
                }
            }
        }

        return $validationResult;
    }
}

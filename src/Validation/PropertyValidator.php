<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Validation;

use PrinsFrank\PhpStrictModels\Rule\Rule;
use ReflectionProperty;

class PropertyValidator
{
    public static function validateProperty(ReflectionProperty $reflectionProperty, mixed $value): ValidationResult
    {
        $validationResult = new ValidationResult();
        foreach ($reflectionProperty->getAttributes() as $attribute) {
            $attributeInstance = $attribute->newInstance();
            if (! $attributeInstance instanceof Rule) {
                continue;
            }

            if (! $attributeInstance->isValid($value)) {
                $validationResult->addError($attributeInstance->getMessage());
            }
        }

        return $validationResult;
    }
}

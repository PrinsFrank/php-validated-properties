<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Development\PHPStan;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MissingPropertyFromReflectionException;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use PrinsFrank\PhpStrictModels\Model;

class ModelPropertiesReflectionExtension implements PropertiesClassReflectionExtension
{
    public function hasProperty(ClassReflection $classReflection, string $propertyName): bool
    {
        if ($classReflection->isSubclassOf(Model::class) === false) {
            return false;
        }

        return $classReflection->hasNativeProperty($propertyName);
    }

    /**
     * @throws MissingPropertyFromReflectionException
     */
    public function getProperty(ClassReflection $classReflection, string $propertyName): PropertyReflection
    {
        return new ModelProperty(
            $classReflection,
            $classReflection->getNativeProperty($propertyName)->getReadableType(),
            $classReflection->getNativeProperty($propertyName)->getWritableType()
        );
    }
}

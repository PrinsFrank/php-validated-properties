<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Validation;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Rule\Between;
use PrinsFrank\PhpStrictModels\Validation\ModelValidator;
use PrinsFrank\PhpStrictModels\Validation\ValidationResult;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Validation\ModelValidator
 */
class ModelValidatorTest extends TestCase
{
    /**
     * @covers ::validateModel
     */
    public function testValidateModelHandlesNoProperties(): void
    {
        $reflectionClass = $this->createMock(ReflectionClass::class);
        $reflectionClass->expects(self::once())->method('getProperties')->willReturn([]);

        static::assertEquals(
            new ValidationResult(),
            ModelValidator::validateModel($reflectionClass)
        );
    }

    /**
     * @covers ::validateModel
     */
    public function testValidateModelSkipsPublicProperties(): void
    {
        $reflectionProperty = $this->createMock(ReflectionProperty::class);
        $reflectionClass    = $this->createMock(ReflectionClass::class);

        $reflectionClass->expects(self::once())->method('getProperties')->willReturn(
            [
                $reflectionProperty
            ]
        );
        $reflectionProperty->expects(self::once())->method('getModifiers')->willReturn(2);
        $reflectionProperty->expects(self::never())->method('getAttributes');
        $reflectionProperty->expects(self::never())->method('getName');

        static::assertEquals(
            new ValidationResult(),
            ModelValidator::validateModel($reflectionClass)
        );
    }

    /**
     * @covers ::validateModel
     */
    public function testValidateModelChecksIfPublicPropertyHasRule(): void
    {
        $reflectionProperty = $this->createMock(ReflectionProperty::class);
        $reflectionClass    = $this->createMock(ReflectionClass::class);
        $reflectionAttribute = $this->createMock(ReflectionAttribute::class);

        $reflectionClass->expects(self::once())->method('getProperties')->willReturn(
            [
                $reflectionProperty
            ]
        );
        $reflectionProperty->expects(self::once())->method('getModifiers')->willReturn(1);
        $reflectionProperty->expects(self::once())->method('getAttributes')->willReturn([$reflectionAttribute]);
        $reflectionAttribute->expects(self::once())->method('newInstance')->willReturn(new Between(41,43));
        $reflectionProperty->expects(self::once())->method('getName')->willReturn('bar');

        static::assertEquals(
            (new ValidationResult())->addError('Public properties can\'t have validation rules, but a public property with name "bar" does.'),
            ModelValidator::validateModel($reflectionClass)
        );
    }
}

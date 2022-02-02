<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Validation;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Rule\Rule;
use PrinsFrank\PhpStrictModels\Validation\PropertyValidator;
use PrinsFrank\PhpStrictModels\Validation\ValidationResult;
use ReflectionAttribute;
use ReflectionProperty;
use stdClass;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Validation\PropertyValidator
 */
class PropertyValidatorTest extends TestCase
{
    /**
     * @covers ::validateProperty
     */
    public function testValidatesPropertyWithoutAttributes(): void
    {
        $property = $this->createMock(ReflectionProperty::class);
        $property->expects(self::once())->method('getAttributes')->willReturn([]);

        static::assertEquals(
            new ValidationResult(),
            PropertyValidator::validateProperty($property, 'bar')
        );
    }

    /**
     * @covers ::validateProperty
     */
    public function testValidatesPropertyIgnoresNonRuleProperties(): void
    {
        $property = $this->createMock(ReflectionProperty::class);
        $attribute = $this->createMock(ReflectionAttribute::class);

        $property->expects(self::once())->method('getAttributes')->willReturn([$attribute]);
        $attribute->expects(self::once())->method('newInstance')->willReturn(new stdClass());

        static::assertEquals(
            new ValidationResult(),
            PropertyValidator::validateProperty($property, 'bar')
        );
    }

    /**
     * @covers ::validateProperty
     */
    public function testValidatesProperty(): void
    {
        $property = $this->createMock(ReflectionProperty::class);
        $attribute = $this->createMock(ReflectionAttribute::class);
        $attributeInstance = new class implements Rule {
            public function applicableToTypes(): array
            {
                return [];
            }

            public function isValid(mixed $value): bool
            {
                return $value === 'foo';
            }

            public function getMessage(): string
            {
                return 'Should be a valid value';
            }
        };

        $property->expects(self::exactly(2))->method('getAttributes')->willReturn([$attribute]);
        $attribute->expects(self::exactly(2))->method('newInstance')->willReturn($attributeInstance);

        static::assertEquals(
            new ValidationResult(),
            PropertyValidator::validateProperty($property, 'foo')
        );
        static::assertEquals(
            (new ValidationResult())->addError('Should be a valid value'),
            PropertyValidator::validateProperty($property, 'bar')
        );
    }
}

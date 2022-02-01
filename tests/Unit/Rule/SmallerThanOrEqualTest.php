<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\SmallerThanOrEquals;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\SmallerThanOrEquals
 */
class SmallerThanOrEqualTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::float, Type::int, Type::array, Type::string],
            (new SmallerThanOrEquals(42))->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new SmallerThanOrEquals(3);

        static::assertTrue($rule->isValid(2));
        static::assertTrue($rule->isValid(2.0));
        static::assertTrue($rule->isValid([1,2]));
        static::assertTrue($rule->isValid('ab'));

        static::assertTrue($rule->isValid(3));
        static::assertTrue($rule->isValid(3.0));
        static::assertTrue($rule->isValid([1,2,3]));
        static::assertTrue($rule->isValid('abc'));

        static::assertFalse($rule->isValid(4));
        static::assertFalse($rule->isValid(4.0));
        static::assertFalse($rule->isValid([1,2,3,4]));
        static::assertFalse($rule->isValid('abcd'));
    }

    /**
     * @covers ::getMessage
     */
    public function testGetMessage(): void
    {
        static::assertSame(
            'Should be smaller than or equal to 42',
            (new SmallerThanOrEquals(42))->getMessage()
        );
    }
}

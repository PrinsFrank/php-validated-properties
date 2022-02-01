<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\SmallerThan;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\SmallerThan
 */
class SmallerThanTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::float, Type::int, Type::array, Type::string],
            (new SmallerThan(42))->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new SmallerThan(3);

        static::assertTrue($rule->isValid(2));
        static::assertTrue($rule->isValid(2.0));
        static::assertTrue($rule->isValid([1,2]));
        static::assertTrue($rule->isValid('ab'));

        static::assertFalse($rule->isValid(3));
        static::assertFalse($rule->isValid(3.0));
        static::assertFalse($rule->isValid([1,2,3]));
        static::assertFalse($rule->isValid('abc'));

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
            'Should be smaller than 42',
            (new SmallerThan(42))->getMessage()
        );
    }
}

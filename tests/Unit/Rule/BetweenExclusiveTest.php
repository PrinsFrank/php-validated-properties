<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\BetweenExclusive;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\BetweenExclusive
 */
class BetweenExclusiveTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::float, Type::int, Type::array, Type::string],
            (new BetweenExclusive(41,43))->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new BetweenExclusive(3,5);

        static::assertFalse($rule->isValid(3));
        static::assertFalse($rule->isValid(3.0));
        static::assertFalse($rule->isValid([1,2,3]));
        static::assertFalse($rule->isValid('abc'));

        static::assertTrue($rule->isValid(4));
        static::assertTrue($rule->isValid(4.0));
        static::assertTrue($rule->isValid([1,2,3,4]));
        static::assertTrue($rule->isValid('abcd'));

        static::assertFalse($rule->isValid(5));
        static::assertFalse($rule->isValid(5.0));
        static::assertFalse($rule->isValid([1,2,3,4,5]));
        static::assertFalse($rule->isValid('abcde'));
    }

    /**
     * @covers ::getMessage
     */
    public function testGetMessage(): void
    {
        static::assertSame(
            'Should be larger than 41 and smaller than 43',
            (new BetweenExclusive(41, 43))->getMessage()
        );
    }
}

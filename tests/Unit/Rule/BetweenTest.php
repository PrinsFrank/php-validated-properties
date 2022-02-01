<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\Between;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\Between
 */
class BetweenTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::float, Type::int, Type::array, Type::string],
            (new Between(41,43))->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new Between(3,5);

        static::assertFalse($rule->isValid(2));
        static::assertFalse($rule->isValid(2.0));
        static::assertFalse($rule->isValid([1,2]));
        static::assertFalse($rule->isValid('ab'));

        static::assertTrue($rule->isValid(3));
        static::assertTrue($rule->isValid(3.0));
        static::assertTrue($rule->isValid([1,2,3]));
        static::assertTrue($rule->isValid(4));
        static::assertTrue($rule->isValid(4.0));
        static::assertTrue($rule->isValid([1,2,3,4]));
        static::assertTrue($rule->isValid(5));
        static::assertTrue($rule->isValid(5.0));
        static::assertTrue($rule->isValid([1,2,3,4,5]));
        static::assertTrue($rule->isValid('abcde'));

        static::assertFalse($rule->isValid(6));
        static::assertFalse($rule->isValid(6.0));
        static::assertFalse($rule->isValid([1,2,3,4,5,6]));
        static::assertFalse($rule->isValid('abcdef'));
    }

    /**
     * @covers ::getMessage
     */
    public function testGetMessage(): void
    {
        static::assertSame(
            'Should be between 41 and 43',
            (new Between(41, 43))->getMessage()
        );
    }
}

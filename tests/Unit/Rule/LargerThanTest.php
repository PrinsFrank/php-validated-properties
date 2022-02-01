<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\LargerThan;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\LargerThan
 */
class LargerThanTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::float, Type::int, Type::array, Type::string],
            (new LargerThan(42))->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new LargerThan(3);

        static::assertFalse($rule->isValid(2));
        static::assertFalse($rule->isValid(2.0));
        static::assertFalse($rule->isValid([1,2]));
        static::assertFalse($rule->isValid('ab'));

        static::assertFalse($rule->isValid(3));
        static::assertFalse($rule->isValid(3.0));
        static::assertFalse($rule->isValid([1,2,3]));
        static::assertFalse($rule->isValid('abc'));

        static::assertTrue($rule->isValid(4));
        static::assertTrue($rule->isValid(4.0));
        static::assertTrue($rule->isValid([1,2,3,4]));
        static::assertTrue($rule->isValid('abcd'));
    }

    /**
     * @covers ::getMessage
     */
    public function testGetMessage(): void
    {
        static::assertSame(
            'Should be larger than 42',
            (new LargerThan(42))->getMessage()
        );
    }
}

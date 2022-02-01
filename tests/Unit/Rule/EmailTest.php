<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\Email;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\Email
 */
class EmailTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::string],
            (new Email())->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new Email();

        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid('foo'));
        static::assertFalse($rule->isValid('foo@example'));
        static::assertFalse($rule->isValid('example.com'));
        static::assertTrue($rule->isValid('foo@example.com'));
    }

    /**
     * @covers ::getMessage
     */
    public function testGetMessage(): void
    {
        static::assertSame(
            'Should be a valid email address',
            (new Email())->getMessage()
        );
    }
}

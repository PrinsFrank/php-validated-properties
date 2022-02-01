<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\Pattern;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\Pattern
 */
class PatternTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::string],
            (new Pattern('/^[0-9]$/'))->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new Pattern('/^[0-9]$/');

        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid('foo'));
        static::assertTrue($rule->isValid('0'));
    }

    /**
     * @covers ::getMessage
     */
    public function testGetMessage(): void
    {
        static::assertSame(
            'Should follow pattern "/^[0-9]$/"',
            (new Pattern('/^[0-9]$/'))->getMessage()
        );
    }
}

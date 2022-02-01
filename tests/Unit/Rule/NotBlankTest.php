<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\NotBlank;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\NotBlank
 */
class NotBlankTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::string],
            (new NotBlank())->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new NotBlank();

        static::assertFalse($rule->isValid(''));
        static::assertTrue($rule->isValid('foo'));
    }

    /**
     * @covers ::getMessage
     */
    public function testGetMessage(): void
    {
        static::assertSame(
            'Should not be blank',
            (new NotBlank())->getMessage()
        );
    }
}

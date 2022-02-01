<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Rule;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Enum\Type;
use PrinsFrank\PhpStrictModels\Rule\Url;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Rule\Url
 */
class UrlTest extends TestCase
{
    /**
     * @covers ::applicableToTypes
     */
    public function testGetApplicableTypes(): void
    {
        static::assertSame(
            [Type::string],
            (new Url())->applicableToTypes()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $rule = new Url();

        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid('foo'));
        static::assertFalse($rule->isValid('example.com'));
        static::assertTrue($rule->isValid('http://example.com'));
        static::assertTrue($rule->isValid('https://example.com'));
    }

    /**
     * @covers ::getMessage
     */
    public function testGetMessage(): void
    {
        static::assertSame(
            'Should be a valid URL',
            (new Url())->getMessage()
        );
    }
}

<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit\Validation;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Validation\ValidationResult;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Validation\ValidationResult
 */
class ValidationResultTest extends TestCase
{
    /**
     * @covers ::addError
     * @covers ::getErrors
     */
    public function testErrors(): void
    {
        $validationResult = new ValidationResult();
        static::assertSame([], $validationResult->getErrors());

        $validationResult->addError('foo');
        static::assertSame(['foo'], $validationResult->getErrors());

        $validationResult->addError('bar');
        static::assertSame(['foo', 'bar'], $validationResult->getErrors());
    }

    /**
     * @covers ::passes
     */
    public static function testPasses(): void
    {
        $validationResult = new ValidationResult();
        static::assertTrue($validationResult->passes());

        $validationResult->addError('foo');
        static::assertFalse($validationResult->passes());

        $validationResult->addError('bar');
        static::assertFalse($validationResult->passes());
    }
}

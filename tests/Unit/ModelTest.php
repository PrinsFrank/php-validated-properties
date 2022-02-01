<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Exception\InvalidModelException;
use PrinsFrank\PhpStrictModels\Exception\ValidationException;
use PrinsFrank\PhpStrictModels\Model;
use PrinsFrank\PhpStrictModels\Exception\NonExistingPropertyException;
use PrinsFrank\PhpStrictModels\Rule\Between;
use PrinsFrank\PhpStrictModels\Rule\NotBlank;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Model
 */
class ModelTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testsAllowsPublicPropertyWithoutRule(): void
    {
        /** @phpstan-ignore-next-line as this a scenario we want to test */
        new class extends Model {
            public int $foo;
        };
        $this->addToAssertionCount(1);
    }

    /**
     * @covers ::__construct
     */
    public function testsThrowsExceptionOnPublicProperty(): void
    {
        $this->expectException(InvalidModelException::class);
        $this->expectExceptionMessage('Model is invalid: "Public properties can\'t have validation rules, but a public property with name "foo" does."');
        /** @phpstan-ignore-next-line */
        new class extends Model {
            #[Between(41, 43)]
            public int $foo;
        };
    }

    /**
     * @covers ::__construct
     */
    public function testsThrowsExceptionOnPublicProperties(): void
    {
        $this->expectException(InvalidModelException::class);
        $this->expectExceptionMessage('Model is invalid: "Public properties can\'t have validation rules, but a public property with name "foo" does.","Public properties can\'t have validation rules, but a public property with name "bar" does."');
        /** @phpstan-ignore-next-line */
        new class extends Model {
            #[Between(41, 43)]
            public int $foo;

            #[NotBlank]
            public string $bar;
            protected float $baz;
        };
    }

    /**
     * @covers ::__construct
     */
    public function testEmptyObject(): void
    {
        new class extends Model {};
        $this->addToAssertionCount(1);
    }

    /**
     * @covers ::__set
     */
    public function testSetThrowsExceptionWhenPropertyNonExisting(): void
    {
        $model = new class extends Model {};

        $this->expectException(NonExistingPropertyException::class);
        $this->expectExceptionMessage('Property with name "foo" does not exist');
        /** @phpstan-ignore-next-line */
        $model->foo = 42;
    }

    /**
     * @covers ::__set
     * @covers ::__get
     */
    public function testCorrectSettingAndGetting(): void
    {
        $model = new class extends Model {
            protected int $foo;
        };
        $model->foo = 42;
        static::assertSame(42, $model->foo);
    }

    /**
     * @covers ::__set
     */
    public function testValidatesRuleForProperty(): void
    {
        $model = new class extends Model {
            #[Between(41, 44)]
            protected int $foo;
        };
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Value "0" for property "foo" is invalid: "Should be between 41 and 44"');
        $model->foo = 0;
    }
}

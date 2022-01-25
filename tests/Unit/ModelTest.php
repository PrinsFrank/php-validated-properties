<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PrinsFrank\PhpStrictModels\Exception\TypeException;
use PrinsFrank\PhpStrictModels\Exception\VisibilityException;
use PrinsFrank\PhpStrictModels\Model;
use PrinsFrank\PhpStrictModels\Exception\NonExistingPropertyException;

/**
 * @coversDefaultClass \PrinsFrank\PhpStrictModels\Model
 */
class ModelTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testsThrowsExceptionOnPublicProperty(): void
    {
        $this->expectException(VisibilityException::class);
        $this->expectExceptionMessage('Model should not have public properties, but has "foo"');
        new class extends Model {
            public int $foo;
        };
    }

    /**
     * @covers ::__construct
     */
    public function testsThrowsExceptionOnPublicProperties(): void
    {
        $this->expectException(VisibilityException::class);
        $this->expectExceptionMessage('Model should not have public properties, but has "foo,bar"');
        new class extends Model {
            public int $foo;
            public string $bar;
            protected array $baz;
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
        $model->foo = 42;
    }

    /**
     * @covers ::__set
     */
    public function testSetThrowsExceptionIfStrictAndNotSameType(): void
    {
        $model = new class extends Model {
            protected int $foo;
        };

        $this->expectException(TypeException::class);
        $this->expectExceptionMessage('Type of property with name "foo" is set to "int", "string" given');
        $model->foo = 'bar';
    }
}
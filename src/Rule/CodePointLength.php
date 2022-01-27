<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Rule;

use Attribute;
use PrinsFrank\PhpStrictModels\Enum\Type;

#[Attribute]
class CodePointLength implements Rule
{
    public function __construct(private int $length) { }

    /** @return Type[] */
    public function applicableToTypes(): array
    {
        return [Type::string];
    }

    /**
     * @param string $value
     */
    public function isValid(mixed $value): bool
    {
        return strlen($value) === $this->length;
    }

    public function getMessage(): string
    {
        return 'Should have a code point length of exactly ' . $this->length;
    }
}

<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Rule;

use Attribute;
use PrinsFrank\PhpStrictModels\Enum\Type;

#[Attribute]
class Pattern implements Rule
{
    public function __construct(private string $pattern) {}

    /** @return Type[] */
    public function applicableToTypes(): array
    {
        return [Type::string];
    }

    public function isValid(mixed $value): bool
    {
        return preg_match($this->pattern, $value) === 1;
    }

    public function getMessage(): string
    {
        return 'Should follow pattern "' . $this->pattern . '"';
    }
}

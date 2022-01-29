<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Rule;

use Attribute;
use PrinsFrank\PhpStrictModels\Enum\Type;

#[Attribute]
class Email implements Rule
{
    /** @return Type[] */
    public function applicableToTypes(): array
    {
        return [Type::string];
    }

    /** @param string $value */
    public function isValid(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getMessage(): string
    {
        return 'Should be a valid email address';
    }
}

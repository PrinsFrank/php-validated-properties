<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Rule;

use Attribute;
use PrinsFrank\PhpStrictModels\Enum\Type;

#[Attribute]
class NotBlank implements Rule
{
    /** @return Type[] */
    public function applicableToTypes(): array
    {
        return [Type::string];
    }

    /** @var string $value */
    public function isValid(mixed $value): bool
    {
        return $value !== '';
    }
}

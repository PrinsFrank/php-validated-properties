<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Rule;

use PrinsFrank\PhpStrictModels\Enum\Type;

interface Rule
{
    /** @return Type[] */
    public function applicableToTypes(): array;

    public function isValid(mixed $value): bool;
}

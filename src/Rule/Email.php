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
}

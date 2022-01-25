<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Enum;

enum Visibility: string
{
    case PUBLIC = 'public';
    case PROTECTED = 'protected';
    case PRIVATE = 'private';
}

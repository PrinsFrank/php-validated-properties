<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Enum;

enum ModelStrictness
{
    case STRICT;
    case CANONICAL;
    case LOSSLESS;
    case LAX;
}

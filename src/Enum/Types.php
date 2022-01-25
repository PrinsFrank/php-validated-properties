<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Enum;

enum Types: string
{
    case BOOL = 'bool';
    case INT = 'int';
    case FLOAT = 'float';
    case STRING = 'string';

    case ARRAY = 'array';
    case OBJECT = 'object';
    case CALLABLE = 'callable';
    case ITERABLE = 'iterable';

    case RESOURCE = 'resource';
    case NULL = 'null';
}

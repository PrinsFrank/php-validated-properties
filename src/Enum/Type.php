<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Enum;

enum Type: string
{
    case bool = 'bool';
    case int = 'integer';
    case float = 'float';
    case string = 'string';

    case array = 'array';
    case object = 'object';
    case callable = 'callable';
    case iterable = 'iterable';

    case resource = 'resource';
    case null = 'null';
}

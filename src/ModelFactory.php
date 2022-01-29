<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels;

use PrinsFrank\PhpStrictModels\Exception\InvalidArgumentException;

class ModelFactory
{
    /**
     * @param class-string<Model>|Model $model
     * @param array<string, mixed> $data
     * @throws InvalidArgumentException
     */
    public static function fromArray(string|Model $model, array $data): Model
    {
        /** @phpstan-ignore-next-line As PHPStan thinks the class-string is always a valid Model class, but that is not enforced yet */
        if (is_subclass_of($model, Model::class, true) === false) {
            throw new InvalidArgumentException('Only Models extending "' . Model::class . '" can be constructed using this factory');
        }

        $modelInstance = is_string($model) ? new $model() : $model;
        foreach ($data as $key => $value) {
            $modelInstance->{$key} = $value;
        }

        return $modelInstance;
    }

    /**
     * @param class-string<Model>|Model $model
     * @throws InvalidArgumentException
     */
    public static function fromObject(string|Model $model, object $data): Model
    {
        return static::fromArray($model, (array) $data);
    }
}

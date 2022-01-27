<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Rule;

use Attribute;
use PrinsFrank\PhpStrictModels\Enum\Type;

#[Attribute]
class LargerThan implements Rule
{
    public function __construct(private float|int $largerThan){}

    public function applicableToTypes(): array
    {
        return [Type::float, Type::int, Type::array];
    }

    /**
     * @param int|float|mixed[] $value
     */
    public function isValid(mixed $value): bool
    {
        if (is_array($value)) {
            $nrOfItemsInArray = count($value);

            return $nrOfItemsInArray > $this->largerThan;
        }

        return $value > $this->largerThan;
    }

    public function getMessage(): string
    {
        return 'Should be larger than ' . $this->largerThan;
    }
}
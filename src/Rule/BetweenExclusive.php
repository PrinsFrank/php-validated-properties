<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Rule;

use Attribute;
use PrinsFrank\PhpStrictModels\Enum\Type;

#[Attribute]
class BetweenExclusive implements Rule
{
    public function __construct(private float|int $largerThan, private float|int $smallerThan){}

    public function applicableToTypes(): array
    {
        return [Type::float, Type::int, Type::array, Type::string];
    }

    /**
     * @param int|float|string|mixed[] $value
     */
    public function isValid(mixed $value): bool
    {
        if (is_array($value)) {
            $nrOfItemsInArray = count($value);

            return $nrOfItemsInArray > $this->largerThan && $nrOfItemsInArray < $this->smallerThan;
        }

        if (is_string($value)) {
            $nrOfCharacters = mb_strlen($value);

            return $nrOfCharacters > $this->largerThan && $nrOfCharacters < $this->smallerThan;
        }

        return $value > $this->largerThan && $value < $this->smallerThan;
    }

    public function getMessage(): string
    {
        return 'Should be larger than ' . $this->largerThan . ' and smaller than ' . $this->smallerThan . '';
    }
}

<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Rule;

use Attribute;
use PrinsFrank\PhpStrictModels\Enum\Type;

#[Attribute]
class Between implements Rule
{
    public function __construct(private float|int $largerThanOrEquals, private float|int $smallerThanOrEquals){}

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

            return $nrOfItemsInArray >= $this->largerThanOrEquals && $nrOfItemsInArray <= $this->smallerThanOrEquals;
        }

        if (is_string($value)) {
            $nrOfCharacters = mb_strlen($value);

            return $nrOfCharacters >= $this->largerThanOrEquals && $nrOfCharacters <= $this->smallerThanOrEquals;
        }

        return $value >= $this->largerThanOrEquals && $value <= $this->smallerThanOrEquals;
    }

    public function getMessage(): string
    {
        return 'Should be between ' . $this->largerThanOrEquals . ' and ' . $this->smallerThanOrEquals . '';
    }
}

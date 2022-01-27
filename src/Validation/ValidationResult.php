<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Validation;

class ValidationResult
{
    /** @var string[] */
    private array $errors = [];

    public function addError(string $error): self
    {
        $this->errors[] = $error;

        return $this;
    }

    public function passes(): bool
    {
        return count($this->errors) === 0;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}

<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class NumberValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть числом';

    public function rule(): bool
    {
        return is_numeric($this->value);
    }
}
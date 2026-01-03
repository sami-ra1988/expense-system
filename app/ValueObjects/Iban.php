<?php

namespace App\ValueObjects;

use InvalidArgumentException;

class Iban
{
    public function __construct(private string $value)
    {
        if (strlen($value) < 2) {
            throw new InvalidArgumentException('Invalid IBAN');
        }
    }

    public function bankCode(): string
    {
        return substr($this->value, 0, 2);
    }

    public function value(): string
    {
        return $this->value;
    }
}

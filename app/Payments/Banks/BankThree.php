<?php

namespace App\Payments\Banks;

use App\Exceptions\BankException;
use App\Payments\BankInterface;
use App\ValueObjects\Iban;

class BankThree implements BankInterface
{
    private array $errors = [
        300 => 'Insufficient balance',
        301 => 'Daily limit exceeded',
        302 => 'Account blocked',
    ];

    public function transfer(Iban $iban, int $amount): void
    {
        // TODO: Call Bank One API
    }

    public function getErrorList(): array
    {
        return $this->errors;
    }

    private function throwBankError(int $code, Iban $iban): void
    {
        throw new BankException(
            $this->errors[$code] ?? 'Unknown error',
            $iban->bankCode(),
            $code
        );
    }
}

<?php

namespace App\Payments\Banks;

use App\Payments\BankInterface;
use App\ValueObjects\Iban;
use App\Exceptions\BankException;

class BankOne implements BankInterface
{
    private array $errors = [
        100 => 'Insufficient balance',
        101 => 'Daily limit exceeded',
        102 => 'Account blocked',
    ];

    public function transfer(Iban $iban, int $amount): void
    {
        //sample code
        if ($amount > 1000000) {
            $this->throwBankError(101, $iban);
        }

        // TODO: Bank API call
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

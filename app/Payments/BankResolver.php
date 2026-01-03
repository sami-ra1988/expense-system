<?php

namespace App\Payments;

use App\Payments\Banks\BankOne;
use App\Payments\Banks\BankTwo;
use App\Payments\Banks\BankThree;
use App\ValueObjects\Iban;
use Exception;

class BankResolver
{
    public function resolve(Iban $iban): BankInterface
    {
        return match ($iban->bankCode()) {
            '11' => new BankOne(),
            '22' => new BankTwo(),
            '33' => new BankThree(),
            default => throw new Exception('Unsupported bank'),
        };
    }
}

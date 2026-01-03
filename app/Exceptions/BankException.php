<?php
namespace App\Exceptions;

use Exception;
class BankException extends Exception
{
    public function __construct(
        string $message,
        public ?string $bankCode = null,
        public ?int $errorCode = null
    ) {
        parent::__construct($message);
    }
}

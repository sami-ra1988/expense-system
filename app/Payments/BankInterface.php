<?php

namespace App\Payments;

use App\ValueObjects\Iban;


interface BankInterface
{
    /**
     * انتقال وجه به حساب مقصد
     *
     * @param Iban $iban مقصد
     * @param int $amount مبلغ
     * @throws BankException در صورت خطای بانکی
     */
    public function transfer(Iban $iban, int $amount): void;

    /**
     * دریافت لیست خطاهای احتمالی بانک
     *
     * @return array<int, string>  // key: کد خطا، value: پیام خطا
     */
    public function getErrorList(): array;
}

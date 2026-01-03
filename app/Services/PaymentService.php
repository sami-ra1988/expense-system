<?php

namespace App\Services;

use App\Models\ExpenseRequest;
use App\Enums\ExpenseStatus;
use App\Notifications\NotificationService;
use App\Payments\BankResolver;
use App\ValueObjects\Iban;
use App\Exceptions\BankException;

class PaymentService
{
    public function __construct(private BankResolver $resolver, private NotificationService $notifier) {}

    public function pay(ExpenseRequest $expense): void
    {
        $iban = new Iban($expense->iban);

        try {
            $bank = $this->resolver->resolve($iban);

            $bank->transfer($iban, $expense->amount);

            $expense->payments()->create([
                'bank_code' => $iban->bankCode(),
                'status' => 'success'
            ]);

            $expense->update(['status' => ExpenseStatus::PAID]);

            $this->notifier->notifyPaymentSuccess($expense);

        } catch (BankException $e) {
            $expense->payments()->create([
                'bank_code' => $e->bankCode ?? $iban->bankCode(),
                'status' => 'failed',
                'error_code' => $e->errorCode,
                'error_message' => $e->getMessage(),
            ]);

            $this->notifier->notifyPaymentFailure($expense, $e->getMessage());

        } catch (\Throwable $e) {
            $expense->payments()->create([
                'bank_code' => $iban->bankCode(),
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}

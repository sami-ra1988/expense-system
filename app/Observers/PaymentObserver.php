<?php


namespace App\Observers;

use App\Models\Payment;
use App\Models\PaymentLog;

class PaymentObserver
{
    /**
     * Handle after a payment is created.
     */
    public function created(Payment $payment): void
    {
        PaymentLog::create([
            'payment_id' => $payment->id,
            'level' => $payment->status === 'success' ? 'info' : 'error',
            'message' => $payment->status === 'success' ? 'Payment successful' : $payment->error_message,
            'context' => [
                'expense_id' => $payment->expense_request_id,
                'bank_code' => $payment->bank_code,
            ],
        ]);
    }
}

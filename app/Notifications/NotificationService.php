<?php

namespace App\Notifications;

use App\Models\ExpenseRequest;

class NotificationService
{
    public function notifyReject(ExpenseRequest $expense): void
    {
        // TODO: Send SMS to user

        // Mail::to($expense->user->email)
        //     ->send(new ExpenseRejectedMail($expense));
    }

    public function notifyPaymentSuccess(ExpenseRequest $expense): void
    {
        // TODO: Send payment success SMS to {$expense->user->mobile}

        // echo "Email sent to {$expense->user->email}";
    }

    public function notifyPaymentFailure(ExpenseRequest $expense): void
    {
        // TODO: Send payment failure SMS to {$expense->user->mobile}

        // echo "Email sent to {$expense->user->email}";
    }
}

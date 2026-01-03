<?php

namespace App\Jobs;

use App\Models\ExpenseRequest;
use App\Services\PaymentService;
use App\Enums\ExpenseStatus;

class ScheduledPaymentJob
{
    public function handle(PaymentService $service)
    {
        $expenses = ExpenseRequest::where('status', ExpenseStatus::APPROVED)->get();

        foreach ($expenses as $expense) {
            $service->pay($expense);
        }
    }
}

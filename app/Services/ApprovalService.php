<?php

namespace App\Services;

use App\Enums\ExpenseStatus;
use App\Models\ExpenseRequest;
use App\Notifications\NotificationService;
use Illuminate\Support\Facades\Log;

class ApprovalService
{
    public function __construct(private PaymentService $paymentService, private NotificationService $notifier) {}
    public function process(array $ids, string $action, ?string $reason = null): void
    {
        $expenses = ExpenseRequest::whereIn('id', $ids)->get();

        foreach ($expenses as $expense) {
            if ($action === 'approve') {

                $expense->update(['status' => ExpenseStatus::APPROVED]);

                Log::info("ExpenseRequest approved", [
                    'expense_id' => $expense->id,
                    'user_id' => $expense->user_id,
                ]);

                // Manual payment or scheduled
                try {
                    $this->paymentService->pay($expense);
                } catch (\Throwable $e) {
                    Log::error("Manual payment failed for approved ExpenseRequest", [
                        'expense_id' => $expense->id,
                        'error' => $e->getMessage()
                    ]);
                }


            } else {
                $expense->update([
                    'status' => ExpenseStatus::REJECTED,
                    'reject_reason' => $reason
                ]);

                Log::warning("ExpenseRequest rejected", [
                    'expense_id' => $expense->id,
                    'user_id' => $expense->user_id,
                    'reason' => $reason,
                ]);

                // Notification
                $this->notifier->notifyReject($expense);

            }
        }
    }
}

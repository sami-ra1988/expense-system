<?php

namespace App\Http\Controllers;

use App\Enums\ExpenseStatus;
use App\Http\Controllers\Controller;
use App\Models\ExpenseRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function manual(Request $request, PaymentService $service)
    {
        $ids = $request->input('expense_ids', []);

        $expenses = ExpenseRequest::whereIn('id', $ids)
            ->where('status', ExpenseStatus::APPROVED)
            ->get();

        foreach ($expenses as $expense) {
            $service->pay($expense);
        }

        return response()->json(['message' => 'Payment triggered']);
    }
}

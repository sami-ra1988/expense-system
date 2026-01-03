<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ExpenseRequestController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('expense_requests')->group(function () {


    Route::get('/approvals', [ExpenseRequestController::class, 'approvals'])
        ->name('expense_requests.approvals');

    Route::get('/create', [ExpenseRequestController::class, 'create'])
        ->name('expense_requests.create');

    Route::post('/store', [ExpenseRequestController::class, 'store'])
        ->name('expense_requests.store');

    Route::get('/{expenseRequest}/download', [ExpenseRequestController::class, 'download'])
        ->name('expense_requests.download');


    Route::post('/bulk-approve', [ApprovalController::class, 'bulkApprove'])
        ->name('expense_requests.bulk_approve');

    Route::post('/bulk-reject', [ApprovalController::class, 'bulkReject'])
        ->name('expense_requests.bulk_reject');

    Route::post('/{expenseRequestId}/approve', [ApprovalController::class, 'approve'])
        ->name('expense_requests.approve');

    Route::post('/{expenseRequestId}/reject', [ApprovalController::class, 'reject'])
        ->name('expense_requests.reject');


    Route::get('/{expenseRequest}', [ExpenseRequestController::class, 'show'])
        ->name('expense_requests.show');
});

Route::post('payments/manual', [PaymentController::class, 'manual']);


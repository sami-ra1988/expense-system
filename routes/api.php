<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseRequestController;


Route::prefix('api')->group(function () {


    Route::prefix('expense_requests')->group(function () {
        Route::post('/', [ExpenseRequestController::class, 'store']);
    });

});


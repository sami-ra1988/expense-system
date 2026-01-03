<?php

namespace App\Services;

use App\Models\User;
use App\Models\ExpenseRequest;
use App\Enums\ExpenseStatus;

class ExpenseService
{
    public function create(array $data): ExpenseRequest
    {
        $user = User::where('national_code', $data['national_code'])->firstOrFail();

        return ExpenseRequest::create([
            'user_id'     => $user->id,
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'amount'      => $data['amount'],
            'iban'        => $data['iban'],
            'status'      => ExpenseStatus::PENDING,
        ]);
    }
}

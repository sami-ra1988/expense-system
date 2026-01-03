<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'expense_request_id',
        'bank_code',
        'status',
        'error_message',
    ];

    public function expenseRequest()
    {
        return $this->belongsTo(ExpenseRequest::class);
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class);
    }
}

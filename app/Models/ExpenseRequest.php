<?php

namespace App\Models;

use App\Enums\ExpenseStatus;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseRequest extends Model
{
    use SoftDeletes, HasMedia;

    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'amount',
        'iban',
        'status',
        'reject_reason',
    ];

    protected $casts = [
        'status' => ExpenseStatus::class,
    ];

    /* ================= Relations ================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /* ================= Scopes ================= */

    public function scopeApproved($query)
    {
        return $query->where('status', ExpenseStatus::APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', ExpenseStatus::PENDING);
    }
}

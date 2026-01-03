<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payment_id',
        'level',
        'message',
        'context',
    ];

    protected $casts = [
        'context' => 'array',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}

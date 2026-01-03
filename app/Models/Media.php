<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'media';

    protected $fillable = [
        'mediable_id',
        'mediable_type',
        'file_path',
        'original_name',
    ];

    public function getPath(): string
    {
        return $this->file_path;
    }
    public function mediable()
    {
        return $this->morphTo();
    }
}

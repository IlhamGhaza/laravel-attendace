<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendace extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'time_in',
        'time_out',
        'latlon_in',
        'latlon_out',
        'is_late',
        'is_overtime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

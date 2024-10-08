<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrAbsen extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        // 'user_id',
        // 'company_id',
        'date',
        'qr_checkin',
        'qr_checkout',
    ];
}

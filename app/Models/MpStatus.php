<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpStatus extends Model
{
    use HasFactory;

    protected $table = 'mp_status';

    protected $fillable = [
        'uniqueid', 'desc'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}

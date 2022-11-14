<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'code', 'title', 'duration', 'payment_type', 'description'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}

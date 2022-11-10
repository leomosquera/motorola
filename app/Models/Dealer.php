<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Usuario;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'name', 'code', 'contact', 'email', 'phone', 'image'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

}

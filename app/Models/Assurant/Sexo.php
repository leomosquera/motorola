<?php

namespace App\Models\Assurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    use HasFactory;
    protected $table = 'assurant_sexo';

    protected $fillable = [
        'cod', 'desc'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}

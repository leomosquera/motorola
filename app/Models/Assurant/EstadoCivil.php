<?php

namespace App\Models\Assurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    use HasFactory;
    protected $table = 'assurant_estado_civil';

    protected $fillable = [
        'cod', 'desc'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}

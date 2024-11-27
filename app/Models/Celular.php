<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celular extends Model
{
    use HasFactory;
    protected $table = 'celulares';

    protected $fillable = [
        'status', 'code', 'name', 'gama', 'discontinuado', 'cobertura', 'elita', 'precio_bruto_equipo', 'precio_seguro', 'version'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}

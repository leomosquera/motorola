<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celular extends Model
{
    use HasFactory;
    protected $table = 'celulares';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($celular) {
            // Solo al crear, no al actualizar
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $celular->code = substr(str_shuffle($permitted_chars), 0, 4) . uniqid();
            $celular->status = 1;
        });
    }

    protected $fillable = [
        'sku', 'name', 'gama', 'discontinuado', 'cobertura', 'elita', 'precio_bruto_equipo', 'precio_seguro', 'version'
    ];

    protected $guarded = [
        'id', 'status', 'code', 'created_at', 'updated_at'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioHistory extends Model
{
    use HasFactory;
    protected $table = 'usuario_history';

    protected $fillable = [
        'usuario_id', 'type', 'ip_info'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id'); // Uno a muchos
    }
}

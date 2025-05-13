<?php

namespace App\Models\Assurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assurant;

class Localidad extends Model
{
    use HasFactory;
    protected $table = 'assurant_localidades';

    protected $fillable = [
        'status', 'provincia_cod', 'cod', 'nombre', 'cp', 'preftel'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
    
    public function provincia(){
        return $this->belongsTo(Assurant\Provincia::class, 'provincia_cod', 'cod'); // Uno a muchos
    }

}

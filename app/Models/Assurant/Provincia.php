<?php

namespace App\Models\Assurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assurant;

class Provincia extends Model
{
    use HasFactory;
    protected $table = 'assurant_provincias';

    protected $fillable = [
        'cod', 'brand_code', 'nombre'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function localidades(){
        return $this->belongsToMany(Assurant\Localidad::class, 'assurant_localidades');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models;
use App;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id', 'status', 'name', 'date_start', 'date_end', 'url', 'privacy_policy', 'terms_conditions', 'google_analytics'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function usuario(){
        return $this->belongsTo(Models\Usuario::class, 'usuario_id', 'id'); // Uno a muchos
    }
}

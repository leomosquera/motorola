<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dealer;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'dealer_id', 'name', 'uniqueid', 'code', 'contact', 'address', 'location', 'email', 'phone', 'image'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function dealer(){
        return $this->belongsTo(Dealer::class, 'dealer_id', 'id'); // Uno a muchos
    }
}

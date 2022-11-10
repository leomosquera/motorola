<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function products(){
        return $this->belongsToMany(App\Product::class);
    }

}

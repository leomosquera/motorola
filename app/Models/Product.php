<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_type_id', 'product_family_id', 'status', 'sku', 'name', 'description', 'elita', 'image'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function product_type(){
        return $this->belongsTo(Models\ProductType::class, 'product_type_id', 'id'); // Uno a muchos
    }

    public function product_family(){
        return $this->belongsTo(Models\ProductFamily::class, 'product_family_id', 'id'); // Uno a muchos
    }

    public function prices(){
        return $this->hasMany(Models\ProductPrice::class, 'product_id', 'id');
    }

    /*
    public function budgetById($training_id){
    // = in where is optional in this case
    $this->belongsToMany('Budget')->where('training_id', '=', $training_id);
    }
    */

}

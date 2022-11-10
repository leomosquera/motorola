<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models;

class ProductPrice extends Model
{
    use HasFactory;

    protected $table = 'product_price';

    protected $fillable = [
       'product_id', 'coverage', 'duration', 'idnewsanmotocare', 'price_gross', 'price_insured', 'price_deductible'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function product(){
        return $this->belongsTo(Models\Product::class, 'product_id', 'id'); // Uno a muchos
    }
}

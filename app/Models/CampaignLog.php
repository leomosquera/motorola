<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models;
use App;

class CampaignLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id', 'campaign_id', 'store_id', 'campaign_info', 'id_log', 'payment_code', 'url_referer_encrypt', 'url_referer_decrypt', 'body', 'services', 'params', 'event', 'ip_info'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function usuario(){
        return $this->belongsTo(Models\Usuario::class, 'usuario_id', 'id'); // Uno a muchos
    }

    public function campaign(){
        return $this->belongsTo(Models\Campaign::class, 'campaign_id', 'id'); // Uno a muchos
    }

    public function store(){
        return $this->belongsTo(Models\Store::class, 'store_id', 'id'); // Uno a muchos
    }
}

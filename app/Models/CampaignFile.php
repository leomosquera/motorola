<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignFile extends Model
{
    use HasFactory;
    
    protected $table = 'campaign_files';

    protected $fillable = [
        'txt_name',
        'zip_name',
        'txt_path',
        'zip_path',
        'day',
        'status',
        'error_message',
        'sent_at',
    ];
}

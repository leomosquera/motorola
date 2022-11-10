<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'alert_type_id', 'status', 'title', 'info', 'icon', 'date_start', 'date_end'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'alert_role');
    }
}

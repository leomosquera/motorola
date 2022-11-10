<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function alerts(){
        return $this->belongsToMany(Alert::class, 'alert_role')->where('status', 1);
    }

    public function usuarios(){
        return $this->belongsToMany(Usuario::class, 'usuario_role');
    }

    public static function sessRoleExist($role){
        if(Session::has('role_id')){
            return Session::get('role_name') == $role;
        }else{
            $collRoles = collect(Session::get('roles'));
            return in_array($role,$collRoles->pluck('name')->toArray());
        }
    }
}

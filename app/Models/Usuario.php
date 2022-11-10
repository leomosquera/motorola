<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use Storage;
use Config;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $remember_token = false;

    protected $fillable = [
        'username', 'email', 'password', 'password_changed', 'name', 'lastname', 'image'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'usuario_role');
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_usuario');
    }

    public function history_logged()
    {
        return $this->hasMany(UsuarioHistory::class, 'usuario_id', 'id')->where('type', Config::get('models.usuario.history.type')['logged']);
    }

    public static function setUsuarioAvatar($image, $current = null, $delete = 0)
    {
        $dir = Config::get('models.usuario.avatar.dir');
        if (strlen($image) > 50) {
            if ($current && Storage::disk('public')->exists($dir . $current)) {
                Storage::disk('public')->delete($dir . $current);
            }
            $image_data = $image;
            $image_array_1 = explode(";", $image_data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $image_name = Str::random(20) . '.png';
            Storage::disk('public')->put($dir . $image_name, $data);
            return $image_name;
        } else if ($delete == 1) {
            if ($current && Storage::disk('public')->exists($dir . $current)) {
                Storage::disk('public')->delete($dir . $current);
            }
            return null;
        } else {
            return $current;
        }
    }
}

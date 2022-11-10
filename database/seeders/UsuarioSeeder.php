<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        Usuario::truncate(); // Evita duplicar datos

        $usuario = new Usuario();
        $usuario->username         = 'motorola';
        $usuario->email            = 'admin@motorola.com.ar';
        $usuario->password         = bcrypt('123123123');
        $usuario->password_changed = 1;
        $usuario->name             = 'Motorola';
        $usuario->lastname         = '';
        $usuario->save();
        $usuario->roles()->attach([1,2]);

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}

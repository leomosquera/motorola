<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        Role::truncate(); // Evita duplicar datos

        $role = new Role();
        $role->name        = "superadmin";
        $role->description = "Usted obtiene permisos y privilegios de tipo Super Admin.";
        $role->save();

        $role = new Role();
        $role->name = "usuario";
        $role->description = "Usted obtiene permisos y privilegios de tipo Usuario.";
        $role->save();

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}

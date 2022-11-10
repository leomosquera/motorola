<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(DealerSeeder::class);
        $this->call(ProductTypeSeeder::class);
        $this->call(ProductFamilySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(AssurantProvinciaSeeder::class);
        $this->call(AssurantLocalidadSeeder::class);
        $this->call(AssurantSexoSeeder::class);
    }
}

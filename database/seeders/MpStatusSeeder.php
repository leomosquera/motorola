<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\MpStatus;

class MpStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MpStatus::truncate(); // Evita duplicar datos

        $data = new MpStatus();
        $data->uniqueid = Str::uuid()->toString();
        $data->desc     = "success";
        $data->save();

        $data = new MpStatus();
        $data->uniqueid = Str::uuid()->toString();
        $data->desc     = "failure";
        $data->save();

        $data = new MpStatus();
        $data->uniqueid = Str::uuid()->toString();
        $data->desc     = "pending";
        $data->save();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Client;
use App\Models\Assurant\Provincia;

class AssurantProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private static function api(){
        return config('enviroment.assurant');
    }

    public function run()
    {
        //servicio assurant
        $url = self::api()['url'].'twgewcodlist.php';
        $client = new Client();
        $response = $client->request('POST', $url, [
            'auth' => [
                self::api()['auth']['user'],
                self::api()['auth']['pass']
            ],
            'body' => json_encode(
                [
                    'acc'  => 'LProv',
                    'pais' => 1
                ]
            )
        ]);
        //obtengo
        $response_statuscode = $response->getStatusCode();
        $response_contents   = $response->getBody()->getContents();
        $json = json_decode($response_contents, true);

        foreach ($json['provincia'] as $valor){
            $data = new Provincia();
            $data->cod    = $valor['cod'];
            $data->nombre = $valor['nombre'];
            $data->save();
        }
    }
}

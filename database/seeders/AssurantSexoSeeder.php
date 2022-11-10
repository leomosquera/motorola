<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Client;
use App\Models\Assurant\Sexo;

class AssurantSexoSeeder extends Seeder
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
                    'acc'    => 'LSex'
                ]
            )
        ]);
        //obtengo
        $response_statuscode = $response->getStatusCode();
        $response_contents   = $response->getBody()->getContents();
        $json = json_decode($response_contents, true);

        foreach ($json['sexo'] as $valor){
            $data = new Sexo();
            $data->cod  = $valor['cod'];
            $data->desc = $valor['desc'];
            $data->save();
        }
    }
}

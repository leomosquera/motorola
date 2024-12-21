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
            'verify' => false,
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

        //provincias code 2 chars
        $arr_provincia = [ 
            'B' => 'BA',
            'C' => 'CF',
            'K' => 'CT',
            'H' => 'CC',
            'U' => 'CH',
            'X' => 'CB',
            'W' => 'CN',
            'E' => 'ER',
            'P' => 'FM',
            'Y' => 'JY',
            'L' => 'LP',
            'F' => 'LR',
            'M' => 'MZ',
            'N' => 'MN',
            'Q' => 'NQ',
            'R' => 'RN',
            'A' => 'SA',
            'J' => 'SJ',
            'D' => 'SL',
            'Z' => 'SC',
            'S' => 'SF',
            'G' => 'SE',
            'V' => 'TF',
            'T' => 'TM',
        ];

        foreach ($json['provincia'] as $valor){
            $data = new Provincia();
            $data->cod         = $valor['cod'];
            $data->branch_code = $arr_provincia[$valor['cod']];
            $data->nombre      = $valor['nombre'];
            $data->save();
        }
    }
}

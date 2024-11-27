<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Client;
use App\Models\Assurant;

class AssurantLocalidadSeeder extends Seeder
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
        $provincia = Assurant\Provincia::all();
        foreach ($provincia as $prov){
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
                        'acc'    => 'LLoc',
                        'pais'   => 1,
                        'prov'   => $prov->cod,
                        'cp'     => 0,
                        'nomloc' => ''
                    ]
                )
            ]);

            $response_statuscode = $response->getStatusCode();
            $response_contents   = $response->getBody()->getContents();
            $json = json_decode($response_contents, true);

            foreach ($json['localidad'] as $loc){
                $data  = Assurant\Localidad::
                whereRaw('LOWER(`nombre`) LIKE ? ',[trim(strtolower($loc['nombre'])).'%'])
                ->where('cp',$loc['cp']);
                if($data->count() == 0 && intval($loc['cp']) > 0){
                    $data = new Assurant\Localidad();
                    $data->provincia_cod = $prov->cod;
                    $data->cod           = $loc['cod'];
                    $data->nombre        = $loc['nombre'];
                    $data->cp            = $loc['cp'];
                    $data->preftel       = $loc['preftel'];
                    $data->save();
                }
            }
        }
    }
}

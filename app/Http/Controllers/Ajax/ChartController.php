<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models;
use Validator;
use Storage;
use Config;
use Datatables;
use Helper;

class ChartController extends Controller
{
    public function apexArea(Request $request){
        //$data = Models\InspectionCar::where('id', $request->id)->first() ?? false;
        //$request->db = 'inspection-car';
        //$request->period = 'last-week';

        switch ($request->period) {
            case 'last-week':
                $date_start = Carbon::now()->subDays(23);
                $date_end   = Carbon::now()->subDays(16);
                $period     = new CarbonPeriod( $date_start->format('Y-m-d'), '1 days', $date_end->format('Y-m-d') );
            break;
            case 'last-month':
                $date_start = Carbon::now()->subMonth();
                $date_end   = Carbon::now();
                $period     = new CarbonPeriod( $date_start->format('Y-m-d'), '1 months', $date_end->format('Y-m-d') );
            break;
            case 'last-year':
                $date_start = Carbon::now()->subYear();
                $date_end   = Carbon::now();
                $period     = new CarbonPeriod( $date_start->format('Y-m-d'), '1 months', $date_end->format('Y-m-d') );
            break;
        }

        switch ($request->db) {
            case 'inspection-car':
                $data = [
                    'series' =>
                    [
                        [
                            'name' => 'Inspecciones',
                            'data' => array()
                        ]
                    ],
                    'xaxis' => 
                    [
                        'categories' => array()
                    ]
                ];
            break;
            case 'inspection-boat':
                $data = [
                    'series' =>
                    [
                        [
                            'name' => 'Inspecciones',
                            'data' => array()
                        ]
                    ],
                    'xaxis' => 
                    [
                        'categories' => array()
                    ]
                ];
            break;
            case 'sinister-car':
                $data = [
                    'series' =>
                    [
                        [
                            'name' => 'Siniestros',
                            'data' => array()
                        ]
                    ],
                    'xaxis' => 
                    [
                        'categories' => array()
                    ]
                ];
            break;
        }

        foreach ($period as $date) {
            switch ($request->db) {
                case 'inspection-car':
                    array_push(
                        $data['series'][0]['data'],
                        Models\InspectionCar::where('date', 'like', '%'.$date->format('Y-m-d').'%')
                        ->count()
                    );
                break;
                case 'inspection-boat':
                    array_push(
                        $data['series'][0]['data'],
                        Models\InspectionBoat::where('date', 'like', '%'.$date->format('Y-m').'%')
                        ->count()
                    );
                break;
                case 'sinister-car':
                    array_push(
                        $data['series'][0]['data'],
                        Models\SinisterCar::where('date', 'like', '%'.$date->format('Y-m').'%')
                        ->count()
                    );
                break;
            }
            switch ($request->period) {
                case 'last-week':
                    array_push(
                        $data['xaxis']['categories'],
                        Config::get('global.date.days.'.$date->format('w'))
                    );
                break;
                case 'last-month':
                    array_push(
                        $data['xaxis']['categories'],
                        $date->format('m/Y')
                    );
                break;
                case 'last-year':
                    array_push(
                        $data['xaxis']['categories'],
                        $date->format('m/Y')
                    );
                break;
            }
        }

        return \Response::json(array('response' => ['success', 'Correctamente!'], 'data' => $data));
    }

}

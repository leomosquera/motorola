<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models;
use File;
use ZipArchive;
use Storage;
use URL;
use Config;

class ZipFilesController extends Controller
{
    public function inspCar($id = 0)
    {
        $data = Models\InspectionCar::where('id', $id)->first() ?? false;
        //dd($data->images()->count());
        //dd(md5(uniqid(rand(), true)));
        if($data && $data->images()->count() > 0){
            $zip  = new ZipArchive;
            $dirFiles = Config::get('models.inspection-car.image.dir');
            $fileName = $data->patent.'-'.md5(uniqid(rand(),true)).'.zip';

            //dd(555);
            if ($zip->open(Storage::path(Config::get('global.storage.temp').$fileName), ZipArchive::CREATE) === TRUE)
            {
                $files = [];
                foreach ($data->images()->get() as $key => $value) {
                    if (Storage::exists($dirFiles.$value->image)) {
                        array_push($files, Storage::path($dirFiles.$value->image));
                    }
                }
                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
                $zip->close();
            }
            return response()->download(Storage::path(Config::get('global.storage.temp').$fileName));
        }else{
            return response()->false();
        }
    }
}

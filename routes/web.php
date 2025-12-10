<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificadoHTML;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('{any}', function () {
    return response()->json([
        'status' => 'API running',
        'version' => '1.0',
        'message' => 'OK'
    ]);
})->where('any', '.*');

//Stores
//Route::get( '/stores',               'HomeController@stores')->name('stores');
//Route::get( '/stores/history/sales', 'HomeController@storesHistorySalesByDealer')->name('stores-history-sales');
//Route::get( '/stores/qr',            'HomeController@storesQr')->name('stores-qr');
//Route::get( '/stores/migration',     'HomeController@storesMigration')->name('stores-migration');

//Main reenvio
//Route::get( '/mail/envio',        'HomeController@mailEnvio')->name('mail-envio');

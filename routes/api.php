<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'],
    function () {
        Route::post('/',    [Controllers\AuthController::class, 'login']);
        //Route::post('register', [Controllers\AuthController::class, 'register']);
        Route::get('version', [Controllers\Api\AppController::class, 'version']);
    }
);
Route::group(['middleware' => 'auth:api'],
    function() {
        Route::get('campaign/{id?}',                   [Controllers\Api\CampaignController::class, 'campaign']);
        Route::get('campaign/log/info',                [Controllers\Api\CampaignLogController::class, 'info']);
        Route::get('campaign/log/info/idlog/{id_log?}',[Controllers\Api\CampaignLogController::class, 'infoByIdlog']);
        Route::put('campaign/log/store',               [Controllers\Api\CampaignLogController::class, 'store']);
        Route::put('campaign/log/update',              [Controllers\Api\CampaignLogController::class, 'update']);
        Route::get('coverage',                         [Controllers\Api\CoverageController::class, 'info']);
        Route::get('products/name',                    [Controllers\Api\ProductController::class, 'productName']);
        Route::get('products/byname/{name?}',          [Controllers\Api\ProductController::class, 'productByName']);
        Route::get('products/price/idnew/{idnew?}',    [Controllers\Api\ProductController::class, 'productPriceByIdnew']);
        Route::get('assurant/provincias',              [Controllers\Api\AssurantController::class, 'provincias']);
        Route::get('assurant/localidades/{code?}',     [Controllers\Api\AssurantController::class, 'localidades']);
        Route::get('assurant/estadocivil',             [Controllers\Api\AssurantController::class, 'estadocivil']);
        Route::get('assurant/sexo',                    [Controllers\Api\AssurantController::class, 'sexo']);
    }
);

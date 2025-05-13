<?php

use Illuminate\Support\Facades\Route;

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

// Login
/*
Route::get( 'login',  'LoginController@index')->name('login');
Route::post('login',  'LoginController@login')->name('login-post');
Route::post('logout', 'LoginController@logout')->name('login-logout');

// Errors
Route::get( '404', 'PageController@error404')->name('404');
Route::get( '419', 'PageController@error419')->name('419');
Route::get( '/pruebas', 'HomeController@pruebas')->name('pruebas');
*/

//Stores
Route::get( '/stores',               'HomeController@stores')->name('stores');
Route::get( '/stores/history/sales', 'HomeController@storesHistorySalesByDealer')->name('stores-history-sales');
Route::get( '/stores/qr',            'HomeController@storesQr')->name('stores-qr');
Route::get( '/stores/migration',     'HomeController@storesMigration')->name('stores-migration');
Route::get( '/products/migration',   'HomeController@productsMigration')->name('products-migration');

//Celulares
Route::get( '/celulares/confirm', 'HomeController@celularesConfirm')->name('celulares-confirm');
Route::get( '/celulares/update',  'HomeController@celularesUpdate')->name('celulares-update');

/*
// Home
Route::get( '/',                   'HomeController@index')->name('home')->middleware('auth');
Route::get( '/login-role',         'HomeController@loginRole')->name('login-role')->middleware('auth');
Route::post('/login-role',         'HomeController@loginRoleSelected')->name('login-role')->middleware('auth');
Route::post('/login-role-change',  'HomeController@loginRoleChange')->name('login-role-change')->middleware('auth');
Route::get( '/login/usuario/error','HomeController@loginUsuarioError')->name('login-usuario-error')->middleware('auth');
Route::get( '/password/change',    'HomeController@passwordChange')->name('password-change')->middleware('auth');
Route::post('/password/change',    'HomeController@passwordChangeStore')->name('password-change')->middleware('auth');
Route::get( '/exit',               'HomeController@exit')->name('exit');

// Super Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'superadmin']], function(){
    //Admin Account
    Route::get('account/edit',   'AdminAccountController@edit')->name('admin-account-edit');

    // Inspection Cars
    Route::get( 'inspection/car',                'InspectionCarController@index')->name('inspection-car');
    Route::get( 'inspection/car/ftp',            'InspectionCarController@ftp')->name('inspection-car-ftp');
    Route::post('inspection/car/dt',             'InspectionCarController@indexDt')->name('inspection-car-dt');
    Route::get( 'inspection/car/create',         'InspectionCarController@create')->name('inspection-car-create');
    Route::post('inspection/car/store',          'InspectionCarController@store')->name('inspection-car-store');
    Route::get( 'inspection/car/edit/{id?}',     'InspectionCarController@edit')->name('inspection-car-edit');
    Route::put( 'inspection/car/update/{id}',    'InspectionCarController@update')->name('inspection-car-update');
    Route::post('inspection/car/destroy',        'InspectionCarController@destroy')->name('inspection-car-destroy');
    Route::get( 'inspection/car/image/edit/{id}','InspectionCarController@imageEdit')->name('inspection-car-image-edit');
    Route::post('inspection/car/image/replace',  'InspectionCarController@imageReplace')->name('inspection-car-image-replace');
    Route::post('inspection/car/image/destroy',  'InspectionCarController@imageDestroy')->name('inspection-car-image-destroy');
    Route::get( 'inspection/car/gnc/edit/{id}',  'InspectionCarController@gncEdit')->name('inspection-car-gnc-edit');
    Route::post('inspection/car/gnc/replace',    'InspectionCarController@gncReplace')->name('inspection-car-gnc-replace');
    Route::get('inspection/car/charts',          'InspectionCarController@charts')->name('inspection-car-charts');
    Route::post('inspection/car/chart/line/month','InspectionCarController@chartLineMonth')->name('inspection-car-chart-line-month');
    Route::post('inspection/car/chart/line/month/compare','InspectionCarController@chartLineMonthCompare')->name('inspection-car-chart-line-month-compare');
    Route::post('inspection/car/chart/bar/month/compare','InspectionCarController@chartBarMonthCompare')->name('inspection-car-chart-bar-month-compare');
    Route::post('inspection/car/speedway',        'InspectionCarController@speedway')->name('inspection-car-speedway');
    Route::get('inspection/car/pdf/inspection/{id}','InspectionCarController@pdfInspection')->name('inspection-car-pdf-inspection');

    // Inspection Boats
    Route::get( 'inspection/boat',                'InspectionBoatController@index')->name('inspection-boat');
    Route::post('inspection/boat/dt',             'InspectionBoatController@indexDt')->name('inspection-boat-dt');
    Route::get( 'inspection/boat/create',         'InspectionBoatController@create')->name('inspection-boat-create');
    Route::post('inspection/boat/store',          'InspectionBoatController@store')->name('inspection-boat-store');
    Route::get( 'inspection/boat/edit/{id?}',     'InspectionBoatController@edit')->name('inspection-boat-edit');
    Route::put( 'inspection/boat/update/{id}',    'InspectionBoatController@update')->name('inspection-boat-update');
    Route::post('inspection/boat/destroy',        'InspectionBoatController@destroy')->name('inspection-boat-destroy');
    Route::get( 'inspection/boat/image/edit/{id}','InspectionBoatController@imageEdit')->name('inspection-boat-image-edit');
    Route::post('inspection/boat/image/replace',  'InspectionBoatController@imageReplace')->name('inspection-boat-image-replace');
    Route::post('inspection/boat/image/destroy',  'InspectionBoatController@imageDestroy')->name('inspection-boat-image-destroy');
    Route::get( 'inspection/boat/auxiliary/edit/{id}', 'InspectionBoatController@auxEdit')->name('inspection-boat-auxiliary-edit');
    Route::post('inspection/boat/auxiliary/replace',   'InspectionBoatController@auxReplace')->name('inspection-boat-auxiliary-replace');
    Route::get( 'inspection/boat/document/edit/{id}',  'InspectionBoatController@docEdit')->name('inspection-boat-document-edit');
    Route::post('inspection/boat/document/replace',    'InspectionBoatController@docReplace')->name('inspection-boat-document-replace');
    Route::get('inspection/boat/charts',               'InspectionBoatController@charts')->name('inspection-boat-charts');
    Route::post('inspection/boat/chart/line/month','InspectionBoatController@chartLineMonth')->name('inspection-boat-chart-line-month');
    Route::post('inspection/boat/chart/line/month/compare','InspectionBoatController@chartLineMonthCompare')->name('inspection-boat-chart-line-month-compare');
    Route::post('inspection/boat/chart/bar/month/compare','InspectionBoatController@chartBarMonthCompare')->name('inspection-boat-chart-bar-month-compare');
    Route::get('inspection/boat/files/move',              'InspectionBoatController@filesMove')->name('inspection-boat-files-move');

    // Sinister Cars
    Route::get( 'sinister/car',                'SinisterCarController@index')->name('sinister-car');
    Route::post('sinister/car/dt',             'SinisterCarController@indexDt')->name('sinister-car-dt');
    Route::get( 'sinister/car/create',         'SinisterCarController@create')->name('sinister-car-create');
    Route::post('sinister/car/store',          'SinisterCarController@store')->name('sinister-car-store');
    Route::get( 'sinister/car/edit/{id?}',     'SinisterCarController@edit')->name('sinister-car-edit');
    Route::put( 'sinister/car/update/{id}',    'SinisterCarController@update')->name('sinister-car-update');
    Route::post('sinister/car/destroy',        'SinisterCarController@destroy')->name('sinister-car-destroy');
    Route::get( 'sinister/car/image/edit/{id}','SinisterCarController@imageEdit')->name('sinister-car-image-edit');
    Route::post('sinister/car/image/replace',  'SinisterCarController@imageReplace')->name('sinister-car-image-replace');
    Route::post('sinister/car/image/destroy',  'SinisterCarController@imageDestroy')->name('sinister-car-image-destroy');
    Route::get('sinister/car/charts',         'SinisterCarController@charts')->name('sinister-car-charts');
    Route::post('sinister/car/chart/line/month','SinisterCarController@chartLineMonth')->name('sinister-car-chart-line-month');
    Route::post('sinister/car/chart/line/month/compare','SinisterCarController@chartLineMonthCompare')->name('sinister-car-chart-line-month-compare');
    Route::post('sinister/car/chart/bar/month/compare','SinisterCarController@chartBarMonthCompare')->name('sinister-car-chart-bar-month-compare');
    Route::get('sinister/car/files/move',              'SinisterCarController@filesMove')->name('sinister-car-files-move');

    // Usuario
    Route::get( 'usuario',                  'UsuarioController@index')->name('usuario');
    Route::post('usuario/dt',               'UsuarioController@indexDt')->name('usuario-dt');
    Route::get( 'usuario/create',           'UsuarioController@create')->name('usuario-create');
    Route::post('usuario/store',            'UsuarioController@store')->name('usuario-store');
    Route::get( 'usuario/edit/{id?}',       'UsuarioController@edit')->name('usuario-edit');
    Route::put( 'usuario/update/{id}',      'UsuarioController@update')->name('usuario-update');
    Route::post('usuario/destroy',          'UsuarioController@destroy')->name('usuario-destroy');
    Route::post('usuario/password/changed', 'UsuarioController@passwordChanged')->name('usuario-password-changed');

    // Charts
    Route::post('chart/apex/area', 'Ajax\ChartController@apexArea')->name('chart-apex-area');

    // Tools
    Route::get('tools/zip/inspection/car/{id?}', 'Tools\ZipFilesController@inspCar')->name('tools-zip-inspection-car');
});
*/

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('API', function () {
    return view('api');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Create get request for getting for countries the latest data ezpz ;)
Route::get('/globally_latest_number', 'Covid\CovidController@global_latest_number');
Route::get('/globally_latest', 'Covid\CovidController@global_latest');
Route::get('/{country}/latest', 'Covid\CovidController@country_latest');
Route::get('/{country}/{date}', 'Covid\CovidController@by_country_date');
Route::get('/country/{country}/all', 'Covid\CovidController@country_all');

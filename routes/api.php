<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('/globally_latest', 'Covid\CovidController@global_latest');
Route::get('/country/latest', 'Covid\CovidController@country_latest');
Route::get('/{country}/{date}', 'Covid\CovidController@by_country_date');
Route::get('/{country}/all', 'Covid\CovidController@country_all');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\CountryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function(){
    
    Route::get('sync_countries', [CountryController::class, 'syncCountries']);
    Route::get('countries',[CountryController::class, 'getAll']);
    Route::get('country/{country_id}', [CountryController::class, 'getCountry']);
 
    Route::get('countrymax', [CountryController::class, 'getMaxCountry']);
    Route::get('countrymin', [CountryController::class, 'getMinCountry']);
});
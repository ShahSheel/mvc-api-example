<?php

use Illuminate\Http\Request;

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

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');


//Route::group(['middleware' => 'auth:api'], function() {

// lots of routes that require auth middleware

/** Unauthenticated API  */
Route::prefix('v1')->group(function () {
        /** Lists all Units, without pagination, in no particular order, including charges. */
        Route::get("units", "Api\GetUnitsController@getAllUnits");

        /** Gets details of a Unit along with its charging history.*/
        Route::get('units/{unitID}', 'Api\GetUnitsController@getUnit'); //Why cant I just build a request query..would be easier

        /** Create a charge against a given unit. */
        Route::post('units/{unitID}/charges', 'Api\ToggleUnitController@startUnitCharge');

        /** Stop a specific charge for a given unit. */
        Route::post('units/{unitID}/charges/{chargeID}', 'Api\ToggleUnitController@stopUnitCharge' );
});



/** Authenticated API with repository design pattern  */
Route::group(['middleware' => 'auth:api'], function() {
    Route::prefix('v2')->group(function () {
        /** Lists all Units, without pagination, in no particular order, including charges. */
        Route::get("units", "Api\UnitController@getAllUnits");

        /** Gets details of a Unit along with its charging history.*/
        Route::get('units/{unitID}', 'Api\UnitController@getUnitByID');

        /** Create a charge against a given unit. */
        Route::post('units/{unitID}/charges', 'Api\UnitController@startCharge');

        /** Stop a specific charge for a given unit. */
        Route::post('units/{unitID}/charges/{chargeID}', 'Api\UnitController@stopCharge');
    });
});




/**
 *
 * chmod -R 775 storage
 * chmod -R 755 storage bootstrap/cache
 * chmod -R 777 storage bootstrap/cache
 * chown -R www-data:www-data /var/www/src -Maybe?
 */



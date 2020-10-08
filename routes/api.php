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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return json_encode($request->user());
});

Route::post('/login-action', 'Api\Auth\LoginController@Login');
Route::group(['middleware'=> ['auth:api','cors']], function(){
	Route::get('/user-details', 'Api\UserController@Details');
	Route::get('/beat-plan-list', 'Api\BeatPlanController@planList');
	Route::post('/beat-plan-import', 'Api\BeatPlanController@import');
	Route::get('/collections', 'Api\CollectionController@allCollections');
	Route::post('/create-collection', 'Api\CollectionController@createCollection');
	Route::post('/update-load-status-to-filled', 'Api\CollectionController@update_status_to_filled');
	Route::get('/site-list', 'Api\SiteController@sitesList');
	Route::get('/allot-trip-action', 'Api\TripController@allotTripAction');
	Route::get('/trip-list', 'Api\TripController@tripList');
	Route::get('/vehicle-status', 'Api\VehicleController@getVehicleStatusBYId');
	Route::get('/all-zones', 'Api\SiteController@getAllZones');
	Route::get('/site-list-plan', 'Api\SiteController@siteListForPlan');
	Route::post('/create-beat-plan', 'Api\BeatPlanController@createBeatPlan');
	Route::get('/client-list', 'Api\VendorController@getClientList');
	Route::get('/effective-date-list', 'Api\BeatPlanController@getEffectiveDateList');
	Route::get('/route-list', 'Api\RouteController@getRouteList');
	Route::get('/vehicle-list', 'Api\VehicleController@getAllVehicleList');
	Route::get('/driver-list', 'Api\UserController@getAllDriverList');
	Route::get('/filler-list', 'Api\UserController@getAllFillerList');
	Route::get('/field-officer-list', 'Api\UserController@getAllFieldOfficerList');
	Route::get('/pump-vendor-list', 'Api\VendorController@getAllPumpVendorList');
	Route::get('/unique-trip-id', 'Api\TripController@getAllUniqueTripId');
	Route::get('/assets', 'Api\AssetsController@index');
	Route::post('/store-trip', 'Api\TripController@storeTrip');
	// 21 aug 2020
	Route::get('trip-id-load', 'Api\TripController@tripIdLoad')->name('trip-id-load');
	Route::get('/site-list-by-beatplan_id', 'Api\BeatPlanController@siteListByBeatId');
	// 27 aug 2020
	Route::get('/date-for-load', 'Api\TripController@effectiveDateForLoad');
	Route::get('/zone-client-for-load', 'Api\TripController@loadSites');
	Route::get('/trips-by-zone-load', 'Api\TripController@loadSites');
	Route::get('/trips-by-client-load', 'Api\TripController@loadSites');
	Route::get('/sites-for-load', 'Api\TripController@loadSitesByZoneOrClient');
	Route::post('/load-verify', 'Api\TripController@loadSitesVerify');
	Route::post('/update-loading-time', 'Api\TripController@update_loading_time');
	Route::post('/update-loading-status', 'Api\TripController@update_loading_status');
	// 31-08-2020
	Route::post('/update-filler-location', 'Api\MapController@updateLiveLocation');
	Route::get('/get-filler-location', 'Api\MapController@getLiveLocation');
	Route::get('/today-trips', 'Api\TripController@getTodayTrips');
	Route::get('/trip-detais', 'Api\TripController@tripDetails');
	Route::get('/filler-trips', 'Api\TripController@tripsByFillerId');
	Route::get('/driver-today-trips', 'Api\TripController@driver_today_trip');
	Route::get('/filler-site-list', 'Api\TripController@tripsDetaisByTripId');
	Route::get('/filler-site-details', 'Api\TripController@siteDetaisByTripDataId');
	Route::get('/loading-point-distance', 'Api\TripController@loading_point_distance');

	// 07-08-2020
	Route::get('/vehicle-trip-list', 'Api\VehicleController@vehicleTripsDetails');	
	Route::get('/vehicle-trip-data', 'Api\VehicleController@vehicleTripsData');	
	// 08-08-2020
	Route::get('/client-report-counts', 'Api\TripController@tripDataCountByStatus');	
	Route::get('/client-report-sites', 'Api\TripController@tripDataForClientReport');
	// 09-08-2020
	Route::get('/plan-report', 'Api\TripController@planReport');
	Route::get('/effective-date-list-report', 'Api\BeatPlanController@getEffectiveDateListForReport');
	Route::get('/loaded-sites-report', 'Api\TripController@getLoadedSitesDetails');
	Route::get('/filler-location-report', 'Api\TripController@getLoadedSitesFillerLocationByVehicleId');
	Route::post('/update-vendor-location', 'Api\VendorController@updateLiveLocation');
	Route::get('/check-uploaded-speedometer', 'Api\TripController@isUploadedSpeedometer');
	Route::post('/upload-speedometer', 'Api\TripController@uploadSpedometerValue');
	// 14-09-2020
	Route::post('/upload-img-collection', 'Api\CollectionController@imageUploadDirect');
	Route::get('/plan-report-zone', 'Api\TripController@planReportByPlanDateAndZone');
	Route::post('/trip-status-complete', 'Api\TripController@tripComplete');
	Route::get('/trip-check-status-complete', 'Api\TripController@checkCompleteStatus');
	Route::get('/trip-by-id', 'Api\TripController@tripById');

});
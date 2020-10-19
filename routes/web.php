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
Route::get('/linkstorage', function () {
	Artisan::call('storage:link');
});

Route::get('/', function () {
	return redirect(route('login'));
});

Auth::routes();

Route::get('/home', 'BeatPlanController@index')->name('home');

//Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::post('import', 'BeatPlanController@import')->name('import')->middleware('auth');
Route::get('collections', 'CollectionController@collections')->name('collections')->middleware('auth');
Route::get('create-collection/{id}', 'CollectionController@createCollection')->name('create-collection')->middleware('auth');
Route::get('collection-serverside', 'CollectionController@serversideCollection')->name('collection-serverside')->middleware('auth');
Route::get('beat-plan-serverside', 'HomeController@serversideBeatplan')->name('beat-plan-serverside')->middleware('auth');
Route::post('create-collection-action', 'CollectionController@createCollectionAction')->name('create-collection-action')->middleware('auth');
Route::get('edit-beat-plan/{id}', 'BeatPlanController@editBeatPlan')->name('edit-beat-plan')->middleware('auth');
Route::post('edit-beat-plan-action', 'BeatPlanController@editBeatPlanAction')->name('edit-beat-plan-action')->middleware('auth');
Route::post('delete-beat-plan', 'BeatPlanController@deleteBeatPlan')->middleware('auth');
Route::get('edit-collection/{id}', 'CollectionController@editCollection')->name('edit-collection')->middleware('auth');
Route::post('edit-collection-action', 'CollectionController@editCollectionAction')->name('edit-collection-action')->middleware('auth');
Route::get('handbook-beat', 'BeatPlanController@Handbook')->name('handbook-beat')->middleware('auth');
Route::get('handbook-trips/{beatId}', 'BeatPlanController@handbookTrips')->name('handbook-trips')->middleware('auth');
Route::get('handbook-page/{tripId}', 'BeatPlanController@uploadHandbookPage')->name('handbook-page')->middleware('auth');
Route::post('upload-handbook', 'BeatPlanController@uploadHandbook')->name('upload-handbook')->middleware('auth');
Route::post('get-previous-reading', 'CollectionController@validatePreviousReading')->name('get-previous-reading')->middleware('auth');
Route::post('delete-plan-row', 'BeatPlanController@deleteRow')->name('delete-plan-row')->middleware('auth');
Route::get('client-name-list', 'VendorController@show')->name('client-name-list')->middleware('auth');
Route::get('site-name-list/{id?}', 'SiteMasterController@show')->name('site-name-list')->middleware('auth');
// datatables 
Route::post('beat-plan-data-table', 'BeatPlanController@dataTablePlan')->middleware('auth');
Route::post('beat-view-table', 'BackLogController@trip_data_datatable')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::put('user', [
		'as' => 'user.store',
		'uses' => 'UserController@store'
	]);
	Route::get('user/{id}', [
		'as' => 'user-edit',
		'uses' => 'UserController@edit'
	]);
	Route::put('user', [
		'as' => 'user.update',
		'uses' => 'UserController@update'
	]);
	Route::get('user/{id}', [
		'as' => 'user.destroy',
		'uses' => 'UserController@destroy'
	]);
	Route::put('update-password', [
		'uses' => 'UserController@updatePassword'
	])->name('update-password');

	Route::get('user/{id}', ['as' => 'user.profile','uses' => 'UserController@profile']);
	Route::put('update-profile', ['as' => 'user.update-profile','uses' => 'UserController@updateProfile']);
	Route::get('update-api-token', ['as' => 'update-api-token','uses' => 'UserController@apiToken']);
	//new code v3
	Route::post('index-table', 'UserController@indexDataTable');
	Route::post('user-details-ajax', 'UserController@getUserDetailById');
	Route::post('user-remove', 'UserController@removeUser');
	Route::get('user-marital/{id}', ['as' => 'user.marital','uses' => 'UserController@marital']);
	Route::post('child-remove', 'UserController@removeChild');
	Route::get('user-contact/{id}', ['as' => 'user.contact','uses' => 'UserController@contact']);
	Route::get('user-password/{id}', ['as' => 'user.password','uses' => 'UserController@password']);
	Route::get('user-kyc/{id}', ['as' => 'user.kyc','uses' => 'UserController@kyc']);
	Route::get('all-states', 'UserController@getAllStates');

});

Route::group(['middleware'=> ['auth','is_vendor'], 'prefix'=> 'vendor'], function(){
	Route::resource('vendors', 'VendorController');
	Route::get('editVehicle/{id}', ['as' => 'vendors.editVehicle','uses' => 'VendorController@redirectToEditVehicle']);
	Route::put('update-kyc', ['as' => 'vendors.updateKyc', 'uses' => 'VendorController@updateKyc']);
	Route::get('vehicle-status/{vehicle_id}', 'VehicleMasterController@vehicle_status')->name('vehicle-status');
	Route::get('vehicle-run-data/{vehicle_id}', 'VehicleMasterController@vehicle_run_data')->name('vehicle-run-data');
	Route::get('vehicle-trip-data', 'VehicleMasterController@vehicle_trip_data')->name('vehicle-trip-data');
	Route::get('vehicle-agreement', 'VehicleMasterController@get_agreement')->name('vehicle-agreement');
	Route::post('vehicle-update-agreement', 'VehicleMasterController@vehicle_update_agreement')->name('vehicle-update-agreement');
	// new code v3
	Route::post('vendor-table', 'VendorController@indexDataTable');
	Route::get('kyc/{id}', ['as' => 'vendors.kyc', 'uses' => 'VendorController@kyc']);
});

Route::group(['middleware'=> 'auth', 'prefix'=> 'master'], function(){
	Route::resource('site', 'SiteMasterController');
	Route::get('site/delete/{id}', 'SiteMasterController@destroy')->name('site.remove');
	Route::resource('vehicle', 'VehicleMasterController');
	Route::resource('assets', 'AssetsController');
	Route::get('serialkeys', ['as' => 'assets.serialkeys','uses' => 'AssetsController@showSerialKeys']);
	Route::post('serialkeys-update', ['as' => 'assets.serialkeys-update','uses' => 'AssetsController@updateSerialKeys']);
	Route::resource('employee', 'EmployeeController');
	Route::get('employee/delete/{id}', 'EmployeeController@destroy')->name('employee.remove');
	Route::resource('route', 'RouteController');
	Route::post('import-sites', 'SiteMasterController@import')->name('site.import');
	Route::get('delete-asset/{id}', ['as' => 'delete-asset','uses' => 'AssetsController@destroy']);
	Route::get('delete-route/{id}', ['as' => 'delete-route','uses' => 'RouteController@destroy']);
	Route::get('delete-site/{id}', ['as' => 'delete-site','uses' => 'SiteMasterController@destroy']);
	Route::get('delete-vendor/{id}', ['as' => 'delete-vendor','uses' => 'VendorController@destroy']);
	Route::get('delete-employee/{id}', ['as' => 'delete-employee','uses' => 'EmployeeController@destroy']);
	Route::post('import-employee', 'EmployeeController@import')->name('employee.import');
	Route::get('site-serverside', ['as' => 'site-serverside', 'uses' => 'SiteMasterController@serverSideIndex']);
	Route::get('is-exits-contact','EmployeeController@isContactExist')->name('is-exits-contact');
	Route::get('is-exits-email', 'EmployeeController@isEmailExist')->name('is-exits-email');
	Route::get('all-vehicles', 'VehicleMasterController@allVehicles')->name('all-vehicles')->middleware('auth');
	Route::get('trips-details/{vehicleId}', 'VehicleMasterController@vehicleTripsDetails')->name('trips-details')->middleware('auth');
	Route::get('trips-data/{tripId}', 'VehicleMasterController@vehicleTripsData')->name('trips-data')->middleware('auth');
	// new changes 12

});
Route::group(['middleware'=> 'auth', 'prefix'=> 'mis'], function(){
	Route::get('zone-allotment/{misId}', 'MisController@zoneAllotment')->name('zone-allotment');
	Route::get('zone-name-list', 'MisController@zoneNameList')->name('zone-name-list');
	Route::post('allot-zone','MisController@allotZone')->name('allot-zone');
	Route::post('mis-update-zone/{id}','MisController@updateAllotedZone')->name('mis-update-zone');
	Route::get('mis-delete-zone/{id}','MisController@deleteAllotedZone')->name('mis-delete-zone');
});

Route::get('beat-plan', 'BeatPlanController@index')->name('beat-plan')->middleware('auth');
Route::get('edit-beat-plan/{id}', 'BeatPlanController@edit')->name('edit-beat-plan.edit')->middleware('auth');
Route::get('create-beat-plan', 'BeatPlanController@create')->name('create-beat-plan')->middleware('auth');
Route::post('add-beat-plan', 'BeatPlanController@store')->name('add-beat-plan')->middleware('auth');
Route::post('update-beat-plan', 'BeatPlanController@update')->name('update-beat-plan')->middleware('auth');
Route::post('remove-sites', 'BeatPlanController@removeSitesFromEdit')->name('remove-sites')->middleware('auth');
Route::get('effective-date/{zone?}', 'BeatPlanController@effectiveDateForTrip')->name('effective-date');
Route::get('site-list-plan/{zone?}/{clientId?}', 'BeatPlanController@siteListForPlan')->name('site-list-plan');

//serching
Route::get('route-name/{zone?}', 'RouteController@routeNameForTrip')->name('route-name');
Route::get('vehicle-number', 'VehicleMasterController@vehicleForTrip')->name('vehicle-number');
Route::get('driver-name', 'UserController@driverForTrip')->name('driver-name');
Route::get('asset-name-list', 'AssetsController@assetNameForTrip')->name('asset-name-list');

Route::group(['middleware'=> 'auth', 'prefix' => 'trip'], function(){
	Route::get('/', 'TripController@index')->name('trips');
	Route::get('/trip-data-table', 'TripController@datatable')->name('trips_datatable');
	Route::get('/load-data-table', 'TripController@load_datatable')->name('loads_datatable');
	Route::get('/load-data-data-table', 'TripController@load_datatable_by_trip_id')->name('loads_data_datatable');
	Route::get('/trip/{id}', 'TripController@edit')->name('trip.edit');
	Route::post('/trip/{id}', 'TripController@update')->name('trip.update');
	Route::post('/trip-remove/{id}', 'TripController@remove')->name('trip.remove');
	Route::get('allotment', 'TripController@tripAllotment')->name('allotment');
	Route::get('site-details-trip/{zone?}/{date?}', 'BeatPlanController@siteDetailsForTrip')->name('site-details-trip');
	Route::get('trip-modal-data', 'TripController@getTripModalData')->name('trip-modal-data');
	Route::get('load-verification', 'TripController@loadVerification')->name('load-verification');
	Route::post('allot-trip', 'TripController@storeTrip')->name('allot-trip');
	Route::get('effective-date-load', 'TripController@effectiveDateForLoad')->name('effective-date-load');
	Route::get('trip-id-load/{effectiveDate?}', 'TripController@tripIdLoad')->name('trip-id-load');
	Route::get('load-sites', 'TripController@loadSites')->name('load-sites');
	Route::post('load-sites-verify', 'TripController@loadSitesVerify')->name('load-sites-verify');
	Route::get('all-loads', 'TripController@allLoad')->name('all-loads');
	Route::post('update-loading-time', 'TripController@update_loading_time')->name('update-loading-time');
	Route::get('backlog', 'BackLogController@index')->name('backlog.index');
	Route::post('assign-trip', 'BackLogController@assign_trip')->name('backlog.assign_trip');
	Route::post('load-transfer', 'BackLogController@load_transfer')->name('backlog.load_transfer');
	Route::get('not-delivered', 'BackLogController@not_delivered')->name('backlog.not_delivered');
	Route::get('beat-plan-data', 'BackLogController@trip_data')->name('backlog.trip_data');
	Route::post('save-divert', 'BackLogController@save_divert')->name('backlog.save_divert');
	Route::post('update-load', 'BackLogController@update_load')->name('backlog.update_load');
	Route::post('update-status', 'BackLogController@update_status')->name('backlog.update_status');
	Route::post('update-remark', 'BackLogController@update_remark')->name('backlog.update_remark');
	Route::get('trip-map/{tripId?}', 'TripController@loadMapForTrip')->name('trip-map');
	Route::get('lat-long/{tripId?}', 'TripController@getSitesLatLng')->name('lat-long');
	Route::get('/map-pdf/{tripId?}','TripController@createPDFMap')->name('map-pdf');
	Route::get('store-distance/{tripId}/{distance?}', 'TripController@storeDistanceTripByMap')->name('store-distance');
	Route::get('trip-map-pdf', 'TripController@pdf')->name('trip-map-pdf');
	Route::get('share-on-mail', 'TripController@shareOnMail')->name('share-on-mail');
	Route::get('check-trip-id', 'TripController@isExistUniqueTrip')->name('check-trip-id');
});

Route::group(['middleware'=> ['auth','is_client'], 'prefix' => 'client'], function(){
	Route::resource('clients', 'ClientController');
	Route::get('profile', 'ClientController@profile')->name('profile');
	Route::put('update-kyc', ['as' => 'update-kyc', 'uses' => 'ClientController@updateKyc']);
	Route::get('vehicles', 'ClientController@trips')->name('vehicles');
	Route::get('vehicle-status/{vehicle_id}', 'ClientController@vehicle_status')->name('vehicle-status');
	Route::get('users', 'ClientController@users')->name('users');
	Route::post('update-user/{id}', 'ClientController@updateUser')->name('update-user');
	Route::post('update-password-client/{id}', 'ClientController@updatePassword')->name('update-password-client');
	Route::get('beat-plan-data', 'ClientController@trip_data')->name('clients.trip_data');
	Route::get('delete-user/{id}', 'ClientController@deleteUser')->name('delete-user');
});

Route::group(['middleware'=> ['auth']], function(){
	//Route::get('/home', '@index')->name('home');
	Route::get('settings', 'SettingController@edit')->name('settings');
	Route::post('setting-update', 'SettingController@update')->name('setting.update');
});

Route::group(['middleware'=> ['auth','is_mis'], 'prefix' => 'mis', 'namespace' => 'Client'], function(){
	Route::get('index', 'MisController@index')->name('index');
});
Route::group(['middleware'=> ['auth','is_technician'], 'prefix' => 'tech', 'namespace' => 'Client'], function(){
	Route::get('index', 'TechController@index')->name('index');
});
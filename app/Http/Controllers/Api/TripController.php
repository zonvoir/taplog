<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\Trips;
use App\Sitemaster;
use App\Beatplan;
use App\BeatPlanData;
use App\TripData;
use App\Verifiedloads;
use App\Helpers\Cbis;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
	public function allotTripAction(Request $request)
	{
		if(aurh()->user()->type = 'subadmin' || aurh()->user()->type = 'mis'){
			$sitesArray = $request->siteid;
			$beatplanid = $request->beatplanid;
			if ($sitesArray) {
				$i = 0;
				$trips = new Trips();
				$trips->beatplan_id = $request->beatplanid[0];
				$trips->added_date = $request->current_date;
				$trips->effective_date = $request->effective_date;
				$trips->vehicle_id = $request->vehicale_id;
				$trips->route_id = $request->route_id;
				$trips->driver_id = $request->driver;
				$trips->filler_id = $request->fiiler;
				$trips->field_officer_id = $request->area_officer;
				$trips->loading_point_id = $request->loading_point; 
				$trips->trip_id = $request->trip_id;

				if ($request->has('asset_id')) {
					$trips->assets = json_encode($request->asset_id);	
				}
				if ($request->has('qty_allocate')) {
					$trips->asset_qty = json_encode($request->qty_allocate);
				}
				if ($request->has('client_name')) {
					$trips->clients_name = json_encode($request->client_name);
				}
				if ($request->has('client_mobile')) {
					$trips->clients_mobile = json_encode($request->client_mobile);
				}
				$trips->added_by = auth()->user()->id;
				$trips->save();	
				foreach ($sitesArray as $value) {
					$tripdata = new TripData;
					$tripdata->trip_id = $trips->id;
						$tripdata->data_id = $value; // Site id
						$tripdata->beatplan_id = $beatplanid[$i];
						$tripdata->save();
						$i++;	
					}
					return response()->json([
						'status' => 'Ok',
						'message' => 'Trip alloted!',
					]);	
				}else{
					return response()->json([
						'status' => 'Not Ok',
						'message' => 'You did not add sites!',
					]);	
				}
			}		
			else{
				return response()->json([
					'status' => 'Not Ok',
					'message' => 'You are not authorized!',
				]);
			}	
		}
		public function tripList(Request $request)
		{
			$query = Trips::leftjoin('vehicle_master', function($join){
				$join->on('vehicle_master.id','=','trips.vehicle_id');	
			})
			->leftjoin('users', function($join){
				$join->on('users.id','=','trips.');	
			});
			if(auth()->user()->type == 'filler'){
				$query->where('trips.filler_id','=',auth()->user()->id);
			}
			if(auth()->user()->type == 'driver'){
				$query->where('trips.driver_id','=',auth()->user()->id);
			}
			if(auth()->user()->type == 'subadmin'){
				$fillers = User::where(['created_by_id'=>auth()->user()->id, 'type' => 'filler'])->pluck('id');
				$drivers = User::where(['created_by_id'=>auth()->user()->id, 'type' => 'driver'])->pluck('id');
				$query->whereIn('trips.filler_id',$fillers)
				->orWhereIn('trips.driver_id',$drivers);
			}
		}
		public function getAllUniqueTripId(Request $request, Trips $trip)
		{
			if ($request->has('effective_date')) {
				$trip = Trips::leftJoin('vehicle_master', function($join) {
					$join->on('vehicle_master.id', '=', 'trips.vehicle_id');
				});
				
				if(auth()->user()->type == 'subadmin'){
					$data = $trip->where(['trips.effective_date'=>$request->effective_date, 'trips.added_by' => auth()->user()->id])->select('vehicle_master.id as vehicleid','vehicle_master.vehicle_no','trips.trip_id')->get();
					return response()->json([
						'status' => 'Ok',
						'message' => 'Success!',
						'details' => $data
					]);
				}elseif (auth()->user()->type == 'mis') {
					$data = $trip->where(['trips.effective_date'=>$request->effective_date, 'trips.added_by' => auth()->user()->created_by_id])->select('vehicle_master.id as vehicleid','vehicle_master.vehicle_no','trips.trip_id')->get();
					//return dd(auth()->user()->created_by_id);
					return response()->json([
						'status' => 'Ok',
						'message' => 'Success!',
						'details' => $data
					]);
				}elseif(auth()->user()->type == 'field_officer'){
					$misIds = $this->getMisIds(auth()->user()->id);
					$data = $trip->where(['trips.effective_date'=>$request->effective_date, 'trips.added_by' => auth()->user()->created_by_id])->orWhereIn('trips.added_by',$misIds)->select('vehicle_master.id as vehicleid','vehicle_master.vehicle_no','trips.trip_id')->get();
					return response()->json([
						'status' => 'Ok',
						'message' => 'Success!',
						'details' => $data
					]);
				}
			}

		}
		public function storeTrip(Request $request)
		{
			$sitesArray 	 = $request->addSites;
			$clientsArray 	 = $request->addClients;
			$assetsArray 	 = $request->addAssets;
			$beatplanid 	 = $request->beatplanid;
			
			$beatplandata_ids= array_column($sitesArray, 'beatplandata_id');
			$sitesArray 	 = BeatPlanData::whereIn('id', $beatplandata_ids)->pluck('site_id')->toArray(); 
			
			$client_names 	 = array_column($clientsArray, 'client_name');
			$client_mobiles	 = array_column($clientsArray, 'client_mobile');
			$assets 		 = array_column($assetsArray, 'asset_id');
			$asset_qty 		 = array_column($assetsArray, 'qty_allocate');
			//$sitesArray 	 = array_column($sitesArray, 'site_id');
			//return dd($beatplandata_ids);
			
			if ($sitesArray) {
				$i = 0;
				$trips 				     = new Trips();
				$trips->beatplan_id      = $request->beatplanid;
				$trips->added_date 		 = $request->current_date;
				$trips->effective_date 	 = $request->effective_date;
				$trips->vehicle_id 		 = $request->vehicale_id;
				$trips->route_id 		 = $request->route_id;
				$trips->driver_id 		 = $request->driver;
				$trips->filler_id 		 = $request->filler;
				$trips->field_officer_id = $request->area_officer;
				$trips->loading_point_id = $request->loading_point; 
				$trips->trip_id 		 = $request->trip_id;
				//$trips->trip_data_id = $request->trip_data_id;
				
				if ($assets) {
					$trips->assets = json_encode($assets);	
				}
				if ($asset_qty) {
					$trips->asset_qty = json_encode($asset_qty);
				}
				if ($client_names) {
					$trips->clients_name = json_encode($client_names);
				}
				if ($client_mobiles) {
					$trips->clients_mobile = json_encode($client_mobiles);
				}
				$trips->added_by = auth()->user()->id;
				
				// return dd($trips);
				$trips->save();	
				$response = $this->sendSmsForNewTrip($request->all(), $beatplandata_ids);
				foreach ($sitesArray as $value) {
					
					$tripdata 			= new TripData;
					$tripdata->trip_id 	= $trips->id;
					$tripdata->data_id 	= $value; // Site id
					$this->changeStatusOfBeatPlanData('allocated', $beatplandata_ids[$i]);
					$tripdata->beatplan_id = $beatplanid;
					//$tripdata->trip_data_id = $trip_data_id[$i];
					// return dd($beatplandata_ids);
					$tripdata->save();
					$i++;	
				}
			}
			return 	response()->json([
				'status' => 'Ok',
				'message' => 'Success!',
				'details' => $trips,
				'msgResponse' => $response
			]);
		}
		
		public function changeStatusOfBeatPlanData($status='', $beatPlanDataId= '')
		{
			if (isset($status) && isset($beatPlanDataId)) {
				$data = BeatPlanData::find($beatPlanDataId);
				$data->status = $status;
				$data->save();
			}
		}
		
		public function effectiveDateForLoad(Request $request, Trips $trip){
			$response = [];$numrecords = 10;
			if ($request->has('name')) {
				$search = $request->name;
				$data = $trip->where('effective_date', 'LIKE', "%{$search}%")->where(['added_by' => $request->userId])->orWhere(['added_by' => $request->userId])->limit($numrecords)->get();
				foreach ($data as $p) { 
					$response[] = array("id" => $p->id, 'vendor_code'=>$p->beat_plan->client->vendor_code, "name" => $p->effective_date.' '.$p->beat_plan->client->vendor_code, "effective_date" => $p->effective_date);  
				}
			} else {
				$data = $trip->limit($numrecords)->get();
			}
			return response()->json($response);
		}
		
		public function tripIdLoad(Request $request, Trips $trip)
		{
			$effectiveDate 	= $request->effectiveDate;
			$response 		= [];
			$numrecords 	= 10;
			if ($request->has('name')) {
				$search = $request->name;
				$trip = Trips::leftJoin('vehicle_master', function($join) {
					$join->on('vehicle_master.id', '=', 'trips.vehicle_id');
				});
				if(auth()->user()->type == 'subadmin'){
					$data = $trip->where('trips.trip_id', 'LIKE', "%{$search}%")->where(['trips.effective_date'=>$effectiveDate, 'trips.added_by' => auth()->user()->id])->limit($numrecords)->get();
				}elseif (auth()->user()->type == 'mis') {
					$data = $trip->where('trips.trip_id', 'LIKE', "%{$search}%")->where(['trips.effective_date'=>$effectiveDate, 'trips.added_by' => auth()->user()->created_by_id])->limit($numrecords)->get();
				}elseif(auth()->user()->type == 'field_officer'){
					$misIds = $this->getMisIds(auth()->user()->id);
					$data = $trip->where('trips.trip_id', 'LIKE', "%{$search}%")->where(['trips.effective_date'=>$effectiveDate, 'trips.added_by' => auth()->user()->created_by_id])->orWhereIn('trips.added_by',$misIds)->limit($numrecords)->get();
				}
				foreach ($data as $p) { $response[] = array("id" => $p->id, "name" => $p->trip_id, "vehicle_no" => $p->vehicle_no, "vehicle_id" => $p->vehicle_id); }
			} else {
				$data = $trip->limit($numrecords)->get();
			}
			return response()->json($response);
		}
		
		public function loadSites(Request $request, Trips $trip)
		{
			// $tripDetails = $trip->where([ 'effective_date' => $request->effective_date_load, 'status' => 'unloaded'])->get();		
			$list = false;
			$query = $trip->
			where(['trips.effective_date' => $request->effective_date_load, 'trips.status' => 'unloaded']);
			$query->select('trips.*','beatplans.mp_zone')
			->join('beatplans',function($join){
				$join->on('trips.beatplan_id',"=",'beatplans.id');
			});
			if($request->has('zone')){
				$query
				->where('beatplans.mp_zone',$request->get('zone'));

				$list = true;
			}
			if($request->has('client')){
				$query
				->where('beatplans.client_id',$request->get('client'));
				$list = true;
			}
			if($request->has('action')){
				$action = $request->action;
				$list = true;
			}else{
				$action = false;
			}
			if($list)
				$tripDetails = $query->get();
			else
				$tripDetails = [];

			if($request->has('trip_id')){
				$query = $trip->
				where(['trips.id' => $request->trip_id]);
				$tripDetails1 = $query->select('trips.*','beatplans.mp_zone')
				->join('beatplans',function($join){
					$join->on('trips.beatplan_id',"=",'beatplans.id');
				})->get();
			}else{
				$tripDetails1 = [];
			}

			$mp_zone = Beatplan::where(['effective_date' => $request->effective_date_load])->groupBy('mp_zone')->get();

			$client = Beatplan::join('vendors',function($q){
				$q->on('vendors.id','=','beatplans.client_id');
			})->where(['effective_date' => $request->effective_date_load])->groupBy('beatplans.client_id')->select('beatplans.*','vendors.name as client_name')->get();

			$data = ['trips'=>$tripDetails,'trips1'=>$tripDetails1,'mp_zone'=>$mp_zone,'client'=>$client,'action'=>$action];
			// return view('trip.load-sites',['trips'=>$tripDetails,'trips1'=>$tripDetails1,'mp_zone'=>$mp_zone,'client'=>$client,'action'=>$action]);
			return 	response()->json([
				'status' => 'Ok',
				'message' => 'Success!',
				'details' => $data,
			]);

		}

		public function loadSitesVerify_Backup(Request $request)
		{
			$siteList 		= array();
			$tripIdList 	= array();
			$loading 		= $request->loading_done;
			$trip_data_id 	= $request->trip_data_id;
			$i 				= 0;
			if ($request->has('sites')) {
				$j = 0;
				foreach ($request->sites as $value) {
					// if($request->start_time[$j])
					// 	$start_time = \Carbon\Carbon::createFromFormat('H:i', $request->start_time[$j])->format('Y-m-d H:i:s');

					// if($request->end_time[$j])
					// 	$end_time = \Carbon\Carbon::createFromFormat('H:i', $request->end_time[$j])->format('Y-m-d H:i:s');
					$loads = Verifiedloads::firstOrNew(['beatplan_id'=>$request->beatplan_id[$j],'auto_trip_id'=>$request->trip_id[$j],'trip_data_id'=>$trip_data_id[$j]]);

					//return dd($loads);

					$loads->beatplan_id = $request->beatplan_id[$j];
					$loads->trip_id = $request->unique_trip_id[$j];
					$loads->sites = $value;
					$loads->verified_by_id = $request->userId;
					$loads->auto_trip_id = $request->trip_id[$j];
					$loads->trip_data_id = $trip_data_id[$j];
					$loads->status = $request->loading_done[$j];
					$loads->save();

					$trip_data = TripData::find($loads->trip_data_id);
					$trip_data->status = $loads->status;
					if($loads->status == 'loaded'){
						// $trip_data->loading_start = $start_time;
						// $trip_data->loading_finish = $end_time;
					}
					$trip_data->save();
					$j++;
				}
				return response()->json([
					'status' => 'Ok',
					'message' => 'Load verified!',
					'details' => [],
				]);
			}else{
				return response()->json([
					'status' => 'Ok',
					'message' => 'You did not select any load!',
					'details' => [],
				]);	
			}

		}
		public function getTodayTrips(Request $request)
		{
			if ($request->has('planDate')) {
				$data = Trips::leftJoin('users as filler', function($q){
					$q->on('filler.id','=','trips.filler_id');
				})->where('effective_date','=',$request->planDate)->select('trips.*','filler.name as filler_name')->get();
				return response()->json([
					'status' => 'Ok',
					'message' => 'Today Trips!',
					'details' => $data,
				]);	
			}
		}
		public function tripDetails(Request $request)
		{
			if ($request->has('id')) {
				$data = TripData::leftJoin('trips', function($q){
					$q->on('trips.id','=','trip_data.trip_id');
				})->leftJoin('users as driver', function($q){
					$q->on('driver.id','=','trips.driver_id');
				})->leftJoin('site_master', function($q){
					$q->on('site_master.id','=','trip_data.data_id');
				})->where(['trip_data.trip_id'=>$request->id])->select('site_master.site_address as address','site_master.latitude','site_master.longitude','trip_data.status')->get()->toArray();
				$dataArray = array();
				foreach ($data as $key) {
					$dataArray[][] = $key;
				}
				return 	response()->json(
					$dataArray
				);	
			}
		}
		
		public function tripById(Request $request){
			
			if($request->has('trip_id')){
				$trip = Trips::findOrFail($request->trip_id);
				return response()->json([
					'status' => 'Ok',
					'message' => 'Trips!',
					'data' => $trip
				]);	
			}else{
				return response()->json([
					'status' => 'fail',
					'message' => 'Required Parameter Missing!'
				]);	
			}
		}
		
		public function tripsByFillerId(Request $request)
		{
			if($request->has('fillerId') && $request->driverId == 'no'){
				$data = Trips::where(['filler_id' => $request->fillerId])->get();
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'Trips!',
					'details' => $data,
				]);	
			}
			if($request->has('driverId') && $request->fillerId == 'no'){
				$data = Trips::where(['driver_id' => $request->driverId])->get();
				//return dd($data[0]);
				
				foreach($data as $key=>$trip){
					$qty  = Helper::getQuantityByTripId($trip->id);
					$beatData = $trip->beat_plan_data();
					//return dd($beatData);
					$data[$key]['qty'] = $beatData[0]->qty;
					$data[$key]['sites_count'] = $beatData[0]->sites_count;
				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'Trips!',
					'details' => $data
				]);	
			}
		}
		
		public function driver_today_trip(Request $request){
			date_default_timezone_set('Asia/Calcutta');
			$effective_date = \Carbon\Carbon::now('Asia/Calcutta')->format('d-m-Y');
			$user_id = $request->user_id;
			// dd($effective_date, $user->id);
			$trips = Trips::where(['driver_id' => $user_id,'effective_date' => $effective_date])->get();
			return response()->json([
					'status' => 'Ok',
					'message' => 'Trips!',
					'details' => $trips
				]);	
		}
	
		public function tripsDetaisByTripId(Request $request)
		{
			if ($request->has('id')) {
				$data = TripData::leftJoin('trips', function($q){
					$q->on('trips.id','=','trip_data.trip_id');
				})->leftJoin('users as driver', function($q){
					$q->on('driver.id','=','trips.driver_id');
				})->leftJoin('site_master', function($q){
					$q->on('site_master.id','=','trip_data.data_id');
				})->leftJoin('beatplans', function($q){
					$q->on('beatplans.id','=','trip_data.beatplan_id');
				})->where(['trip_data.trip_id' => $request->id])->where('trip_data.status','!=','unloaded')
				->select('trip_data.id','site_master.site_id','site_master.site_name','beatplans.effective_date','trip_data.status')->get();
				//message api 
				$trip_arr = Trips::with('route','vechile','beat_plan','vendor')->find($request->id)->toArray();
				$trip_arr['qty'] = Helper::getQuantityByTripId($request->id);
				$response = $this->sendSmsForTripStart($trip_arr);
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'Trip details!',
					'details' => $data,
					'msgResponse' => $response
				]);	
			}	
		}
		public function siteDetaisByTripDataId(Request $request)
		{
			if ($request->has('id')) {
				$data = TripData::leftJoin('trips', function($q){
					$q->on('trips.id','=','trip_data.trip_id');
				})->leftJoin('users as driver', function($q){
					$q->on('driver.id','=','trips.driver_id');
				})->leftJoin('users as filler', function($q){
					$q->on('filler.id','=','trips.filler_id');
				})->leftJoin('site_master', function($q){
					$q->on('site_master.id','=','trip_data.data_id');
				})->leftJoin('beatplans', function($q){
					$q->on('beatplans.id','=','trip_data.beatplan_id');
				})->leftJoin('routes', function($q){
					$q->on('routes.id','=','trips.route_id');
				})->leftJoin('vendors', function($q){
					$q->on('vendors.id','=','trips.loading_point_id');
				})->leftJoin('vehicle_master', function($q){
					$q->on('vehicle_master.id','=','trips.vehicle_id');
				})->leftJoin('verified_loads', function($q){
					$q->on('verified_loads.trip_data_id','=','trip_data.id');
				})->where(['trip_data.id'=>$request->id])->select('trip_data.id','site_master.site_id','site_master.site_name','site_master.site_type','beatplans.mp_zone','site_master.latitude','site_master.longitude','site_master.technician_name','site_master.technician_contact1','driver.name as driverName','driver.contact as driverContact','routes.route_name','vendors.name as roname','vehicle_master.vehicle_no','filler.name as fillerName','filler.contact as fillerContact','verified_loads.id as verified_load_id')->get();
				$trip_arr = TripData::with('trip','trip.route','trip.vechile','trip.beat_plan','trip.vendor','site')->find($request->id)->toArray();
				
				$trip_arr['qty'] = Helper::getQtyByBeatplanIdAndDataid($trip_arr['beatplan_id'],$trip_arr['data_id']);
				// return dd($trip_arr);
				$tripData = TripData::find($request->id);
				$tripData->filling_start = \Carbon\Carbon::now('Asia/Calcutta')->format('Y-m-d H:i:s');
				$tripData->site_in = \Carbon\Carbon::now('Asia/Calcutta')->format('Y-m-d H:i:s');
				$tripData->save();
				$time = \Carbon\Carbon::now('Asia/Calcutta')->format('H:i:s');
				$response = $this->sendSmsForSiteIn($trip_arr, $time);
				return 	response()->json([
					'status'      => 'Ok',
					'message'     => 'Site details!',
					'details'     => $data,
					'qty' 		  => $trip_arr['qty'],
					'msgResponse' => $response
				]);	
			}	
		}
		public function loadSitesByZoneOrClient(Request $request)
		{
			$tripId = $request->tripId;
			if ($request->has('effectiveDate')){
				$date = $request->effectiveDate;
				$data = TripData::leftJoin('trips', function($q){
					$q->on('trips.id','=','trip_data.trip_id');
				})->leftJoin('site_master', function($q){
					$q->on('site_master.id','=','trip_data.data_id');
				})->leftJoin('beatplans', function($q){
					$q->on('beatplans.id','=','trip_data.beatplan_id');
				})->leftJoin('vehicle_master', function($q){
					$q->on('vehicle_master.id','=','trips.vehicle_id');
				})->leftJoin('vendors', function($q){
					$q->on('vendors.id','=','beatplans.client_id');
				})->where(['trip_data.trip_id' => $tripId, 'beatplans.effective_date' => $date])->select('trip_data.id','trips.trip_id as uniqueTripId','trips.id as trip_id','beatplans.mp_zone','vendors.name as clientName','vehicle_master.vehicle_no','site_master.site_id as siteId','site_master.site_name','trip_data.beatplan_id as beatPlanId','trip_data.data_id as site_id','trip_data.status as tripdata_status','trip_data.loading_start','trip_data.loading_finish')->get();
				$dataArray = array();
				foreach ($data as $key) {
					$quantity = $this->getQuantityFromBeatPlanData($key['beatPlanId'],$key['site_id']);
					$key['quantity'] = $quantity['quantity'];
					$dataArray[] = $key;

				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'Site details!',
					'details' => $dataArray,
				]);		
			}elseif ($request->has('clientId')) {
				$clientId = $request->clientId;
				$data = TripData::leftJoin('trips', function($q){
					$q->on('trips.id','=','trip_data.trip_id');
				})->leftJoin('site_master', function($q){
					$q->on('site_master.id','=','trip_data.data_id');
				})->leftJoin('beatplans', function($q){
					$q->on('beatplans.id','=','trip_data.beatplan_id');
				})->leftJoin('vehicle_master', function($q){
					$q->on('vehicle_master.id','=','trips.vehicle_id');
				})->leftJoin('vendors', function($q){
					$q->on('vendors.id','=','beatplans.client_id');
				})->where(['trip_data.status' => 'unloaded', 'trip_data.trip_id' => $tripId, 'beatplans.client_id' => $clientId])->select('trip_data.id','trips.trip_id as uniqueTripId','trips.id as trip_id','beatplans.mp_zone','vendors.name as clientName','vehicle_master.vehicle_no','site_master.site_id as siteId','site_master.site_name','trip_data.beatplan_id as beatPlanId','trip_data.data_id as site_id')->get()->toArray();
				$dataArray = array();
				foreach ($data as $key) {
					$quantity = $this->getQuantityFromBeatPlanData($key['beatPlanId'],$key['site_id']);
					$key['quantity'] = $quantity['quantity'];
					$dataArray[] = $key;

				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'Site details!',
					'details' => $dataArray,
				]);	
			}
		}
		public function getQuantityFromBeatPlanData($beatPlanId, $siteId)
		{
			if($beatPlanId && $siteId){
				return BeatPlanData::where(['site_id' => $siteId, 'beatplan_id' => $beatPlanId])->select('quantity')->first()->toArray();
			}
		}
		public function loadSitesVerify(Request $request)
		{
			if($request->has('data')){
				$postData = $request->data;
				$postLength = count($postData);
				for ($i=0; $i < $postLength; $i++) { 
					$loads = Verifiedloads::firstOrNew(['beatplan_id'=>$postData[$i]['beatPlanId'],'auto_trip_id'=>$postData[$i]['trip_id'],'trip_data_id'=>$postData[$i]['id']]);
					$loads->beatplan_id = $postData[$i]['beatPlanId'];
					$loads->trip_id = $postData[$i]['uniqueTripId'];
					$loads->sites = $postData[$i]['site_id'];
					$loads->verified_by_id = $postData[$i]['verified_by_id'];
					$loads->auto_trip_id = $postData[$i]['trip_id'];
					$loads->trip_data_id = $postData[$i]['id'];
					$loads->status = $postData[$i]['loading_done'];
					$loads->save();

					$trip_data = TripData::find($loads->trip_data_id);
					$trip_data->status = $loads->status;
					if($loads->status == 'loaded'){
						//$trip_data->loading_start = $postData[$i]['loadingStart'];
						//$trip_data->loading_finish = $postData[$i]['loadingEnd'];
					}
					$trip_data->save();
				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'Load verified!',
					'details' => [],
				]);
			}else{
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'You did not select any load!',
					'details' => [],
				]);	
			}
		}
		public function update_loading_time(Request $request){
			//return response()->json(['status'=>$request->all()]);
			//return dd($request->all()); 
			//date_default_timezone_set('Asia/Calcutta');
			$trip_data = TripData::find($request->trip_data_id);
			$trip_data_arr = TripData::with('trip')->find($request->trip_data_id)->toArray();
			// $datetime = \Carbon\Carbon::parse($request->datetime)->format('Y-m-d H:i:s');
			// return response()->json(['status'=>$request->all()]);
			$datetime = $request->datetime;
			if($request->action == 'start'){
				$trip_data->loading_start = $datetime;
				//$loading_start_time = \Carbon\Carbon::now('Asia/Calcutta')->format('H:i:s');
				//$response = $this->sendSmsForStartLoading($trip_data_arr, $loading_start_time);
			}
			if($request->action == 'end'){
				$trip_data->loading_finish = $datetime;
				//$loading_finish_time = \Carbon\Carbon::now('Asia/Calcutta')->format('H:i:s');
				//$response = $this->sendSmsForEndLoading($trip_data_arr,$loading_finish_time);
			}
			//dd($trip_data);
			$trip_data->save();
			return response()->json(['status'=>'success', 'trip_data' => $trip_data]);
		}
		public function update_loading_status(Request $request){
			//dd($request->all());
			$trip_data = TripData::findOrFail($request->trip_data_id);
			$trip_data->status = $request->status=='yes'?'loaded':'unloaded';
			$trip_data->save();
			return response()->json(['status'=>'success', 'trip_data' => $trip_data]);
		}
		public function tripDataCountByStatus(Request $request)
		{
			if ($request->has('clientId') && $request->has('planDate') && $request->has('zone')) {
				$clientId = $request->clientId;
				$zone = $request->zone;
				$planDate = $request->planDate;
				$adminId = Helper::getAdminIdOfClientByClientId($clientId);

				$details = array();

				$beatplanids = Beatplan::where(['beatplans.effective_date' => $planDate, 'beatplans.client_id' => $clientId, 'beatplans.mp_zone' => $zone, 'beatplans.added_by' => $adminId])->select('id')->get()->toArray();
				$planed = BeatPlanData::whereIn('beatplan_id',$beatplanids)->select(DB::raw('count(id) as planed'))->first()->toArray();
				$details['planed'] = $planed['planed']; 

				$loaded = TripData::where(['trip_data.status' => 'loaded'])->whereIn('beatplan_id',$beatplanids)->select(DB::raw('count(trip_data.id) as loaded'))->first()->toArray();
				$details['loaded'] = $loaded['loaded']; 

				$unloaded = TripData::where(['trip_data.status' => 'unloaded'])->whereIn('beatplan_id',$beatplanids)->select(DB::raw('count(trip_data.id) as unloaded'))->first()->toArray();
				$details['unloaded'] = $unloaded['unloaded']; 

				$filled = TripData::where(['trip_data.status' => 'filled'])->whereIn('beatplan_id',$beatplanids)->select(DB::raw('count(trip_data.id) as filled'))->first()->toArray();
				$details['filled'] = $filled['filled']; 
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'Sites Count',
					'details' => $details
				]);
			}		
		}
		public function tripDataForClientReport(Request $request)
		{
			if ($request->has('clientId') && $request->has('planDate') && $request->has('zone') && $request->has('adminId')) {
				$clientId = $request->clientId;
				$zone = $request->zone;
				$planDate = $request->planDate;
				$adminId = $request->adminId;
				$details = array();
				$beatplanids = Beatplan::where(['beatplans.effective_date' => $planDate, 'beatplans.client_id' => $clientId, 'beatplans.mp_zone' => $zone, 'beatplans.added_by' => $adminId])->select('id')->get()->toArray();
				$datas = TripData::with('site')->whereIn('beatplan_id',$beatplanids)->get();
				$i = 0;
				if(isset($datas) && !empty($datas)){
					foreach ($datas as $plan) {
						$details[$i]['id'] = $plan->id;
						$details[$i]['site_id'] = $plan->site->site_id;
						$details[$i]['site_name'] = $plan->site->site_name;
						$details[$i]['status'] = $plan->status;
						$details[$i]['quantity'] = Helper::getQtyByBeatplanIdAndDataid($plan->beatplan_id,$plan->data_id);
						$i++;
					}
				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'All Sites',
					'details' => $details,
					'coount' => count($details)
				]);
			}	
		}
		public function planReport(Request $request)
		{
			if ($request->has('planDate') && $request->has('adminId') && auth()->user()->type == 'subadmin') {
				$planDate = $request->planDate;
				$adminId = $request->adminId;
				$plans = Beatplan::where(['beatplans.effective_date' => $planDate, 'beatplans.added_by' => auth()->user()->id])->get();
				$details = array();
				$i = 0;
				if(isset($plans) && !empty($plans)){
					foreach ($plans as $plan) {
						$details[$i]['zone'] = $plan->mp_zone;
						$details[$i]['sites'] = $plan->beatplan_data->count('site_id');
						$details[$i]['loaded'] = $plan->loaded_count();
						$details[$i]['filled'] = $plan->filled_count();
						$i++;
					}
				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'All Counts',
					'details' => $details
				]);
			}elseif ($request->has('planDate') && $request->has('adminId') && auth()->user()->type == 'mis') {
				$allotedData = Misallottedzones::where('mis_user_id','=',auth()->user()->id)->first();
				$planDate = $request->planDate;
				$misId = $request->adminId;
				$plans = Beatplan::where(['beatplans.effective_date' => $planDate, 'beatplans.added_by' => auth()->user()->id, 'beatplans.mp_zone' => $allotedData['mp_zones'], 'beatplans.client_id' => $allotedData['allotted_client_id']])->orWhere(function($q) use ($allotedData){
					$q->where(['beatplans.added_by' => auth()->user()->created_by_id, 'beatplans.mp_zone' => $allotedData['mp_zones'], 'beatplans.client_id' => $allotedData['allotted_client_id']]);
				})->get();
				$details = array();
				$i = 0;
				if(isset($plans) && !empty($plans)){
					foreach ($plans as $plan) {
						$details[$i]['zone'] = $plan->mp_zone;
						$details[$i]['sites'] = $plan->beatplan_data->count('site_id');
						$details[$i]['loaded'] = $plan->loaded_count();
						$details[$i]['filled'] = $plan->filled_count();
						$i++;
					}
				}
				return response()->json([
					'status' => 'Ok',
					'message' => 'All Counts',
					'details' => $details,
					'query' => end($queries)
				]);
			}
		}
		public function getLoadedSitesDetails(Request $request)
		{
			if ($request->has('vehicleId')) {
				$vehicleId = $request->vehicleId;
				$data = Trips::leftjoin('trip_data', function($q){
					$q->on('trip_data.trip_id','=','trips.id');
				})->leftjoin('site_master', function($q){
					$q->on('site_master.id','=','trip_data.data_id');
				})->where(['trips.vehicle_id' => $vehicleId,'trip_data.status' =>'loaded'])->select('site_master.site_address','site_master.latitude','site_master.longitude','trip_data.status')->get();
				$originPoint = Trips::leftjoin('trip_data', function($q){
					$q->on('trip_data.trip_id','=','trips.id');
				})->leftjoin('vendors', function($q){
					$q->on('vendors.id','=','trips.loading_point_id');
				})->where(['trips.vehicle_id' => $vehicleId,'trip_data.status' =>'loaded'])->select('vendors.billing_address as site_address','vendors.latitute as latitude','vendors.longitude')->groupBy('vendors.id')->get();
				$dataArray = array();
				$dataArray[] = $originPoint;

				foreach ($data as $key) {
					$dataArray[][] = $key;
				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'All Sites of vehicle!',
					'details' => $dataArray
				]);
			}
		}
		public function getLoadedSitesFillerLocationByVehicleId(Request $request)
		{
			if ($request->has('vehicleId')) {
				$vehicleId = $request->vehicleId;
				$data = Trips::leftjoin('filler_live_map as fillerLoc', function($q){
					$q->on('fillerLoc.user_id','=','trips.filler_id');
				})->leftjoin('trip_data', function($q){
					$q->on('trip_data.trip_id','=','trips.id');
				})->where(['trips.vehicle_id' => $vehicleId,'trip_data.status' =>'loaded'])->select('fillerLoc.latitude as fillerLat','fillerLoc.longitude as fillerLng')->groupBy('fillerLoc.user_id')->get();
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'Filler Location',
					'details' => $data
				]);
			}
		}
		public function isUploadedSpeedometer(Request $request){
			$trip = Trips::find($request->trip_id);
			
			if($trip){
				return response()->json([
									'status' => 'Ok',
									'data' 	 => [
										'speedo_img' 	 => $trip->speedo_img,
										'speedo_reading' => $trip->speedo_reading
									]
								]);
			}else{
				return 	response()->json([
					'status' => 'failed',
					'message' => 'No data found',
				]);
			}
			return dd($trip);
		}
		public function uploadSpedometerValue(Request $request)
		{
			if($request->has('tripId')){
				$trips = Trips::find($request->tripId);
				if ($request->has('img')) {
					$trips->speedo_img = $request->file('img')->store('trips');
				}
				$trips->speedo_reading = $request->reading;
				if ($trips->save()) {
					return 	response()->json([
						'status' => 'Ok',
						'message' => 'Data updated!',
						'details' => []
					]);	
				}
			}
		}
		public function sendSmsForTripStart($data='')
		{
			if(isset($data) && !empty($data)){
				$response = '';
				$qty = $data['qty']['0'];
				$msg = "Hi, Vehicle No - ".$data['vechile']['vehicle_no']." for Zone - ".$data['beat_plan']['mp_zone']." for Route - ".$data['route']['route_name']." dated - ".$data['effective_date']." loaded Qty - ".$qty." Started from RO - ".$data['vendor']['name'];
				$fillerMobile = Helper::getMoblieByid($data['filler_id']);
				$areaOfficerMobile = Helper::getMoblieByid($data['field_officer_id']);
				$vendorMobile = Helper::getMoblieByVendorId($data['loading_point_id']);
				if(!empty($fillerMobile)){
					$response .= Cbis::sendSms($fillerMobile,$msg);
				}
				if(!empty($areaOfficerMobile)){
					$response .= Cbis::sendSms($areaOfficerMobile,$msg);
				}
				if(!empty($vendorMobile)){
					$response .= Cbis::sendSms($vendorMobile,$msg);
				}
				if(!empty($data['client_mobile'])){
					$client_mobile = json_decode($data['client_mobile']);
					foreach ($client_mobile as $value) {
						$response .= Cbis::sendSms($value,$msg);
					}
				}
				return $response;
			}
		}
		public function sendSmsForSiteIn($data='',$time='')
		{
			if(isset($data) && !empty($data)){
				$response = '';
				$qty = $data['qty'];
				$msg = "Hi, Vehicle No - ".$data['trip']['vechile']['vehicle_no']." for Trip Id - ".$data['trip']['trip_id']." reached at Site - ".$data['site']['site_name']." for Qty - ".$qty." at Time - ".$time;
				$fillerMobile = Helper::getMoblieByid($data['trip']['filler_id']);
				$areaOfficerMobile = Helper::getMoblieByid($data['trip']['field_officer_id']);
				$vendorMobile = Helper::getMoblieByVendorId($data['trip']['loading_point_id']);
				if(!empty($fillerMobile)){
					$response .= Cbis::sendSms($fillerMobile,$msg);
				}
				if(!empty($areaOfficerMobile)){
					$response .= Cbis::sendSms($areaOfficerMobile,$msg);
				}
				if(!empty($vendorMobile)){
					$response .= Cbis::sendSms($vendorMobile,$msg);
				}
				if(!empty($data['client_mobile'])){
					$client_mobile = json_decode($data['trip']['client_mobile']);
					foreach ($client_mobile as $value) {
						$response .= Cbis::sendSms($value,$msg);
					}
				}
				return $response;
			}
		}
		public function sendSmsForNewTrip($data='', $beatplandataid)
		{
			if(isset($data) && !empty($data)){
				$response = '';
				$vehicale_number = Helper::getVehicleNumberByVehicleId($data['vehicale_id']);
				$zone = Helper::getZoneByBeatplanId($data['beatplanid']);
				$route = Helper::getRouteNameByRouteId($data['route_id']);
				$qty = BeatPlanData::whereIn('id',$beatplandataid)->sum('quantity');
				$msg = "Hi, Vehicle No - ".$vehicale_number." for Zone - ".$zone." for Route - ".$route." dated - ".$data['effective_date']." allocated for Qty - ".$qty;
				$fillerMobile = Helper::getMoblieByid($data['fiiler']);
				$areaOfficerMobile = Helper::getMoblieByid($data['area_officer']);
				$vendorMobile = Helper::getMoblieByVendorId($data['loading_point']);
				if(!empty($fillerMobile)){
					$response .= Cbis::sendSms($fillerMobile,$msg);
				}
				if(!empty($areaOfficerMobile)){
					$response .= Cbis::sendSms($areaOfficerMobile,$msg);
				}
				if(!empty($vendorMobile)){
					$response .= Cbis::sendSms($vendorMobile,$msg);
				}
				if(!empty($data['client_mobile']) && is_array($data['client_mobile'])){
					foreach ($data['client_mobile'] as $value) {
						$response .= Cbis::sendSms($value,$msg);
					}
				}
				return $response;
			}
		}
		public function planReportByPlanDateAndZone(Request $request)
		{
			if ($request->has('planDate') && $request->has('zone') && auth()->user()->type == 'subadmin') {
				$planDate = $request->planDate;
				$zone = $request->zone;
				$plans = Beatplan::where(['beatplans.effective_date' => $planDate, 'mp_zone' =>$zone, 'beatplans.added_by' => auth()->user()->id])->get();
				$details = array();
				$i = 0;
				if(isset($plans) && !empty($plans)){
					foreach ($plans as $plan) {
						$details[$i]['zone'] = $plan->mp_zone;
						$details[$i]['sites'] = $plan->beatplan_data->count('site_id');
						$details[$i]['loaded'] = $plan->loaded_count();
						$details[$i]['filled'] = $plan->filled_count();
						$i++;
					}
				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'All Counts',
					'details' => $details
				]);
			}elseif ($request->has('planDate') && $request->has('zone') && auth()->user()->type == 'mis') {
				$allotedData = Misallottedzones::where('mis_user_id','=',auth()->user()->id)->first();
				$planDate = $request->planDate;
				$misId = $request->zone;
				$plans = Beatplan::where(['beatplans.effective_date' => $planDate, 'mp_zone' =>$zone, 'beatplans.added_by' => auth()->user()->id, 'beatplans.mp_zone' => $allotedData['mp_zones'], 'beatplans.client_id' => $allotedData['allotted_client_id']])->orWhere(function($q) use ($allotedData){
					$q->where(['beatplans.added_by' => auth()->user()->created_by_id, 'beatplans.mp_zone' => $allotedData['mp_zones'], 'beatplans.client_id' => $allotedData['allotted_client_id']]);
				})->get();
				$details = array();
				$i = 0;
				if(isset($plans) && !empty($plans)){
					foreach ($plans as $plan) {
						$details[$i]['zone'] = $plan->mp_zone;
						$details[$i]['sites'] = $plan->beatplan_data->count('site_id');
						$details[$i]['loaded'] = $plan->loaded_count();
						$details[$i]['filled'] = $plan->filled_count();
						$i++;
					}
				}
				return 	response()->json([
					'status' => 'Ok',
					'message' => 'All Counts',
					'details' => $details,
					'query' => end($queries)
				]);
			}
		}
		
		public function loading_point_distance(Request $request){
			
			$trip = Trips::findOrFail($request->trip_id);
			if($trip->vendor->latitute && $trip->vendor->longitude){
				$distance = $this->distance($request->current_lat, $request->current_lng, $trip->vendor->latitute, $trip->vendor->longitude);
				return response()->json([
						'status' => 'success',
						'message' => $distance == 'not_found'?'mismatch':'found',
						'distance' => $distance,
					]);

			}else{
				return response()->json([
						'status' => 'fail',
						'message' => 'Latitude or longitude not found',
						'distance' => ''
					]);
			}
		}
		
		public function tripComplete(Request $request){
			if($request->has('trip_id')){
				
				$trip = Trips::findOrFail($request->trip_id);
				$trip->status = 'completed';
				$trip->save();
				
				return response()->json([
					'status' => 'success',
					'message' => $trip->status,
					'data' => $trip
				]);
			}else{
				return response()->json([
						'status' => 'fail',
						'message' => 'Required Parameter Missing'
					]);
			}
		}
		
		public function checkCompleteStatus(Request $request){
			if($request->has('trip_id')){
				$trip = Trips::where(['status' => 'completed', 'id' => $request->trip_id])->first();
				return response()->json([
					'status' => 'success',
					'message' => $trip->status,
					'data' => $trip
				]);
			}else{
				return response()->json([
					'status' => 'fail',
					'message' => 'Required Parameter Missing'
				]);
			}
		}
		
		public function distance($lat1, $long1, $lat2, $long2) {

			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?key=AIzaSyB_aaYKAvDUt155kQaWXYqx0PUSXk5EEk4&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response, true);
			// return dd($response_a);
			$dist = $response_a['rows'][0]['elements'][0]['distance']['text']??'not_found';
			return str_replace(",",".",$dist);
			dd($dist);
			$time = $response_a['rows'][0]['elements'][0]['duration']['text'];
		}
	}
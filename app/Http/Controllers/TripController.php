<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\Trips;
use App\Sitemaster;
use App\Beatplan;
use App\BeatPlanData;
use App\TripData;
use App\Verifiedloads;
use App\Divert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Cbis;
use App\Helpers\Helper;
use App\Misallottedzones;
class TripController extends Controller
{
	public function index(Request $request){

		return view('v3.trip.index');

		if (auth()->user()->type == 'subadmin') {
			
		}elseif (auth()->user()->type == 'mis') {

		}
	}
	

	public function datatable(Request $request){
		if (auth()->user()->type == 'subadmin') {
			$all = array();
			$Ids = $this->getAllMisIdsBySubAdminId(auth()->user()->id);
			foreach ($Ids as $key) {
				array_push($all, $key->id);
			}
			array_push($all, auth()->user()->id);
			$query = Trips::with(['vechile','driver','filler'])->select('trips.*')->whereIn('added_by',$all);
		}elseif (auth()->user()->type == 'mis') {

			$allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
			if (isset($allotedData) && !empty($allotedData)) {
				$query = Trips::whereHas('beat_plan', function($q) use($allotedData){
					$i = 1;
					foreach ($allotedData as $key) {
						if ($i == 1 ) {
							$q->where(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);
						}else{
							$q->orWhere(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);
						}
						$i++;
					}
				});
				
				//$trips = $query->orderBy('id','DESC')->paginate(10);
			}else{
				$query = Trips::whereHas('beat_plan', function($q){
					$q->where(['added_by' => auth()->user()->id]);
				});
			}

		}

//		dd($request->all());

		if($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)){
			$query->whereBetween('effective_date', [$request->start_date, $request->end_date]);
		}

		return \DataTables::of($query)
		->addColumn('action', function(Trips $data) {
			return '<div class="action-list"><a href="' . route('trip.edit',$data->id) . '" class="btn btn-sm btn-clean btn-icon"><i class="la la-edit"></i></a> <a href="javascript:;" data-href="'.route('trip.remove',$data->id).'" id="'. $data->id.'" class="delete btn btn-sm btn-clean btn-icon"><i class="la la-trash text-danger"></i></a></div>';
		})
		->addColumn('vehicle', function(Trips $data) {
			return $data->vechile->vehicle_no ??'';
		})
		->addColumn('driver_name', function(Trips $data) {
			return $data->driver->name ?? '';
		})
		->addColumn('filler_name', function(Trips $data) {
			return $data->filler->name ?? '';
		})    
		->orderColumn('id', function ($query, $order) {
			$query->orderBy('id', $order);
		})
		->rawColumns(['action'])->make(true);
	}

	public function edit(Request $request, $id){
		if(auth()->user()->type == 'subadmin'){
			$drivers = User::where(['type' => 'driver', 'created_by_id' => auth()->user()->id])->get();
			$fillers = User::where(['type' => 'filler', 'created_by_id' => auth()->user()->id])->get();
			$areaOfficers = User::where(['type' => 'field_officer', 'created_by_id' => auth()->user()->id])->get();
			$areaOfficers = User::where(['type' => 'field_officer', 'created_by_id' => auth()->user()->id])->get();
			$vendors = Vendor::where(['type' => 'vendor', 'vendor_category' => 'PUMP', 'created_by_id' => auth()->user()->id])->get();
			
		}elseif (auth()->user()->type == 'mis') {
			$drivers = User::where(['type' => 'driver', 'created_by_id' => auth()->user()->created_by_id])->get();
			$fillers = User::where(['type' => 'filler', 'created_by_id' => auth()->user()->created_by_id])->get();
			$areaOfficers = User::where(['type' => 'vendor', 'created_by_id' => auth()->user()->created_by_id])->get();
			$vendors = Vendor::where(['type' => 'vendor', 'vendor_category' => 'PUMP', 'created_by_id' => auth()->user()->created_by_id])->get();
			
		}
		$trip = Trips::findOrFail($id);

		return view('v3.trip.edit',['trip'=>$trip,'drivers'=>$drivers,'fillers'=>$fillers,'areaOfficers'=>$areaOfficers,'vendors'=>$vendors]);
	}
	
	public function update(Request $request){
		// $msgResp = $this->sendSmsForUpdateTrip($request->all());
		$validatedData = $request->validate([
			'vehicale_id' => 'required',
			'route_id' => 'required',
			'effective_date' => 'required',
			'driver' => 'required',
			'filler' => 'required',
			'loading_point' => 'required',
			'trip_id' => 'required',
			'siteArray' => 'required',
			'zone' => 'required',
		]);
		
		$sitesArray = array_filter($request->siteArray)??[];
		$beatplanid = $request->beatplanid;
		$beatplanid = $request->beatPlanIdForS;
		$beatplandataid = $request->beatplandataid;

		$beatplandataid = array_filter(array_column($request->siteArray, 'beatplandataid'), 'strlen');
		$tripdataid = array_filter(array_column($request->siteArray, 'tripdataid'), 'strlen');
		$asset_id = array_filter(array_column($request->assetArray, 'asset_name'), 'strlen');
		$qty_allocate = array_filter(array_column($request->assetArray, 'qty_allocate'), 'strlen');
		$client_name = array_filter(array_column($request->clientArray, 'client_name'), 'strlen');
		$client_mobile = array_filter(array_column($request->clientArray, 'client_mobile'), 'strlen');
		$client_email = array_filter(array_column($request->clientArray, 'client_email'), 'strlen');

		$trip_data_ids = TripData::where('trip_id', $request->tripID)->pluck('id')->toArray();
		$diff_ids = array_diff($trip_data_ids,$tripdataid);
		$diff_ids = array_values($diff_ids); 
		
		if($diff_ids){
			//$tripData = TripData::whereIN('id', $diff_ids)->whereNotNull('divert_from_tripdata_id')->get();
			$tripData = TripData::whereIN('id', $diff_ids)->get();
			
			if($tripData){
				foreach($tripData as $key=>$trip_data){
					if($trip_data->divert_from_tripdata_id){
						$tripdata1 = TripData::find($trip_data->divert_from_tripdata_id);
						if($tripdata1){
							$beat_plan_data = BeatPlanData::where(['site_id' => $tripdata1->data_id,'beatplan_id' => $tripdata1->beatplan_id])->first();
							
							if($beat_plan_data){
								$beat_plan_data->quantity = $beat_plan_data->quantity+$trip_data->divert_from_qty;
								$beat_plan_data->status = 'loaded';
								$beat_plan_data->save();
							}
						}
						
						$divert = Divert::where(['from_tripdata_id' => $trip_data->divert_from_tripdata_id])->delete();
					//return dd($beat_plan_data,$trip_data,$divert);
					}
					$bpld = BeatPlanData::where(['site_id' => $trip_data->data_id,'beatplan_id' => $trip_data->beatplan_id])->first();
					//dd($bpld);
					$bpld->status = 'pending';
					$bpld->save();
					Verifiedloads::where('trip_data_id',$trip_data->id)->delete();
					TripData::where('id', $trip_data->id)->delete();
				}
			}
			
		}
		
		$trips = Trips::find($request->tripID);
		$trips->beatplan_id = $beatplanid;
		//$trips->added_date = $request->current_date;
		//$trips->effective_date = $request->effective_date;
		$trips->vehicle_id = $request->vehicale_id;
		$trips->route_id = $request->route_id;
		$trips->driver_id = $request->driver;
		$trips->filler_id = $request->filler;
		$trips->field_officer_id = $request->area_officer;
		$trips->loading_point_id = $request->loading_point; 
		//$trips->trip_id = $request->trip_id;
		//$trips->trip_data_id = $request->trip_data_id;
		
		if(!empty($asset_id)){
			$trips->assets = json_encode($asset_id);	
		}
		if(!empty($qty_allocate) && !is_null($qty_allocate)){
			$trips->asset_qty = json_encode($qty_allocate);
		}
		if(!empty($client_name) && !is_null($client_name)){
			$trips->clients_name = json_encode($client_name);
		}
		if(!empty($client_mobile) && !is_null($client_mobile)) {
			$trips->clients_mobile = json_encode($client_mobile);
		}
		if(!empty($client_email) && !is_null($client_email)) {
			$trips->client_email = json_encode($client_email);
		}
		
		$trips->save();	
		if($sitesArray){
			foreach ($sitesArray as $value) {
				$tripdata = TripData::firstOrNew(['trip_id'=>$trips->id,'data_id'=>$value['siteid'],'beatplan_id'=>$value['beatplanid']]);
				$tripdata->trip_id = $trips->id;
				$tripdata->data_id = $value['siteid']; // Site id
				$this->changeStatusOfBeatPlanData('allocated', $value['beatplandataid']);
				$tripdata->beatplan_id = $beatplanid;
				//return dd($tripdata);
				$tripdata->save();
			}
		}
		
		$request->request->add(['beatplandataid' => $beatplandataid]);

		//dd($request->all());
		$msgResp = $this->sendSmsForUpdateTrip($request->all());	
		return redirect()->back()->with('success', 'Trip Updated successfully!');
	}
	
	public function tripAllotment()
	{
		if(auth()->user()->type == 'subadmin'){
			$drivers = User::where(['type' => 'driver', 'created_by_id' => auth()->user()->id])->get();
			$fillers = User::where(['type' => 'filler', 'created_by_id' => auth()->user()->id])->get();
			$areaOfficers = User::where(['type' => 'field_officer', 'created_by_id' => auth()->user()->id])->get();
			$vendors = Vendor::where(['type' => 'vendor', 'vendor_category' => 'PUMP', 'created_by_id' => auth()->user()->id])->get();
			return view('v3.trip.allotment',['drivers'=>$drivers,'fillers'=>$fillers,'areaOfficers'=>$areaOfficers,'vendors'=>$vendors]);
		}elseif (auth()->user()->type == 'mis') {
			$drivers = User::where(['type' => 'driver', 'created_by_id' => auth()->user()->created_by_id])->get();
			$fillers = User::where(['type' => 'filler', 'created_by_id' => auth()->user()->created_by_id])->get();
			$areaOfficers = User::where(['type' => 'field_officer', 'created_by_id' => auth()->user()->created_by_id])->get();
			$vendors = Vendor::where(['type' => 'vendor', 'vendor_category' => 'PUMP', 'created_by_id' => auth()->user()->created_by_id])->get();
			return view('v3.trip.allotment',['drivers'=>$drivers,'fillers'=>$fillers,'areaOfficers'=>$areaOfficers,'vendors'=>$vendors]);
		}
	}
	public function getTripModalData(Request $request)
	{
		//$data = $request->formData;
		dd($_GET['formData']['_token']);

		$modal = '';
		$modal .= '<div class="modal fade" id="tripAllotModal" tabindex="-1" role="dialog" aria-labelledby="tripAllotModalTitle" aria-hidden="true">';
		$modal .= '<div class="modal-dialog modal-dialog-centered" role="document">';
		$modal .= '<div class="modal-content">';
		$modal .= '<div class="modal-header">';
		$modal .= '<h5 class="modal-title" id="tripAllotModalTitle">Modal title</h5>';
		$modal .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
		$modal .= '<span aria-hidden="true">&times;</span>';
		$modal .= '</button>';
		$modal .= '</div>';
		$modal .= '<div class="modal-body">';
		$modal .= '<div class="row"><div class="col"><label>Date: </label></div><div class="col"><label>Beat Plan Date: </label></div></div>';
		$modal .= '<div class="row"><div class="col"><label>MP/Zone: </label></div><div class="col"><label>Route Plan: </label></div></div>';
		$modal .= '<div class="row"><div class="col"><label>Route Plan: </label></div><div class="col"><label>Vehicle Number: </label></div></div>';
		$modal .= '<div class="row"><div class="col"><label>Driver Name: </label></div><div class="col"><label>Driver Mobile: </label></div></div>';
		$modal .= '<div class="row"><div class="col"><label>AO Name: </label></div><div class="col"><label>AO Mobile: </label></div></div>';
		$modal .= '<div class="row"><div class="col"><label>No Of Sites: </label></div><div class="col"><label>Sites Quantity: </label></div></div>';
		$modal .= '<table><th>Site Id</th><th>Qty</th>';
		$modal .= '<tr>';
		$modal .= '<td>8723487234</td>';
		$modal .= '<td>85</td>';
		$modal .= '</tr>';
		$modal .= '</table>';
		$modal .= '</div>';
		$modal .= '<div class="modal-footer">';
		$modal .= '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
		$modal .= '<button type="button" class="btn btn-primary">Save changes</button>';
		$modal .= '</div></div></div></div>';
	}
	public function loadVerification(Request $request)
	{
		if($request->has('beat_id')){
			$beat 		= Beatplan::find($request->beat_id);
			$beat_date 	= $beat->effective_date;
			$trip_id 	= $beat->trip->trip_id??0;
		}else{
			$beat_date 	= '';
			$trip_id 	= '';
		}

		return view('v3.trip.verification', compact('beat_date','trip_id'));
	}
	public function storeTrip(Request $request)
	{

		$validatedData = $request->validate([
			'vehicale_id' => 'required',
			'route_id' => 'required',
			'effective_date' => 'required',
			'driver' => 'required',
			'filler' => 'required',
			'loading_point' => 'required',
			'trip_id' => 'required',
			'siteArray' => 'required',
			'zone' => 'required'
		]);
		$sitesArray = $request->siteArray;
		$beatplanid = $request->beatplanid;
		$beatplanid = $request->beatPlanIdForS;
		$beatplandataid = $request->beatplandataid;

		$asset_id = array_filter(array_column($request->assetArray, 'asset_name'), 'strlen');
		$qty_allocate = array_filter(array_column($request->assetArray, 'qty_allocate'), 'strlen');
		$client_name = array_filter(array_column($request->clientArray, 'client_name'), 'strlen');
		$client_mobile = array_filter(array_column($request->clientArray, 'client_mobile'), 'strlen');
		$client_email = array_filter(array_column($request->clientArray, 'client_email'), 'strlen');

		if(!empty($client_email) && !is_null($client_email)) {
			
		}

		//$sdsd = array_filter($asset_id, 'strlen');

		// return dd($asset_id, $qty_allocate, $client_name);
		
		if (isset($sitesArray) && !empty($sitesArray) && !in_array(null, $sitesArray) ) {
			$i = 0;
			$trips = new Trips();
			$trips->beatplan_id = $beatplanid;
			$trips->added_date = $request->current_date;
			$trips->effective_date = $request->effective_date;
			$trips->vehicle_id = $request->vehicale_id;
			$trips->route_id = $request->route_id;
			$trips->driver_id = $request->driver;
			$trips->filler_id = $request->filler;
			$trips->field_officer_id = $request->area_officer;
			$trips->loading_point_id = $request->loading_point; 
			$trips->trip_id = $request->trip_id;
			//$trips->trip_data_id = $request->trip_data_id;
			
			if(!empty($asset_id)){
				$trips->assets = json_encode($asset_id);	
			}
			if(!empty($qty_allocate) && !is_null($qty_allocate)){
				$trips->asset_qty = json_encode($qty_allocate);
			}
			if(!empty($client_name) && !is_null($client_name)){
				$trips->clients_name = json_encode($client_name);
			}
			if(!empty($client_mobile) && !is_null($client_mobile)) {
				$trips->clients_mobile = json_encode($client_mobile);
			}
			if(!empty($client_email) && !is_null($client_email)) {
				$trips->client_email = json_encode($client_email);
			}
			$trips->added_by = auth()->user()->id;

			//return dd($trips);

			$trips->save();
			if($sitesArray){
				foreach ($sitesArray as $value) {
					$tripdata = new TripData;
					$tripdata->trip_id = $trips->id;
					$tripdata->data_id = $value['siteid']; // Site id
					$this->changeStatusOfBeatPlanData('allocated', $value['beatplandataid']);
					$tripdata->beatplan_id = $beatplanid;
					//return dd($tripdata);
					$tripdata->save();
					$i++;	
				}
			}
			// send sms notification
			$response = $this->sendSmsForNewTrip($request->all());
			$mailResponse = $this->sendEmailToClients($request->all());
			//return back()->with('success','Trip alloted successfully!'); 
			return redirect('/trip')->with('success', 'Trip alloted successfully!');
		}else{
			return back()->with('error','Please enter sites details!'); 
		}
	}
	public function effectiveDateForLoad(Request $request, Trips $trip){
		$response = [];$numrecords = 10;
		if ($request->has('name')) {
			$search = $request->name;
			if(auth()->user()->type == 'subadmin'){
				$data = $trip->where('effective_date', 'LIKE', "%{$search}%")->where(['added_by' => auth()->user()->id])->limit($numrecords)->groupBy('effective_date')->get();
			}elseif (auth()->user()->type == 'mis') {
				$data = $trip->where('effective_date', 'LIKE', "%{$search}%")->where(['added_by' => auth()->user()->created_by_id])->limit($numrecords)->get();
			}elseif(auth()->user()->type == 'field_officer'){
				$data = $trip->where('effective_date', 'LIKE', "%{$search}%")->where(['added_by' => auth()->user()->created_by_id])->limit($numrecords)->get();
			}
			
			foreach ($data as $p) { 
				if($p->beat_plan){
					$response[] = array("id" => $p->id, 'vendor_code'=>$p->beat_plan->client->vendor_code, "name" => $p->effective_date.' '.$p->beat_plan->client->vendor_code, "effective_date" => $p->effective_date); 
				}				
			}
		} else {
			$data = $trip->limit($numrecords)->get();
		}
		return response()->json($response);
	}
	public function tripIdLoad(Request $request, Trips $trip, $effectiveDate)
	{
		$response = [];$numrecords = 10;
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
	public function getMisIds($subAdminId='')
	{
		if(isset($subAdminId) && !empty($subAdminId)){
			$misIds = User::where(['created_by_id' => $subAdminId,'type' => 'mis'])->select('id')->get();
			return implode($misIds, ',');
		}
	}
	public function loadSites(Request $request, Trips $trip)
	{
		//$tripDetails = $trip->where(['trip_id'=>$request->trip_id, 'effective_date' => $request->effective_date_load, 'vehicle_id' => $request->vehicle_id, 'status' => 'unloaded'])->first();
		
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
			$action = true;
			$list = true;
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
		
		$client = Beatplan::where(['effective_date' => $request->effective_date_load])->groupBy('client_id')->get();
		
		if(!empty($tripDetails1)){
			$site_ids = TripData::where('trip_id',$request->trip_id)->pluck('data_id')->toArray();
			
			$sites 	   = Sitemaster::whereNotIn('id',$site_ids)->orderBy('site_name','ASC')->get();
			$drivers 		= User::where(['type' => 'driver'])->get();
			$fillers 		= User::where(['type' => 'filler'])->get();
			$areaOfficers 	= User::where(['type' => 'field_officer'])->get();
			$vendors 		= Vendor::where(['type' => 'vendor', 'vendor_category' => 'PUMP'])->get();
			$trips 			= Trips::limit(10)->get();
		}else{
			$sites = [];
			$drivers = [];
			$fillers = [];
			$areaOfficers = [];
			$vendors = [];
			$trips = [];
		}

		return view('v3.trip.load-sites',['trips'=>$tripDetails,'trips1'=>$tripDetails1,'mp_zone'=>$mp_zone,'client'=>$client,'action'=>$action, 'sites'=>$sites, 'drivers'=>$drivers, 'fillers'=> $fillers, 'areaOfficers'=> $areaOfficers, 'vendors'=>$vendors, 'load_trips'=>$trips]);
		if($tripDetails) {
		}

	}
	public function loadSitesVerify(Request $request)
	{
		$siteList 		= array();
		$tripIdList 	= array();
		$loading 		= $request->loading_done;
		$autoTripId 	= $request->auto_trip_id;
		$trip_data_id 	= $request->trip_data_id;
		$i 				= 0;
		
		if ($request->has('sites')) {
			$j = 0;
			foreach ($request->sites as $value) {
				
				//dd($request->all());
				/* if($request->start_time[$j])
				$start_time = \Carbon\Carbon::createFromFormat('H:i', $request->start_time[$j])->format('Y-m-d H:i:s');
				
				if($request->end_time[$j])
				$end_time = \Carbon\Carbon::createFromFormat('H:i', $request->end_time[$j])->format('Y-m-d H:i:s'); */

				$loads = Verifiedloads::firstOrNew(['beatplan_id'=>$request->beatplan_id[$j],'auto_trip_id'=>$request->trip_id[$j],'trip_data_id'=>$trip_data_id[$j]]);
				
				//return dd($loads);
				
				$loads->beatplan_id = $request->beatplan_id[$j];
				$loads->trip_id = $request->unique_trip_id[$j];
				$loads->sites = $value;
				$loads->verified_by_id = auth()->user()->id;
				$loads->auto_trip_id = $request->trip_id[$j];
				$loads->trip_data_id = $trip_data_id[$j];
				$loads->status = $request->loading_done[$j];
				$loads->save();

				$trip_data = TripData::find($loads->trip_data_id);
				$trip_data->status = $loads->status;
				//return dd($request->start_time[$j]);
				if(isset($request->start_time[$j]) && !empty($request->start_time[$j]))
					$trip_data->loading_start = $request->start_time[$j];
				if(isset($request->end_time[$j]) && !empty($request->end_time[$j]))
					$trip_data->loading_finish = $request->end_time[$j];
				if($loads->status == 'loaded'){
				}
				$trip_data->save();

				//$this->changeStatusUnloadedToLoaded($request->trip_id, $value, $request->beatplan_id, $loads->status);	
				$j++;
			}
			return back()->with('success', 'Load verified!');
		}else{
			return back()->with('error', 'You did not select any load!');	
		}
		
	}
	
	public function update_loading_time(Request $request){
		date_default_timezone_set('Asia/Calcutta');
		$trip_data = TripData::find($request->trip_data_id);
		$trip_data_arr = TripData::with('trip')->find($request->trip_data_id)->toArray();
		if($request->action == 'start'){
			$trip_data->loading_start = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
			$loading_start_time = \Carbon\Carbon::now()->format('H:i:s');
			$response = $this->sendSmsForStartLoading($trip_data_arr, $loading_start_time);
		}
		if($request->action == 'end'){
			$trip_data->loading_finish = \Carbon\Carbon::now('Asia/Calcutta')->format('Y-m-d H:i:s');
			$loading_finish_time = \Carbon\Carbon::now('Asia/Calcutta')->format('H:i:s');
			$response = $this->sendSmsForEndLoading($trip_data_arr,$loading_finish_time);
		}
		$trip_data->save();
		return response()->json(['status'=>'success', 'trip_data' => $trip_data]);
	}
	
	public function allLoad(Request $request)
	{
		if($request->has('action')){
			$drivers 		= User::where(['type' => 'driver'])->get();
			$fillers 		= User::where(['type' => 'filler'])->get();
			$areaOfficers 	= User::where(['type' => 'field_officer'])->get();
			$vendors 		= Vendor::where(['type' => 'vendor', 'vendor_category' => 'PUMP'])->get();
			$site_ids 		= Verifiedloads::where('auto_trip_id',$request->trip_id)->pluck('sites')->toArray();
			$sites 	   		= Sitemaster::whereNotIn('id',$site_ids)->orderBy('site_name','ASC')->get();
			return view('v3.trip.loads-data', compact('drivers', 'fillers', 'areaOfficers', 'vendors', 'sites'));
		}else{
			
			return view('v3.trip.all-loads',['trips' => []]);
		}

	}

	public function load_datatable(Request $request){
		$query 	= 	Trips::select('trips.*')
					->with(['vechile','filler','driver'])
					->join('verified_loads',function($join){
						$join->on('trips.id',"=",'verified_loads.auto_trip_id');
					})
					//->orderBy('effective_date', 'DESC')
					->groupBy('verified_loads.auto_trip_id');

		if($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)){
			$query->whereBetween('effective_date', [$request->start_date, $request->end_date]);
		}

		return \DataTables::of($query)
		->addColumn('trip_id', function(Trips $data) {
			return '<a href="'.route('all-loads').'?trip_id='. $data->id .'&action=load_data">'.$data->trip_id??''.'</a>';
		})
		->addColumn('vehicle', function(Trips $data) {
			return $data->vechile->vehicle_no ??'';
		})
		->addColumn('driver_name', function(Trips $data) {
			return $data->driver->name ?? '';
		})
		->addColumn('filler_name', function(Trips $data) {
			return $data->filler->name ?? '';
		})
		->orderColumn('effective_date', function ($query, $order) {
			$query->orderBy('effective_date', $order);
		})
		->orderColumn('trip_id', function ($query, $order) {
			$query->orderBy('trip_id', $order);
		})
		->rawColumns(['trip_id'])->make(true);

	}

	public function load_datatable_by_trip_id(Request $request){

		if(auth()->user()->type == 'subadmin'){
			$data = Verifiedloads::select('verified_loads.*')->with(['site','trip.driver','trip.filler','trip' => function ($query) {
				$query->where('added_by', auth()->user()->id);
			}])->where('auto_trip_id',$request->trip_id)
			->join('trips', function($q){
				$q->on('trips.id','=','verified_loads.auto_trip_id');
			})
			->join('trip_data', function($q){
				$q->on('trip_data.id','=','verified_loads.trip_data_id');
			});

			$site_ids = Verifiedloads::where('auto_trip_id',$request->trip_id)->pluck('sites')->toArray();
			$sites 	   = Sitemaster::whereNotIn('id',$site_ids)->orderBy('site_name','ASC')->get();
			

		}elseif (auth()->user()->type == 'driver') {
			$data = Verifiedloads::with(['site','trip.driver','trip.filler','trip' => function ($query) {
				$query->where('driver_id', auth()->user()->id);
			}])
			->where('auto_trip_id',$request->trip_id)
			->join('trips', function($q){
				$q->on('trips.id','=','verified_loads.auto_trip_id');
			})
			->join('trip_data', function($q){
				$q->on('trip_data.id','=','verified_loads.trip_data_id');
			});

			$site_ids = Verifiedloads::where('auto_trip_id',$request->trip_id)->pluck('sites')->toArray();
			$sites 	   = Sitemaster::whereNotIn('id',$site_ids)->orderBy('site_name','ASC')->get();

			
		}elseif(auth()->user()->type == 'filler'){

			$data = Verifiedloads::with(['site','trip.driver','trip.filler','trip' => function ($query) {
				$query->where('filler_id', auth()->user()->id);
			}])
			->where('auto_trip_id',$request->trip_id)
			->join('trips', function($q){
				$q->on('trips.id','=','verified_loads.auto_trip_id');
			})
			->join('trip_data', function($q){
				$q->on('trip_data.id','=','verified_loads.trip_data_id');
			});

			$site_ids = Verifiedloads::where('auto_trip_id',$request->trip_id)->pluck('sites')->toArray();
			$sites 	   = Sitemaster::whereNotIn('id',$site_ids)->orderBy('site_name','ASC')->get();

			
		}

		if($request->status){
			$data->where('verified_loads.status', $request->status);
		}

		return \DataTables::of($data)
		->addColumn('trip_id', function(Verifiedloads $site) {
			return $site->trip->trip_id??'';
		})
		->addColumn('site_id', function(Verifiedloads $site) {
			return $site->site->site_id ??'';
		})
		->addColumn('site_name', function(Verifiedloads $site) {
			return $site->site->site_name ??'';
		})
		->addColumn('site_cat', function(Verifiedloads $site) {
			return $site->site->site_category ??'';
		})
		->addColumn('tech_name', function(Verifiedloads $site) {
			return $site->site->technician_name ??'';
		})
		->addColumn('tech_no', function(Verifiedloads $site) {
			return $site->site->technician_contact1 ??'' . ' '.$site->site->technician_contact2 ??'';
		})
		->addColumn('qty', function(Verifiedloads $site) {
			return $site->trip_data->beat_plan_data()->quantity??'';
		})
		->addColumn('driver_name', function(Verifiedloads $site) {
			return $site->trip->driver->name ?? '';
		})
		->addColumn('filler_name', function(Verifiedloads $site) {
			return $site->trip->filler->name ?? '';
		})
		->addColumn('status', function(Verifiedloads $site) {
			$class =  'info';
			if($site->status == 'loaded'){
				$class =  'warning';
			}
			if($site->status == 'filled'){
				$class =  'success';
			}
			return '<span class="label label-lg font-weight-bold label-light-'.$class.' label-inline">'.ucfirst($site->status).'</span>';
			return $site->status;
		})
		->addColumn('action', function(Verifiedloads $site) {
			$html = '';
			$html .= '<a href="javascript: void(0);" class="btn btn-primary lModal" data-toggle="modal" data-target="#transferLoadModel" verified_id = "'.$site->id.'">Load Transfer</a>';
			if($site->status != 'filled' && $site->status != 'unloaded'){
			$html .= ' <a href="javascript: void(0);" class="btn btn-primary dModal" data-toggle="modal" data-target="#divertLoadModel" site_id="'.$site->site->site_id.'" site_name="'.$site->site->site_name.'" site_qty = "'.$site->trip_data->beat_plan_data()->quantity.'" site_id_primary = "'.$site->site->id.'" verified_id = "'.$site->id.'">Divert</a>';
			}

			return $html;
		})
		->orderColumn('status', function ($query, $order) {
			$query->orderBy('status', $order);
		})
		->rawColumns(['action', 'status'])->make(true);

	}
	public function allLoadData(){
		
	}
	public function changeStatusUnloadedToLoaded($trip_id, $site_id, $beatplan_id, $status)
	{
		$trip_data = TripData::where(['type' => 'site', 'trip_id' => $trip_id, 'data_id' => $site_id, 'beatplan_id' => $beatplan_id])->first();

		$trip_data->status = $status == 'loaded' ? 'loaded': 'unloaded';
		$trip_data->save();
		/*if (isset($id) && !empty($id)) {
			$trip = Trips::find($id);
			$trip->status = 'loaded';
			if($trip->save()){
				return true;
			}

		}*/
	}
	public function changeStatusOfBeatPlanData($status='', $beatPlanDataId= '')
	{
		if (isset($status) && isset($beatPlanDataId)) {
			$data = BeatPlanData::find($beatPlanDataId);
			$data->status = $status;
			$data->save();
		}
	}
	public function loadMapForTrip($tripId='')
	{
		return view('trip.trip-map',['tripId' => $tripId]);
	}
	public function pdf(Request $request){
		if($request->has('action')){
			$trip_id = $request->trip_id;
			$trip    = Trips::find($trip_id);
			if($request->action == 'view_pdf' && $request->trip_id){
				if(Storage::exists(('trip_map').'/'.$trip->trip_id.'-'.$trip->id.'.pdf')) {
					$pdf_url = storage_path(('app/trip_map').'/'.$trip->trip_id.'-'.$trip->id.'.pdf');
					return response()->file($pdf_url);
				}else{
					return abort(404, 'Page not found');
				}
			}
			if($request->action == 'view') {
				return redirect()->route('trip-map-pdf',['action'=>'view_pdf','trip_id'=>$trip->id]);
			}
			
			if($request->action == 'generate') {
				include(app_path() . '/Lib/Mpdf/vendor/autoload.php');
				$mpdf 	 = new \Mpdf\Mpdf();
				$trip_id = $request->trip_id;
				$trip    = Trips::find($trip_id);
				$vendor  = $trip->vendor;
				$data    = TripData::leftJoin('site_master',function($q){
					$q->on('site_master.id','=','trip_data.data_id');
				})->where(['trip_data.trip_id'=>$trip_id])->where('latitude','<>','0')->where('longitude','<>','0')->select('site_master.latitude as lat','site_master.longitude as lng','site_master.site_id','site_master.site_name','site_master.technician_name','site_master.technician_contact1','site_master.technician_contact2')->get()->toArray();
				
				$site_html = "<style> table, tr, td, th { border: 1px solid #000; } tr, td, th{ padding: 5px; }</style>";
				$site_html .= '<table style="border: 1px solid #000"><tr><th>SR. No.</th><th>Site Name</th><th>Site ID</th><th>Technician Name</th><th>Technician Contact</th><th>Distance</th></tr>';
				$previousValue = null;
				$distance = [];
				foreach($data as $key=>$val){
					//dd($val,next($data),$val);
					//$next = prev($data);
					$counter = $key+1;
					$site_html .= "<tr>";
					if($previousValue){
						//dd($previousValue,$val);
						$dis = $this->distance($previousValue['lat'], $previousValue['lng'], $val['lat'], $val['lng']);
						$site_html .= '<td>'.$counter.'</td><td>'.$val['site_name'].'</td><td>'.$val['site_id'].'</td><td>'. $val['technician_name'].'</td><td>'.$val['technician_contact1'].'/'.$val['technician_contact2'].'</td><td>'.$dis.'</td>';
						$distance[] = str_replace(' km','',$dis);
					}else{
						if($vendor){
							$dis = $this->distance($vendor->latitute, $vendor->longitude, $val['lat'], $val['lng']);
							$site_html .= '<td>'.$counter.'</td><td>'.$val['site_name'].'</td><td>'.$val['site_id'].'</td><td>'. $val['technician_name'].'</td><td>'.$val['technician_contact1'].'/'.$val['technician_contact2'].'</td><td>'.$dis.'</td>';
							$distance[] = str_replace(' km','',$dis);
						}else{
							$site_html .= '<td>'.$counter.'</td><td>'.$val['site_name'].'</td><td>'.$val['site_id'].'</td><td>'. $val['technician_name'].'</td><td>'.$val['technician_contact1'].'/'.$val['technician_contact2'].'</td><td>'.$dis.'</td>';
						}
					}
					$site_html .= "<tr>";
					$previousValue = $val;
				}

				$site_html .="</table>";
				
				$waypoints = array_map( function($v){ 
					unset($v['site_id']);
					unset($v['site_name']);
					unset($v['technician_name']);
					unset($v['technician_contact1']);
					unset($v['technician_contact2']);
					return implode(',',(array)$v);
				},$data);
				//dd($waypoints);
				$waypoints   = array_values($waypoints);
				if($vendor)
					$origin 	 = $vendor->latitute.','.$vendor->longitude;
				else
					$origin 	 = array_shift($waypoints);
				$destination = array_pop($waypoints);
			//	dd($vendor,$origin,$destination,$waypoints);
				//return dd($waypoints,$origin,$destination);
				
				//$origin = "44.8765065,-0.4444849";
				//$destination = "44.8843778,-0.1368667";
				
				/* $waypoints = array(
					"44.8765065,-0.4444849",
					"44.8843778,-0.1368667"
				); */
				
				$map_url = '';
				
				if($origin&&$destination&&$waypoints){
					$map_url = $this->getStaticGmapURLForDirection($origin, $destination, $waypoints);
				}
				
				$html  = '<h1>Trip Map</h1><hr>';
				$html .= '<h4>Trip ID: '.$trip->trip_id.'</h4>';
				if($vendor)
					$html .= '<h4>Pickup Point: '.$vendor->name.'</h4>';
				$html .= $site_html;
				$html .= '<hr><h3>Total Distance: '.array_sum($distance).' km</h3>';
				$html .= '<hr><h3>Mobile App Total Distance: '.array_sum($distance).' km</h3>';
				if($map_url)
					$html .= '<img src="'.$map_url.'" >';
				else
					$html .= 'Map Data Not Found!';

				$mpdf->WriteHTML($html);
				//$mpdf->WriteHTML('<img src="https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x600&maptype=roadmap&key=AIzaSyB_aaYKAvDUt155kQaWXYqx0PUSXk5EEk4&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C20.03891,85.34116&markers=size:mid%7Ccolor:0xff0000%7Clabel:2%7C20.16053,85.29765" >');
				//$mpdf->Output();
				if(Storage::exists(('trip_map').'/'.$trip->trip_id.'-'.$trip->id.'.pdf')) {
					$sd = Storage::delete(('trip_map').'/'.$trip->trip_id.'-'.$trip->id.'.pdf');
				}
				$mpdf->Output(storage_path('app/trip_map').'/'.$trip->trip_id.'-'.$trip->id.'.pdf', 'F');
				return redirect()->route('trip-map-pdf',['action'=>'view_pdf','trip_id'=>$trip->id]);
			}
		}
	}
	public function getSitesLatLng($tripId)
	{
		if($tripId){
			$trip = Trips::find($tripId);
			$vendor = $trip->vendor;
			$data = TripData::leftJoin('site_master',function($q){
				$q->on('site_master.id','=','trip_data.data_id');
			})->where(['trip_data.trip_id'=>$tripId])->where('latitude','<>','0')->where('longitude','<>','0')->select('site_master.latitude as lat','site_master.longitude as lng','site_master.site_id')->get()->toArray();
			if($vendor)
				array_unshift($data,['lat' => $vendor->latitute, 'lng'=>$vendor->longitude, 'site_id'=>$vendor->name]);
			//return dd($data);
			return response()->json(
				$data
			);	
		}
	}
	
	public function getStaticGmapURLForDirection($origin, $destination, $waypoints, $size = "900x680") {
		$markers = array();
		$waypoints_labels = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$waypoints_label_iter = 0;

		$markers[] = "markers=color:green" . urlencode("|") . "label:" . urlencode('|' . $origin);
		foreach($waypoints as $waypoint){
			
			$markers[] = "markers=color:red" . urlencode("|") . "label:" . urlencode($waypoints_labels[$waypoints_label_iter] . '|' . $waypoint);
			$waypoints_label_iter++;
		}
		//$waypoints_label_iter++;
	//	dd($waypoints_label_iter);
		$markers[] = "markers=color:red" . urlencode("|") . "label:" . urlencode($waypoints_labels[$waypoints_label_iter] . '|' . $destination);

		//dd($waypoints);
		$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&key=AIzaSyB_aaYKAvDUt155kQaWXYqx0PUSXk5EEk4&waypoints=" . implode($waypoints, '|');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, false);
		$result = curl_exec($ch);
		curl_close($ch);
		$googleDirection = json_decode($result, true);
		$polyline = urlencode($googleDirection['routes'][0]['overview_polyline']['points']);
		$markers = implode($markers, '&');

		return "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=$size&maptype=roadmap&key=AIzaSyB_aaYKAvDUt155kQaWXYqx0PUSXk5EEk4&path=enc:$polyline&$markers";
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
		$dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
		return str_replace(",",".",$dist);
		dd($dist);
		$time = $response_a['rows'][0]['elements'][0]['duration']['text'];

	}
	public function sendSmsForNewTrip($data='')
	{
		if(isset($data) && !empty($data)){
			$response = '';
			$qty = Helper::getQtyByBeatplanIdAndDataid($data['beatPlanIdForS']);
			$msg = "Hi, Vehicle No - ".$data['vehicale_number']." for Zone - ".$data['zone']." for Route - ".$data['route']." dated - ".$data['effective_date']." allocated for Qty - ".$qty;
			$fillerMobile = Helper::getMoblieByid($data['filler']);
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

	public function sendSmsForStartLoading($data='', $time='')
	{
		if(isset($data) && !empty($data) && is_array($data)){
			$response = '';
			$qty = Helper::getQtyByBeatplanIdAndDataid($data['beatplan_id'], $data['data_id']);
			$fillerMobile = Helper::getMoblieByid($data['trip']['filler_id']);
			$areaOfficerMobile = Helper::getMoblieByid($data['trip']['field_officer_id']);
			$vendorMobile = Helper::getMoblieByVendorId($data['trip']['loading_point_id']);
			$vehicaleNumber = Helper::getVehicleNumberByVehicleId($data['trip']['vehicle_id']);
			$route = Helper::getRouteNameByRouteId($data['trip']['route_id']);
			$zone = Helper::getZoneByBeatplanId($data['trip']['beatplan_id']);
			$msg = "Hi, Vehicle No - ".$vehicaleNumber." for Zone - ".$zone." for Route - ".$route." dated - ".$data['trip']['effective_date']." allocated for Qty - ".$qty." loading started at Time - ".$time;
			if(!empty($fillerMobile)){
				$response .= Cbis::sendSms($fillerMobile,$msg);
			}
			if(!empty($areaOfficerMobile)){
				$response .= Cbis::sendSms($areaOfficerMobile,$msg);
			}
			if(!empty($vendorMobile)){
				$response .= Cbis::sendSms($vendorMobile,$msg);
			}
			if(!empty($data['trip']['client_mobile'])){
				$client_mobile = json_decode($data['client_mobile']);
				foreach ($client_mobile as $value) {
					$response .= Cbis::sendSms($value,$msg);
				}
			}
			return $response;
		}
	}

	public function sendSmsForEndLoading($data='', $time='')
	{
		if(isset($data) && !empty($data) && is_array($data)){
			$response = '';
			$qty = Helper::getQtyByBeatplanIdAndDataid($data['beatplan_id'], $data['data_id']);
			$fillerMobile = Helper::getMoblieByid($data['trip']['filler_id']);
			$areaOfficerMobile = Helper::getMoblieByid($data['trip']['field_officer_id']);
			$vendorMobile = Helper::getMoblieByVendorId($data['trip']['loading_point_id']);
			$vehicaleNumber = Helper::getVehicleNumberByVehicleId($data['trip']['vehicle_id']);
			$route = Helper::getRouteNameByRouteId($data['trip']['route_id']);
			$zone = Helper::getZoneByBeatplanId($data['trip']['beatplan_id']);
			$msg = "Hi, Vehicle No - ".$vehicaleNumber." for Zone - ".$zone." for Route - ".$route." dated - ".$data['trip']['effective_date']." allocated for Qty - ".$qty." loading Finished at Time - ".$time;
			if(!empty($fillerMobile)){
				$response .= Cbis::sendSms($fillerMobile,$msg);
			}
			if(!empty($areaOfficerMobile)){
				$response .= Cbis::sendSms($areaOfficerMobile,$msg);
			}
			if(!empty($vendorMobile)){
				$response .= Cbis::sendSms($vendorMobile,$msg);
			}
			if(!empty($data['trip']['client_mobile'])){
				$client_mobile = json_decode($data['client_mobile']);
				foreach ($client_mobile as $value) {
					$response .= Cbis::sendSms($value,$msg);
				}
			}
			return $response;
		}
	}
	public function shareOnMail(Request $request)
	{
		$data = json_decode($request->postData);
		if (isset($data) && !empty($data)) {
			$zone = Helper::sendEmail($request->emailid, (array)$data, 'emails.share-mail');
			return response()->json([
				'status' => 'ok',
				'message' => 'Email sent!'
			]);
		}else{
			return response()->json([
				'status' => 'ok',
				'message' => 'Email not sent, Content not recieved!'
			]);
		}
		
	}
	public function isExistUniqueTrip(Request $request)
	{
		if($request->ajax())
		{
			if(auth()->user()->type == 'subadmin'){
				$addedBy = array();
				$Ids = $this->getAllMisIdsBySubAdminId(auth()->user()->id);
				foreach ($Ids as $key) {
					array_push($addedBy, $key->id);
				}
				array_push($addedBy, auth()->user()->id);
				if(Trips::where(['trip_id' => $request->tripId])->whereIN('added_by',$addedBy)->exists()){
					return response()->json(['status' => '200', 'message' => true]);
				}else{
					return response()->json(['status' => '200', 'message' => false]);
				}
			}elseif(auth()->user()->type == 'mis'){
				$tripId = $request->tripId;
				$return = Trips::where(['trip_id' => $request->tripId, 'added_by' => auth()->user()->id])->orWhere(function($q) use($tripId){
					$q->where(['trip_id' => $tripId, 'added_by' => auth()->user()->created_by_id]);
				})->exists();
				if ($return) {
					return response()->json(['status' => '200', 'message' => true]);
				}else{
					return response()->json(['status' => '200', 'message' => false]);	
				}
			}
		}
	}
	public function getAllMisIdsBySubAdminId($subadminID){   
		$ids = User::where(['created_by_id' => $subadminID, 'type' => 'mis'])->select('id')->get();
		return $ids;
	}
	public function sendEmailToClients($data)
	{
		$driver = User::find($data['driver'])->name;
		$driverContact = User::find($data['driver'])->contact;

		$fillerContact = User::find($data['filler'])->contact;
		$filler = User::find($data['filler'])->name;

		$mailData['driver'] = $driver.'('.$driverContact.')';
		$mailData['filler'] = $filler.'('.$fillerContact.')';
		$mailData['date'] = $data['current_date'];
		$mailData['plandate'] = $data['effective_date'];
		$mailData['route'] = $data['route'];
		$mailData['zone'] = $data['zone'];
		$mailData['vehicle'] = $data['vehicale_number'];
		$mailData['ro'] = Vendor::find($data['loading_point'])->name;
		$mailData['trip_id'] = $data['trip_id'];

		$mailData['sitesLength'] = count($data['siteArray']);
		$mailData['totalQty'] = 0;
		if (isset($data['beatplandataid']) && !empty($data['beatplandataid'])) {
			foreach ($data['beatplandataid'] as $id) {
				$mailData['totalQty'] += BeatPlanData::find($id)->quantity;		
			}
		}
		if (isset($data['siteid']) && !empty($data['siteid'])) {
			$i = 0;
			foreach ($data['siteid'] as $siteid) {
				$mailData['sites'][] = (object) array('siteId' => Sitemaster::find($siteid)->site_id, 'siteName' => Sitemaster::find($siteid)->site_name, 'techName' => Sitemaster::find($siteid)->technician_name, 'qty' => BeatPlanData::find($data['beatplandataid'][$i])->quantity);
				$i++;
			}
		}
		//dd($mailData);
		if(isset($data['client_email_']) && !empty($data['client_email_'])){
			foreach ($data['client_email_'] as $emailid) {
				$zone = Helper::sendEmail($emailid, $mailData, 'emails.share-mail');
			}
		}
	}

	public function remove(Request $request, $id){
		$trip = Trips::findOrFail($id);
		$msgResp = $this->sendSmsForDeleteTrip($id);	
		if($trip->trip_data){
			foreach($trip->trip_data as $key => $trip_data){
				$bpld = BeatPlanData::where(['site_id' => $trip_data->data_id,'beatplan_id' => $trip_data->beatplan_id])->first();
				$bpld->status = 'pending';
				$bpld->save();
				TripData::where('id', $trip_data->id)->delete();
			}
		}
		$trip->delete();
		return response()->json(['status' => 'success', 'msg' => 'Trip deleted successfully!']);
		return back()->with('success','Trip deleted successfully!');
	}
	public function sendSmsForDeleteTrip($id='')
	{
		$trip = Trips::with(['vechile','filler','officer','route','beat_plan'])->findOrFail($id);
		if(isset($trip) && !empty($trip)){
			$response = '';
			$qty = 0;
			if (isset($trip->trip_qty_sum)) {
				foreach ($trip->trip_qty_sum as $key) {
					$qty += $key->quantity;
				}
			}
			$msg = "Hi, Vehicle No - ".$trip['vechile']['vehicle_no']." for Zone - ".$trip['beat_plan']['mp_zone']." for Route - ".$trip['route']['route_name']." dated - ".$trip['effective_date']." allocated for Qty - ".$qty." has been Cancelled";
			$fillerMobile = $trip['filler']['contact'];
			if(isset($trip['officer']['contact'])){
				$areaOfficerMobile = $trip['officer']['contact'];
				if(!empty($areaOfficerMobile)){
					$response .= Cbis::sendSms($areaOfficerMobile,$msg);
				}
			}
			$vendorMobile = Helper::getMoblieByVendorId($trip['loading_point_id']);
			if(!empty($fillerMobile)){
				$response .= Cbis::sendSms($fillerMobile,$msg);
			}
			if(!empty($vendorMobile)){
				$response .= Cbis::sendSms($vendorMobile,$msg);
			}
			$client_mobile = json_decode($trip['clients_mobile']);
			if(!empty($client_mobile) && is_array($client_mobile)){
				foreach ($client_mobile as $value) {
					$response .= Cbis::sendSms($value,$msg);
				}
			}
			return $response;
		}
	}
	public function sendSmsForUpdateTrip($data='')
	{
		if(isset($data) && !empty($data)){
			$response = '';
			$totalSites = 0;
			$clientMobileJson = Trips::find($data['tripID'])['clients_mobile'];
			if(isset($data['siteid']) && !empty($data['siteid'])){
				foreach($data['siteid'] as $index=>$value) {
					if($value === null) unset($data['siteid'][$index]);
				}
				$totalSites = count($data['siteid']);
			}
			$time = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
			$qty = BeatPlanData::whereIn('id',$data['beatplandataid'])->sum('quantity');
			$msg = "Hi, Vehicle No - ".$data['vehicale_number']." for Zone - ".$data['zone']." for Route - ".$data['route']." dated - ".$data['effective_date']." allocated for Qty - ".$qty." updated at Time - ".$time." with total number of sites is ".$totalSites;
			$fillerMobile = Helper::getMoblieByid($data['filler']);
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
			}elseif (isset($clientMobileJson) && !empty($clientMobileJson)) {
				$client_mobile = json_decode($clientMobileJson);
				if (isset($client_mobile) && !empty($client_mobile)) {
					foreach ($client_mobile as $value) {
						$response .= Cbis::sendSms($value,$msg);
					}	
				}
			}
			return $response;
		}
	}

	public function trips_load(Request $request){
		$trips = Trips::select('id','trip_id as text')->where('id','<>',$request->trip_id)->where('trip_id', 'like', '%' . $request->search . '%')->limit(20)->orderBy('id', 'DESC')->get();
		return response()->json(['results' => $trips ]);
		dd($request->all());
	}
}
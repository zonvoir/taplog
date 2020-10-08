<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\Trips;
use App\Sitemaster;
use App\Beatplan;
use App\TripData;
use App\BeatPlanData;
use App\Verifiedloads;
use App\LoadTransfer;
use App\Divert;
use Illuminate\Support\Facades\DB;

class BackLogController extends Controller
{
	public function index(Request $request){

		if($request->type == "unallocated"){
			$plans 	= Beatplan::select('beatplans.*','beatplans.id as plan_id')->join('beatplan_data', function($join) {
				$join->on('beatplan_data.beatplan_id', '=', 'beatplans.id');
			})->where('beatplans.effective_date', '<', date('d-m-Y'))->where('beatplan_data.status', 'pending')->groupBy('beatplans.id')->paginate(10);
			return view('backlog.unallocated',['plans' => $plans, 'type' => $request->type]);
		}
		if($request->type == "unallocated_data" && $request->beat_id){
			$plan_id = $request->beat_id;
			
			$backlogs 	= BeatPlanData::whereIn('beatplan_id', [$plan_id])->whereIn('status',['pending'])->paginate(10);
			
			// return dd($backlogs);

			return view('backlog.unallocated_data',['backlogs' => $backlogs, 'type' => $request->type]);
		}
		if($request->type == "unloaded"){
			
			$plans 	= Beatplan::select('beatplans.*','beatplans.id as plan_id')->join('trip_data', function($join) {
				$join->on('trip_data.beatplan_id', '=', 'beatplans.id');
			})->where('beatplans.effective_date', '<', date('d-m-Y'))->where('trip_data.status', 'unloaded')->groupBy('beatplans.id')->paginate(10);

			return view('backlog.index',['plans' => $plans, 'type' => $request->type]);
		}
		if($request->type == "unloaded_data" && $request->beat_id){
			$backlogs	= Trips::where('beatplan_id', $request->beat_id)
			->pluck('id')->toArray();
			$backlogs 	= TripData::whereIn('trip_id', $backlogs)->whereIn('status',['unloaded'])->paginate(10);
			//return dd($backlogs);
			
			$trips	    = Trips::where('effective_date', '>=', date('d-m-Y'))->get();
			return view('backlog.index_data',['backlogs' => $backlogs, 'type' => $request->type, 'trips' => $trips]);
		}
		if($request->type == "not_filled"){
			$plans 	= Beatplan::select('beatplans.*','beatplans.id as plan_id')->join('trip_data', function($join) {
				$join->on('trip_data.beatplan_id', '=', 'beatplans.id');
			})->where('beatplans.effective_date', '<', date('d-m-Y'))->where('trip_data.status', 'loaded')->groupBy('beatplans.id')->paginate(10);
			return view('backlog.not_filled',['plans' => $plans]);
		}
		
		if($request->type == "not_filled_data" && $request->beat_id){
			$backlogs	= Trips::where('beatplan_id', $request->beat_id)
			->pluck('id')->toArray();
			$backlogs 	= TripData::whereIn('trip_id', $backlogs)->whereIn('status',['loaded'])->paginate(10);
			//return dd($backlogs);
			
			$trips	    = Trips::where('effective_date', '>=', date('d-m-Y'))->get();
			return view('backlog.not_filled_data',['backlogs' => $backlogs, 'type' => $request->type, 'trips' => $trips]);
		}

		// return dd($trips);
	}

	public function assign_trip(Request $request){
// //	$query = vsprintf(str_replace(array('?'), array('\'%s\''), $backlogs->toSql()), $backlogs->getBindings());
		/*$verified = Verifiedloads::find($request->verified_id);
	 //return dd($verified);
		$verified->assigned_to_trip_id  = $request->assign_to_trip_id;
		$verified->status 				= 'assigned';
		$verified->save();*/

		$trip_data1					= TripData::find($request->backlog_id);	 

		// return dd($trip_data);
		
		$trip_data              	= new TripData;
		$trip_data->trip_id     	= $request->assign_to_trip_id;
		$trip_data->data_id     	= $trip_data1->data_id; // site_id
		$trip_data->beatplan_id 	= $trip_data1->beatplan_id;
		$trip_data->trip_data_id 	= $trip_data1->id;
		$trip_data->status 			= 'assigned';
		$trip_data->save();

		return response()->json('assigned');
	}

	public function load_transfer(Request $request){
		$verified = Verifiedloads::findOrFail($request->verified_id);
		$load_transfer = LoadTransfer::firstOrNew(['verified_id' => $request->verified_id]);
		$load_transfer->verified_id  = $request->verified_id;
		$load_transfer->beatplan_id  = $verified->beatplan_id;
		$load_transfer->site_id 	 = $verified->sites;
		$load_transfer->trip_id 	 = $verified->auto_trip_id;
		$load_transfer->trip_data_id = $verified->trip_data_id;
		$load_transfer->driver_id 	 = $request->driver_id;
		$load_transfer->filler_id 	 = $request->filler_id;
		$load_transfer->vehicle_id 	 = $request->vehicle_id;
		//return dd($load_transfer);
		$load_transfer->save();
		$verified->status = 'transferred';
		$verified->transfer_id = $load_transfer->id;
		$verified->save();
		return response()->json('transferred');
	}

	public function not_delivered(Request $request){
		$beat_plan = Beatplan::findOrFail($request->beat_id);
		return view('backlog.not_delivered', compact('beat_plan'));
	}

	public function trip_data(Request $request){
		// $beat_plan = Beatplan::findOrFail($request->beat_id);
		// return view('backlog.not_delivered', compact('beat_plan'));
		return view('v3.backlog.not-delivered-datatable');
	}

	public function save_divert(Request $request){

		//return dd($request->all());
		foreach ($request->from_site as $key => $from_site) {
			# code...
			$from_site_id 			 = $request->from_site[$key];
			$verified 				 = Verifiedloads::find($request->verified_id);
			$beatplan_data 			 = BeatPlanData::find($verified->trip_data->beat_plan_data()->id);
			$beatplan_data->quantity = $beatplan_data->quantity - $request->qty[$key];
			$beatplan_data->status 	 = 'diverted';
			$beatplan_data->save();
			
			
			$beat_plan_data 			 = new BeatPlanData;
			$beat_plan_data->beatplan_id = $verified->beatplan_id;
			$beat_plan_data->site_id     = $request->to_site[$key];
			$beat_plan_data->quantity    = $request->qty[$key];
			$beat_plan_data->status      = 'allocated';
			$beat_plan_data->diverted_from  = $request->from_site[$key];
			$beat_plan_data->save();
			
			$beat_plan_data 			 = new TripData;
			$beat_plan_data->trip_id 	 = $verified->auto_trip_id;
			$beat_plan_data->data_id     = $request->to_site[$key];
			$beat_plan_data->beatplan_id = $verified->beatplan_id;
			$beat_plan_data->status      = 'loaded';
			$beat_plan_data->divert_qty  = $request->qty[$key];
			$beat_plan_data->divert_from_qty  = $request->qty[$key];
			//$beat_plan_data->divert_to_qty  = $request->qty[$key];
			$beat_plan_data->divert_from_tripdata_id  = $verified->trip_data_id;
			$beat_plan_data->save();
			
			$tripdata 			 		 = TripData::find($verified->trip_data_id);
			$tripdata->divert_to_tripdata_id  = $beat_plan_data->id;
			$tripdata->divert_qty  = $request->qty[$key];
			//$tripdata->divert_from_qty  = $request->qty[$key];
			$tripdata->divert_to_qty  = $request->qty[$key];
			$tripdata->save();
			
			$trip 						= Trips::find($verified->auto_trip_id);
			
			$verified1 				 	= new Verifiedloads;
			$verified1->beatplan_id 	= $verified->beatplan_id;
			$verified1->trip_data_id	= $beat_plan_data->id;
			$verified1->trip_id			= $trip->trip_id;
			$verified1->auto_trip_id	= $trip->id;
			$verified1->sites			= $request->to_site[$key];
			$verified1->verified_by_id	= $verified->verified_by_id;
			$verified1->diverted		= 1;
			$verified1->status			= 'loaded';
			$verified1->save();
			
			$divert = Divert::firstOrNew(['verified_id' => $request->verified_id, 'from_site_id' => $from_site_id]);
			$divert->verified_id 	= $request->verified_id;
			$divert->from_site_id 	= $request->from_site[$key];
			$divert->to_site_id 	= $request->to_site[$key];
			$divert->qty 			= $request->qty[$key];
			$divert->trip_id		= $verified1->auto_trip_id;
			$divert->from_tripdata_id	= $tripdata->id;
			$divert->to_tripdata_id		= $beat_plan_data->id;
			$divert->beatplan_id		= $verified1->beatplan_id;
			$divert->save();


		}
		$verified = Verifiedloads::find($request->verified_id);
		$verified->diverted = 1;
		$verified->save();
		return response()->json('diverted');
	}

	public function update_load(Request $request){

		$beatplan_data = BeatPlanData::findOrFail($request->beatplan_data_id);
		
		$beatplan_data->quantity = $request->newLoad;
		$beatplan_data->save();
		return response()->json('loaded');

	}

	public function update_status(Request $request){

		$verified = Verifiedloads::find($request->row_id);
		$verified->status = $request->status;
		$verified->save();

		$trip_data = TripData::find($request->trip_data_id);
		$trip_data->status = $request->status;
		$trip_data->save();
		return response()->json('updated');
	}
	
	public function update_remark(Request $request){
		if($request->has('beatplandata_id') && $request->has('remarks')){
			$beatplan_data = BeatPlanData::findOrFail($request->beatplandata_id);
			$beatplan_data->remarks = $request->remarks;
			$beatplan_data->save();
			return response()->json('updated');
		}
		return response()->json('failed');
	}
	public function trip_data_datatable(Request $request)
	{
		$columnsDefault = [
			'trip_id'     => true,
			'site_id'      => true,
			'site_name'      => true,
			'site_category'     => true,
			'technician_name'  => true,
			'technician_contact'  => true,
			'quantity'  => true,
			'status'  => true,
			'loading_start'  => true,
			'loading_finish'  => true,
			'filling_finish'  => true,
			'site_in'  => true,
			'site_out'  => true,
			'vehicle_no'  => true,
			'driver_name'  => true,
			'driver_contact'  => true,
			'filler_name'  => true,
			'filler_contact'  => true,
			'remark'  => true,
		];
		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = true;
			}
		}
    		// get all raw data
		$returndata = Beatplan::findOrFail($request->beat_id);
		$alldata = array();
		if(isset($returndata) && !empty($returndata) && isset($returndata->beatplan_data)){
			$i = 0;
			foreach($returndata->beatplan_data as $key => $beatplan_data)
				if($beatplan_data->trip_data()){
					$alldata[$i]['trip_id'] = $beat_plan->uniqueTrip($beatplan_data->beatplan_id, $beatplan_data->site_id);
				}
				$alldata[$i]['site_id'] = $beatplan_data->site->site_id;
				$alldata[$i]['site_name'] = $beatplan_data->site->site_name;
				$alldata[$i]['site_category'] = $beatplan_data->site->site_category;
				$alldata[$i]['technician_name'] = $beatplan_data->site->technician_name;
				$alldata[$i]['technician_contact'] = $beatplan_data->site->technician_contact1;
				$alldata[$i]['quantity'] = $beatplan_data->quantity;
				if($beatplan_data->trip_data()){
					$alldata[$i]['status'] = $beatplan_data->status;
				}
				$alldata[$i]['quantity'] = $beatplan_data->quantity;
				$alldata[$i]['quantity'] = $beatplan_data->quantity;
				$alldata[$i]['quantity'] = $beatplan_data->quantity;
				$alldata[$i]['quantity'] = $beatplan_data->quantity;
				$alldata[$i]['quantity'] = $beatplan_data->quantity;
				$status = $plan->beatplan_data->count('site_id')??0;
				$status .= ' Sites';
				if($plan->loaded_count()){
					$status .= '/Loading Done('.$plan->loaded_count().')';
				}
				if($plan->filled_count()) {
					$status .= '/Filling Done('.$plan->filled_count().')'; 
				}
				$alldata[$i]['cstatus'] = $status;
				$alldata[$i]['action'] = null;
				$i++;
			}
		$data = [];
    // internal use; filter selected columns only from raw data
		foreach ( $alldata as $d ) {
			$data[] = Helper::filterArray( $d, $columnsDefault );
		}

    // count data
		$totalRecords = $totalDisplay = count( $data );

    // filter by general search keyword
		if ( isset( $_REQUEST['search'] ) ) {
			$data         = Helper::filterKeyword( $data, $_REQUEST['search'] );
			$totalDisplay = count( $data );
		}

		if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
			foreach ( $_REQUEST['columns'] as $column ) {
				if ( isset( $column['search'] ) ) {
					$data         = Helper::filterKeyword( $data, $column['search'], $column['data'] );
					$totalDisplay = count( $data );
				}
			}
		}

    // sort
		if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
			$column = $_REQUEST['order'][0]['column'];
			$dir    = $_REQUEST['order'][0]['dir'];
			usort( $data, function ( $a, $b ) use ( $column, $dir ) {
				$a = array_slice( $a, $column, 1 );
				$b = array_slice( $b, $column, 1 );
				$a = array_pop( $a );
				$b = array_pop( $b );

				if ( $dir === 'desc' ) {
					return $a > $b ? true : false;
				}

				return $a < $b ? true : false;
			} );
		}

    // pagination length
		if ( isset( $_REQUEST['length'] ) ) {
			$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
		}

    // return array values only without the keys
		if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
			$tmp  = $data;
			$data = [];
			foreach ( $tmp as $d ) {
				$data[] = array_values( $d );
			}
		}

		$secho = 0;
		if ( isset( $_REQUEST['sEcho'] ) ) {
			$secho = intval( $_REQUEST['sEcho'] );
		}

		$result = [
			'iTotalRecords'        => $totalRecords,
			'iTotalDisplayRecords' => $totalDisplay,
			'sEcho'                => $secho,
			'aaData'               => $data,
		];
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
		return json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	}
}
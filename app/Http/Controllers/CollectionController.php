<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collection;
use App\Beatplans;
use App\User;
use App\TripData;
use App\Verifiedloads;
use App\Misallottedzones;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class CollectionController extends Controller
{
	public function collections()
	{
		// $collections = Collection::rightjoin('verified_loads', function($join){
		// 	$join->on('verified_loads.id','=','collection.verified_load_id');	
		// })->paginate(10);
		return view('collection.collections');
	}
	public function createCollection($verified_loads_id = '')
	{
		$loads = Verifiedloads::find($verified_loads_id);
		//dd($loads->trip_data->loading_start);
		return view('pages.create_collection',compact('verified_loads_id','loads'));
	}
	public function serversideCollection(Request $request){
		//dd($request->all());
		DB::connection()->enableQueryLog();
		$orderby = $request->input('order.0.column');
		$sort['col'] = $request->input('columns.' . $orderby . '.data');    
		$sort['dir'] = $request->input('order.0.dir');
		$query = Collection::rightjoin('verified_loads', function($join){
			$join->on('verified_loads.id','=','collection.verified_load_id');	
		})
		->leftjoin('trips', function($join){
			$join->on('verified_loads.auto_trip_id','=','trips.id');	
		})
		->leftjoin('trip_data', function($join){
			$join->on('trip_data.id','=','verified_loads.trip_data_id');	
		})
		->leftjoin('diverts', function($join){
			$join->on('diverts.verified_id','=','verified_loads.id');	
		})
		->leftjoin('site_master as divertedToSiteId', function($join){
			$join->on('divertedToSiteId.id','=','diverts.to_site_id');	
		})
		->leftjoin('site_master as divertedFromSiteId', function($join){
			$join->on('divertedFromSiteId.id','=','diverts.from_site_id');	
		})
		->leftjoin('beatplans', function($join){
			$join->on('verified_loads.beatplan_id','=','beatplans.id');	
		})
		->leftjoin('beatplan_data', function($join){
			$join->on('beatplan_data.beatplan_id','=','beatplans.id')
			->on('beatplan_data.site_id', '=', 'verified_loads.sites');
		})
		->leftjoin('site_master', function($join){
			$join->on('site_master.id','=','verified_loads.sites');	
		})
		->leftjoin('routes', function($join){
			$join->on('routes.id','=','trips.route_id');	
		})
		->leftjoin('users as filler', function($join){
			$join->on('filler.id','=','trips.filler_id');	
		})
		->leftjoin('users as driver', function($join){
			$join->on('driver.id','=','trips.driver_id');	
		})
		->leftjoin('users as fieldofficer', function($join){
			$join->on('fieldofficer.id','=','trips.field_officer_id');	
		})
		->leftjoin('vehicle_master', function($join){
			$join->on('vehicle_master.id','=','trips.vehicle_id');	
		})
		->leftjoin('vendors', function($join){
			$join->on('vendors.id','=','trips.loading_point_id');	
		});
		$query->where('verified_loads.status','!=','unloaded');
		if(auth()->user()->type == 'filler'){
			$query->where('trips.filler_id','=',auth()->user()->id);
		}
		if(auth()->user()->type == 'driver'){
			$query->where('trips.driver_id','=',auth()->user()->id);
		}
		if(auth()->user()->type == 'subadmin'){
			$user['fillers'] = User::where(['created_by_id'=>auth()->user()->id, 'type' => 'filler'])->pluck('id');
			$user['drivers'] = User::where(['created_by_id'=>auth()->user()->id, 'type' => 'driver'])->pluck('id');
			$query->where(function($q) use($user){
				$q->whereIn('trips.filler_id',$user['fillers'])->orWhereIn('trips.driver_id',$user['drivers']);
			});
		}
		if(auth()->user()->type == 'mis'){
			// $user['fillers'] = User::where(['created_by_id'=>auth()->user()->created_by_id, 'type' => 'filler'])->pluck('id');
			// $user['drivers'] = User::where(['created_by_id'=>auth()->user()->created_by_id, 'type' => 'driver'])->pluck('id');
			// $query->whereIn('trips.filler_id',$user['fillers'])->orWhereIn('trips.driver_id',$user['drivers']);
			$allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
			if (isset($allotedData) && !empty($allotedData)) {
				$query->where(function($q) use($allotedData){
					$i = 1;
					foreach ($allotedData as $key) {
						if ($i == 1) {
							$q->where(['beatplans.mp_zone' => $key->zone, 'beatplans.client_id' => $key->client]);		
						}
						else{
							$q->orWhere(['beatplans.mp_zone' => $key->zone, 'beatplans.client_id' => $key->client]);		
						}
						$i++;
					}
				});
				//
			}
		}
		$query->select('site_master.site_id','site_master.site_name','site_master.site_category','site_master.mp_zone','site_master.technician_name','site_master.technician_contact1','site_master.latitude','site_master.longitude','routes.route_name','driver.name as driver_name','driver.contact as driver_mobile','filler.name as filler_name','filler.contact as filler_mobile','vehicle_master.vehicle_no','beatplan_data.quantity','beatplans.effective_date','trip_data.handbook_img','collection.*','verified_loads.id','verified_loads.auto_trip_id','verified_loads.sites','vendors.name as loadingPointName','trip_data.loading_start','trip_data.loading_finish','trip_data.site_in','trip_data.site_out','divertedFromSiteId.site_id as diverFromSiteid','divertedToSiteId.site_id as divertTositeid','diverts.qty as divert_qty','diverts.from_site_id','diverts.to_site_id');
		if(!empty($request->input('search.value'))){
			$query->where('site_master.site_id', 'like', '%'. $request->input('search.value') .'%')
			->orWhere('beatplans.effective_date', 'like', '%'. $request->input('search.value') .'%');
		}
		if(!empty($request->input('startdate')) && !empty($request->input('enddate'))){
			$query->whereBetween('beatplans.effective_date',[$request->input('startdate'), $request->input('enddate')]);
		}
		$output['draw'] = intval($request->input('draw'));
		$output['recordsTotal'] = $query->count();
		$output['recordsFiltered'] = $output['recordsTotal'];
		$beatPlanCols = ['effective_date'];
		$orderingTable = in_array($sort['col'], $beatPlanCols) ? 'beatplans' : 'collection';
		$start = $request->input('start');
		$limit = $request->input('length');
		$output['data'] = $query
		->orderBy($orderingTable.'.'.$sort['col'], $sort['dir'])
		->when(($limit != '-1'), function ($query, $start) {
			return $query->skip($start);
		})
		//->take($request->input('length',10))
		//->get();
		->offset($start)->limit($limit)->get();
		$queries = DB::getQueryLog();
		$output['last_query'] = end($queries);
		return json_encode($output);
	}

	public function createCollectionAction(Request $request)
	{
		if($request->has("verified_loads_id")){
			if($request->hasFile('kwh_reading_img')){
				$kwh_reading_img = $this->imageUpload($request,'kwh_reading_img');
			}if($request->hasFile('hmr_reading_img')){
				$hmr_reading_img = $this->imageUpload($request,'hmr_reading_img');
			}if($request->hasFile('gcu_bef_fill_img')){
				$gcu_bef_fill_img = $this->imageUpload($request,'gcu_bef_fill_img');
			}if($request->hasFile('gcu_aft_fill_img')){
				$gcu_aft_fill_img = $this->imageUpload($request,'gcu_aft_fill_img');
			}if($request->hasFile('fuel_guage_bef_fill_img')){
				$fuel_guage_bef_fill_img = $this->imageUpload($request,'fuel_guage_bef_fill_img');
			}if($request->hasFile('fuel_guage_aft_fill_img')){
				$fuel_guage_aft_fill_img = $this->imageUpload($request,'fuel_guage_aft_fill_img');
			}if($request->hasFile('dip_stick_bef_fill_img')){
				$dip_stick_bef_fill_img = $this->imageUpload($request,'dip_stick_bef_fill_img');
			}if($request->hasFile('dip_stick_aft_fill_img')){
				$dip_stick_aft_fill_img = $this->imageUpload($request,'dip_stick_aft_fill_img');
			}if($request->hasFile('eb_meter_reading_img')){
				$eb_meter_reading_img = $this->imageUpload($request,'eb_meter_reading_img');
			}
			$post_array = [
				'verified_load_id'=> $request->verified_loads_id, 
				'lefting_date'=> \Carbon\Carbon::parse($request->lifting_start)->format('d-m-Y'), 
				'selling_date'=> \Carbon\Carbon::parse($request->filling_finish)->format('d-m-Y'),
				'kwh_reading'=> $request->kwh_reading,
				'kwh_reading_img'=> $kwh_reading_img ?? null,
				'hmr_reading'=> $request->hmr_reading,
				'hmr_reading_img'=> $hmr_reading_img ?? null,
				'gcu_bef_fill_img'=> $gcu_bef_fill_img ?? null,
				'fuel_stock_bef_fill'=> $request->fuel_stock_bef_fill,
				'gcu_aft_fill_img'=> $gcu_aft_fill_img ?? null,
				'fuel_stock_aft_fill'=> $request->fuel_stock_aft_fill,
				'fuel_guage_bef_fill_img'=> $fuel_guage_bef_fill_img ?? null,
				'fuel_guage_aft_fill_img'=> $fuel_guage_aft_fill_img ?? null,
				'dip_stick_bef_fill_img'=> $dip_stick_bef_fill_img ?? null,
				'dip_stick_aft_fill_img'=> $dip_stick_aft_fill_img ?? null,
				'eb_meter_reading'=> $request->eb_meter_reading,
				'eb_meter_reading_img'=> $eb_meter_reading_img ?? null,
				'filling_qty' => $request->filling_qty,
				'filling_date' => $request->filling_date,
				'remark' => $request->remark ?? null
			];
			if(Collection::create($post_array)){
				$verified = Verifiedloads::find($post_array['verified_load_id']);
				$verified->status = 'filled';
				if($verified->save()){
					$tripDataId = Verifiedloads::find($post_array['verified_load_id'])->trip_data_id;
					$tripData = TripData::find($tripDataId);
					$tripData->site_in = \Carbon\Carbon::parse($request->site_in)->format('Y-m-d H:i:s');
					$tripData->site_out = \Carbon\Carbon::parse($request->site_out)->format('Y-m-d H:i:s');
					$tripData->filling_start = \Carbon\Carbon::parse($request->filling_start)->format('Y-m-d H:i:s');
					$tripData->filling_finish = \Carbon\Carbon::parse($request->filling_finish)->format('Y-m-d H:i:s');
					$tripData->status = 'filled';
					$tripData->save();
					// message api
					$trip_arr = TripData::with('trip','trip.route','trip.vechile','trip.beat_plan','trip.vendor','site')->find($tripDataId)->toArray();
					$trip_arr['qty'] = Helper::getQtyByBeatplanIdAndDataid($trip_arr['beatplan_id'],$trip_arr['data_id']);
					$time = \Carbon\Carbon::now('Asia/Calcutta')->format('H:i:s');
					$response = $this->sendSmsForSiteOut($trip_arr, $time);
				}
				return redirect('collections')->with('success', 'Date inserted successfully!');
			}
		}else{
			return redirect('collections')->with('success', 'Wrong data selected!');
		}
	}
	public function imageUpload($request,$attrname)
	{
		$request->validate([
			$attrname => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$imageName = time().$attrname.'.'.$request->$attrname->extension();  
		$request->$attrname->move(public_path('images'), $imageName);

		return $imageName;

	}
	public function editCollection($id='')
	{
		$collection = Collection::where('verified_load_id','=', $id)->first();
		return view('pages.edit-collection',compact('collection'));
	}
	public function editCollectionAction(Request $request)
	{
		$collection = Collection::find($request->id);

		if($request->hasFile('kwh_reading_img')){
			$collection->kwh_reading_img = $this->imageUpload($request,'kwh_reading_img');
		}if($request->hasFile('hmr_reading_img')){
			$collection->hmr_reading_img = $this->imageUpload($request,'hmr_reading_img');
		}if($request->hasFile('gcu_bef_fill_img')){
			$collection->gcu_bef_fill_img = $this->imageUpload($request,'gcu_bef_fill_img');
		}if($request->hasFile('gcu_aft_fill_img')){
			$collection->gcu_aft_fill_img = $this->imageUpload($request,'gcu_aft_fill_img');
		}if($request->hasFile('fuel_guage_bef_fill_img')){
			$collection->fuel_guage_bef_fill_img = $this->imageUpload($request,'fuel_guage_bef_fill_img');
		}if($request->hasFile('fuel_guage_aft_fill_img')){
			$collection->fuel_guage_aft_fill_img = $this->imageUpload($request,'fuel_guage_aft_fill_img');
		}if($request->hasFile('dip_stick_bef_fill_img')){
			$collection->dip_stick_bef_fill_img = $this->imageUpload($request,'dip_stick_bef_fill_img');
		}if($request->hasFile('dip_stick_aft_fill_img')){
			$collection->dip_stick_aft_fill_img = $this->imageUpload($request,'dip_stick_aft_fill_img');
		}if($request->hasFile('eb_meter_reading_img')){
			$collection->eb_meter_reading_img = $this->imageUpload($request,'eb_meter_reading_img');
		}
		$collection->verified_load_id = $request->verified_load_id;
		$collection->lefting_date = \Carbon\Carbon::parse($request->lifting_start)->format('d-m-Y');
		$collection->selling_date = \Carbon\Carbon::parse($request->filling_finish)->format('d-m-Y');
		$collection->kwh_reading = $request->kwh_reading;
		$collection->hmr_reading = $request->hmr_reading;
		$collection->fuel_stock_bef_fill = $request->fuel_stock_bef_fill;
		$collection->fuel_stock_aft_fill = $request->fuel_stock_aft_fill;
		$collection->eb_meter_reading = $request->eb_meter_reading;
		$collection->filling_qty  = $request->filling_qty;
		$collection->filling_date  = $request->filling_date;
		$collection->remark  = $request->remark;
		if($collection->save()){
			$tripData = TripData::find(Verifiedloads::find($request->verified_load_id)['trip_data_id']);
			$tripData->loading_start = \Carbon\Carbon::parse($request->lifting_start)->format('Y-m-d H:i:s');
			$tripData->loading_finish = \Carbon\Carbon::parse($request->lifting_end)->format('Y-m-d H:i:s');
			$tripData->site_in = \Carbon\Carbon::parse($request->site_in)->format('Y-m-d H:i:s');
			$tripData->site_out = \Carbon\Carbon::parse($request->site_out)->format('Y-m-d H:i:s');
			$tripData->filling_start = \Carbon\Carbon::parse($request->filling_start)->format('Y-m-d H:i:s');
			$tripData->filling_finish = \Carbon\Carbon::parse($request->filling_finish)->format('Y-m-d H:i:s');
			$tripData->save();
		}
		return back()->with('success','Date updated successfully!');
	}
	public function validatePreviousReading(Request $request)
	{
		$field_name = $request->field_name;
		$input_value =$request->input_value;
		$site_id = $request->site_id;
		$plan_id = $request->plan_id;
		$query = Collections::rightjoin('beat_plans', function($join){
			$join->on('beat_plans.id','=','collections.beat_plans_id');	
		});
		$output = $query->where([
			'beat_plans.site_id'=>$site_id,
		])->where('beat_plans.id','<',$plan_id)
		->orderby('collections.id','DESC')->first();
		if(isset($output) && !empty($output)){
			if($output->{$field_name} > $input_value){
				return response()->json([
					'result' => 0,
					'message' =>'Your value is lesser than previous value'
				]);
			}else{
				return response()->json([
					'result' => 1,
					'message' => 'Your value is greater than previous value'
				]);
			}
		}else{
			return response()->json([
				'result' => 1,
				'message' => 'Your value is greater than previous value'
			]);
		}
	}
	public function sendSmsForSiteOut($data='',$time='')
	{
		if(isset($data) && !empty($data)){
			$response = '';
			$qty = $data['qty'];
			$msg = "Hi, Vehicle No - ".$data['trip']['vechile']['vehicle_no']." for Trip Id - ".$data['trip']['trip_id']." left the Site - ".$data['site']['site_name']." after filling Qty - ".$qty." at Time - ".$time;
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
				if(isset($client_mobile) && !empty($client_mobile)){
					foreach ($client_mobile as $value) {
						$response .= Cbis::sendSms($value,$msg);
					}
				}
			}
			return $response;
		}
	}

}

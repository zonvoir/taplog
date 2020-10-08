<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Collection;
use App\User;
use App\Verifiedloads;
use App\TripData;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Cbis;
use App\Helpers\Helper;

class CollectionController extends Controller
{
	public function allCollections(Request $reuest)
	{
		$query = Collection::rightjoin('verified_loads', function($join){
			$join->on('verified_loads.id','=','collection.verified_load_id');	
		})
		->leftjoin('trips', function($join){
			$join->on('verified_loads.auto_trip_id','=','trips.id');	
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
		$data = $query->get();
		return response()->json([
			'status' => 'Ok',
			'message' => 'All collection!!',
			'details' => $data
		]);
	}
	public function createCollection_old(Request $request)
	{
		if($request->has('verified_load_id')){
			if($request->hasFile('kwh_reading_img')){
				$kwh_reading_img = $this->imageUpload($request,'kwh_reading_img');
			}else{
				$kwh_reading_img = $request->kwh_reading_img;
			}if($request->hasFile('hmr_reading_img')){
				$hmr_reading_img = $this->imageUpload($request,'hmr_reading_img');
			}else{
				$hmr_reading_img = $request->hmr_reading_img;
			}if($request->hasFile('gcu_bef_fill_img')){
				$gcu_bef_fill_img = $this->imageUpload($request,'gcu_bef_fill_img');
			}else{
				$gcu_bef_fill_img = $request->gcu_bef_fill_img;
			}if($request->hasFile('gcu_aft_fill_img')){
				$gcu_aft_fill_img = $this->imageUpload($request,'gcu_aft_fill_img');
			}else{
				$gcu_aft_fill_img = $request->gcu_aft_fill_img;
			}if($request->hasFile('fuel_guage_bef_fill_img')){
				$fuel_guage_bef_fill_img = $this->imageUpload($request,'fuel_guage_bef_fill_img');
			}else{
				$fuel_guage_bef_fill_img = $request->fuel_guage_bef_fill_img;
			}if($request->hasFile('fuel_guage_aft_fill_img')){
				$fuel_guage_aft_fill_img = $this->imageUpload($request,'fuel_guage_aft_fill_img');
			}else{
				$fuel_guage_aft_fill_img = $request->fuel_guage_aft_fill_img;
			}if($request->hasFile('dip_stick_bef_fill_img')){
				$dip_stick_bef_fill_img = $this->imageUpload($request,'dip_stick_bef_fill_img');
			}else{
				$dip_stick_bef_fill_img = $request->dip_stick_bef_fill_img;
			}if($request->hasFile('dip_stick_aft_fill_img')){
				$dip_stick_aft_fill_img = $this->imageUpload($request,'dip_stick_aft_fill_img');
			}else{
				$dip_stick_aft_fill_img = $request->dip_stick_aft_fill_img;
			}if($request->hasFile('eb_meter_reading_img')){
				$eb_meter_reading_img = $this->imageUpload($request,'eb_meter_reading_img');
			}else{
				$eb_meter_reading_img = $request->eb_meter_reading_img;
			}
			$post_array = [
				'verified_load_id'=> $request->verified_load_id, 
				'lefting_date'=> $request->lefting_date, 
				'selling_date'=> $request->selling_date,
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
				$tripDataId = Verifiedloads::find($post_array['verified_load_id'])->trip_data_id;
				$tripData = TripData::find($tripDataId);
				$tripData->status = 'filled';
				$TripData->filling_finish = \Carbon\Carbon::now('Asia/Calcutta')->format('Y-m-d H:i:s');
				$TripData->site_out = \Carbon\Carbon::now('Asia/Calcutta')->format('Y-m-d H:i:s');
				$tripData->save();
				// message api
				$trip_arr = TripData::with('trip','trip.route','trip.vechile','trip.beat_plan','trip.vendor','site')->find($tripDataId)->toArray();
				$trip_arr['qty'] = Helper::getQtyByBeatplanIdAndDataid($trip_arr['beatplan_id'],$trip_arr['data_id']);
				$time = \Carbon\Carbon::now('Asia/Calcutta')->format('H:i:s');
				$response = $this->sendSmsForSiteOut($trip_arr, $time);
				return response()->json([
					'status' => 'Ok',
					'message' => 'Data inserted!',
				]);
			}else{
				return response()->json([
					'status' => 'Not Ok',
					'message' => 'Data does not inserted!',
				]);
			}	
		}else{
			return response()->json([
				'status' => 'Not Ok',
				'message' => 'Valid Parameter not found!',
			]);
		}
		
	}
	
	public function createCollection(Request $request){
		if($request->has('verified_load_id')){
			$verified_load = Verifiedloads::find($request->verified_load_id);
			
			if(!$verified_load){
				return response()->json([
					'status' => 'fail',
					'message' => 'Data Not Found!',
				], 404);
			}
			$collection = Collection::firstOrNew(['verified_load_id' => $request->verified_load_id]);
			
			if($request->has('kwh_reading') || $request->hasFile('kwh_reading_img')){
				if($request->hasFile('kwh_reading_img')){
					$kwh_reading_img = $this->imageUpload($request,'kwh_reading_img');
					$collection->kwh_reading_img = $kwh_reading_img;
				}
				
				if($request->kwh_reading){
					$collection->kwh_reading = $request->kwh_reading;
				}
			}
			
			if($request->has('hmr_reading') || $request->hasFile('hmr_reading_img')){
				if($request->hasFile('hmr_reading_img')){
					$hmr_reading_img = $this->imageUpload($request,'hmr_reading_img');
					$collection->hmr_reading_img = $hmr_reading_img;
				}
				
				if($request->hmr_reading){
					$collection->hmr_reading = $request->hmr_reading;
				}
			}
			
			if($request->has('eb_meter_reading') || $request->hasFile('eb_meter_reading_img')){
				if($request->hasFile('eb_meter_reading_img')){
					$eb_meter_reading_img = $this->imageUpload($request,'eb_meter_reading_img');
					$collection->eb_meter_reading_img = $eb_meter_reading_img;
				}
				
				if($request->eb_meter_reading){
					$collection->eb_meter_reading = $request->eb_meter_reading;
				}
			}
			
			if($request->hasFile('gcu_bef_fill_img')){
				if($request->hasFile('gcu_bef_fill_img')){
					$gcu_bef_fill_img = $this->imageUpload($request,'gcu_bef_fill_img');
					$collection->gcu_bef_fill_img = $gcu_bef_fill_img;
				}
			}
			
			if($request->hasFile('gcu_aft_fill_img')){
				if($request->hasFile('gcu_aft_fill_img')){
					$gcu_aft_fill_img = $this->imageUpload($request,'gcu_aft_fill_img');
					$collection->gcu_aft_fill_img = $gcu_aft_fill_img;
				}
			}
			
			if($request->hasFile('fuel_guage_bef_fill_img')){
				$fuel_guage_bef_fill_img = $this->imageUpload($request,'fuel_guage_bef_fill_img');
				$collection->fuel_guage_bef_fill_img = $fuel_guage_bef_fill_img;
			}
			
			if($request->hasFile('fuel_guage_aft_fill_img')){
				$fuel_guage_aft_fill_img = $this->imageUpload($request,'fuel_guage_aft_fill_img');
				$collection->fuel_guage_aft_fill_img = $fuel_guage_aft_fill_img;
			}
			
			if($request->hasFile('dip_stick_bef_fill_img')){
				$dip_stick_bef_fill_img = $this->imageUpload($request,'dip_stick_bef_fill_img');
				$collection->dip_stick_bef_fill_img = $dip_stick_bef_fill_img;
			}
			
			if($request->hasFile('dip_stick_aft_fill_img')){
				$dip_stick_aft_fill_img = $this->imageUpload($request,'dip_stick_aft_fill_img');
				$collection->dip_stick_aft_fill_img = $dip_stick_aft_fill_img;
			}
			
			if($request->hasFile('fuel_stock_bef_fill')){
				$fuel_stock_bef_fill = $this->imageUpload($request,'fuel_stock_bef_fill');
				$collection->fuel_stock_bef_fill = $fuel_stock_bef_fill;
			}
			
			if($request->hasFile('fuel_stock_aft_fill')){
				$fuel_stock_aft_fill = $this->imageUpload($request,'fuel_stock_aft_fill');
				$collection->fuel_stock_aft_fill = $fuel_stock_aft_fill;
			}
			
			if($request->filling_qty){
				$collection->filling_qty = $request->filling_qty;
			}
			
			if($request->filling_date){
				$collection->filling_date = $request->filling_date;
			}
			
			if($request->remark){
				$collection->remark = $request->remark;
			}
			
			$collection->save();
			
			$this->saveSingleCollection($request);
			
			return response()->json([
				'status' => 'Ok',
				'message' => 'Collection Created',
			], 200);
			
			return dd($request->all(), $collection);
			$post_array = [
				
				'filling_qty' => $request->filling_qty,
				'filling_date' => $request->filling_date,
				'remark' => $request->remark ?? null
			];
		}else{
			return response()->json([
				'status' => 'fail',
				'message' => 'Not Data Found',
			], 404);
		}
	}
	
	public function saveSingleCollection($request){
		$tripDataId = Verifiedloads::find($request->verified_load_id)->trip_data_id;
		
		$tripData = TripData::find($tripDataId);
		$tripData->status = 'filled';
		$tripData->site_out = \Carbon\Carbon::now('Asia/Calcutta')->format('Y-m-d H:i:s');
		$tripData->save();
		// message api
		$trip_arr = TripData::with('trip','trip.route','trip.vechile','trip.beat_plan','trip.vendor','site')->find($tripDataId)->toArray();
		$trip_arr['qty'] = Helper::getQtyByBeatplanIdAndDataid($trip_arr['beatplan_id'],$trip_arr['data_id']);
		$time = \Carbon\Carbon::now('Asia/Calcutta')->format('H:i:s');
		$response = $this-($trip_arr, $time);
		return $response;
	}
	
	public function update_status_to_filled(Request $request){
		$load = Verifiedloads::find($request->verified_load_id);
		$load->status = 'filled';
		$load->save();
		$tripData = TripData::find($load->trip_data_id);
		$tripData->status = $load->status;
		//$tripData->site_out = \Carbon\Carbon::now('Asia/Calcutta')->format('Y-m-d H:i:s');
		$tripData->save();
		
		return response()->json([
			'status' => 'Ok',
			'message' => 'Status Updated',
			'data' => $load
		]);
		
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
	public function imageUploadDirect(Request $request)
	{
		//dd($request->all());
		$validator = Validator::make($request->all(), [
			'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);
		if ($validator->fails()) {    
			return response()->json($validator->messages(), 200);
		}
		$imageName = time().$request->attrname.'.'.$request->file('file')->extension();  
		$request->file('file')->move(public_path('images'), $imageName);
		return response()->json([
			'status' => 'Ok',
			'message' => 'Image uploaded!',
			'imgName' => $imageName
		]);

	}
	public function($data='',$time='')
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

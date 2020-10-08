<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\BeatPlanImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Beatplan;
use App\BeatPlanData;
use App\User;

class BeatPlanController extends Controller
{
	public function planList(Request $request)
	{
		if($request->has('id')) {
			$all = array();
			if ($request->type == 'subadmin') {
				$sudadminId = $request->id;
				$Ids = $this->getAllMisIdsBySubAdminId($request->id);
				foreach ($Ids as $key) {
					array_push($all, $key->id);
				}
				array_push($all, $request->id);
			}elseif ($request->type == 'mis') {
				array_push($all, $request->id);
			}
			$sites = Beatplan::leftJoin('beatplan_data', function($join) {
				$join->on('beatplan_data.beatplan_id', '=', 'beatplans.id');
			})->leftJoin('site_master', function($join) {
				$join->on('site_master.id', '=', 'beatplan_data.site_id');
			});
			$plan = $sites->whereIn('beatplans.added_by',$all)->select('beatplans.*','site_master.site_name')->get();
			if(!$plan->isEmpty()){
				return response()->json([
					'status' => 'Ok',
					'message' => 'Beat Plans Listing',
					'details' => $plan
				]);
			}else{
				return response()->json([
					'status' => 'Ok',
					'message' => 'No List Available',
					'details' => null
				]);
			}
		}
	}
	public function getAllMisIdsBySubAdminId($subadminID)
	{	
		$ids = User::where(['created_by_id' => $subadminID, 'type' => 'mis'])->select('id')->get();
		return $ids;
	}
	public function import(){
		if(Excel::import(new BeatPlanImport,request()->file('file'))){
			return response()->json([
				'status' => 'Ok',
				'message' => 'CSV imported successfully!'
			]);
		}else{
			return response()->json([
				'status' => 'Not Ok',
				'message' => 'Something went wrong importation un-successfull!'
			]);
		}
	}
    public function createBeatPlan(Request $request)
    {
    	if($request->has('siteIds')){
            $sites = $request->siteIds;
            $plan = new Beatplan();         
            $plan->mp_zone = $request->mp_zone;
            $plan->added_date = $request->added_date;
            $plan->client_id = $request->client_id;
            $plan->mode = $request->mode;
            $plan->effective_date = $request->effective_date;
            $plan->added_by = auth()->user()->id;
            $plan->save();
            $plan_id = $plan->id;
            foreach ($sites as $key) {
            	$beatplandata = new BeatPlanData;
                $beatplandata->beatplan_id = $plan_id;
                $beatplandata->site_id = $key->site_id;
                $beatplandata->quantity = $key->quantity;
                $beatplandata->save();	
            }
             return response()->json([
				'status' => 'Ok',
				'message' => 'Plan created successfully!'
			]); 
        }else{
            return response()->json([
				'status' => 'Not Ok',
				'message' => 'Somenthing Went wrong!'
			]); 
        }
    }
	
    public function getEffectiveDateList(Request $request, Beatplan $plan){
    	if(auth()->user()->type == 'subadmin'){
    		$data = $plan->where(['mp_zone' => $request->zone,'added_by' => auth()->user()->id])->select('effective_date','id')->get();
    		return response()->json([
				'status' => 'Ok',
				'message' => 'All effective date list!',
				'details' => $data
			]); 
    	}elseif (auth()->user()->type == 'mis') {
    		$data = $plan->where(['mp_zone' => $request->zone,'added_by' => auth()->user()->created_by_id])->select('effective_date','id')->get();
    		return response()->json([
				'status' => 'Ok',
				'message' => 'All effective date list!',
				'details' => $data
			]);
    	}
    }
	
	public function siteListByBeatId(Request $request){
    	if(auth()->user()->type == 'subadmin'){
    		$data = BeatPlanData::join('beatplans','beatplans.id','beatplan_data.beatplan_id')->join('site_master','site_master.id','beatplan_data.site_id')->where(['beatplan_data.beatplan_id' => $request->beatplan_id,'beatplans.added_by' => auth()->user()->id])->select('effective_date','beatplans.id','site_master.site_id','beatplan_data.quantity','beatplan_data.id as beatplandata_id','beatplan_data.site_id as p_site_id')->get();
    		return response()->json([
				'status' => 'Ok',
				'message' => 'All site list!',
				'details' => $data
			]); 
    	}elseif (auth()->user()->type == 'mis') {
			$data = BeatPlanData::join('beatplans','beatplans.id','beatplan_data.beatplan_id')->join('site_master','site_master.id','beatplan_data.site_id')->where(['beatplan_data.beatplan_id' => $request->beatplan_id,'beatplans.added_by' => auth()->user()->created_by_id])->select('effective_date','beatplans.id','site_master.site_id','beatplan_data.quantity','beatplan_data.id as beatplandata_id','beatplan_data.site_id as p_site_id')->get();
    		
    		return response()->json([
				'status' => 'Ok',
				'message' => 'All site list!',
				'details' => $data
			]);
    	}
    }
    public function getEffectiveDateListForReport(Request $request, Beatplan $plan){
    	if(auth()->user()->type == 'subadmin'){
    		$data = $plan->where(['added_by' => auth()->user()->id])->select('effective_date','id')->get();
    		return response()->json([
				'status' => 'Ok',
				'message' => 'All effective date list!',
				'details' => $data
			]); 
    	}elseif (auth()->user()->type == 'mis') {
    		$data = $plan->where(['added_by' => auth()->user()->created_by_id])->select('effective_date','id')->get();
    		return response()->json([
				'status' => 'Ok',
				'message' => 'All effective date list!',
				'details' => $data
			]);
    	}
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sitemaster;
use App\Misallottedzones;


class MisController extends Controller
{
	public function zoneAllotment($misId=null)
	{
		if(!empty($misId)){
			$users = User::find($misId);
			$allotments = Misallottedzones::leftjoin('users','users.id','mis_allotted_zones.alloted_by')->where('mis_user_id','=',$misId)->select('users.*','mis_allotted_zones.id as zoneid','mis_allotted_zones.*')->get();
			// dd($allotments);
			return view('mis.zone-allotment',['users' => $users,'allotments'=>$allotments]);
		}    	
	}
public function zoneNameList(Request $request,Sitemaster $sites)
	{
		$response = [];$numrecords = 10;
		if ($request->has('name')) {
			$search = $request->name;
			if(auth()->user()->type == 'subadmin'){
				$data = $sites->where('mp_zone', 'LIKE', "%{$search}%")->where(['created_by_id'=>auth()->user()->id])->limit($numrecords)->select('mp_zone')->get();
				$unique = $data->unique();
			}elseif (auth()->user()->type == 'mis') {
				$data = Misallottedzones::where('mp_zones', 'LIKE', "%{$search}%")->where(['mis_user_id' => auth()->user()->id, 'alloted_by' => auth()->user()->created_by_id])->limit($numrecords)->select('mp_zones as mp_zone')->get();
				$unique = $data->unique();
			}
			foreach ($unique as $p) { $response[] = array("name" => $p->mp_zone); }
		} else {
			$data = $sites->limit($numrecords)->get();
		}
		return response()->json($response);
	}
	public function allotZone(Request $request)
	{

		$mis_user_id = $request->mis_user_id;
		$zone = new	Misallottedzones();
		$zone->mis_user_id = $mis_user_id;
		$zone->allotted_client_id = $request->client_id;
		$zone->mp_zones = $request->zone;
		$zone->alloted_by = auth()->user()->id;
		$zone->save();
		return back()->with('success','Zone alloted successfully!');
	}
	public function updateAllotedZone(Request $request, $id)
	{
		$zone =	Misallottedzones::find($id);
		$mis_user_id = $request->misid;
		$zone->mis_user_id = $mis_user_id;
		$zone->allotted_client_id = $request->client_id_update;
		$zone->mp_zones = $request->zone;
		$zone->save();
		return back()->with('success','Zone alloted successfully!');
	}
	public function deleteAllotedZone(Request $request, $id)
	{
		Misallottedzones::destroy($id);
        return back()->withStatus(__('Zone successfully deleted.'));
	}
	
}

<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Imports\BeatPlanImport;
use App\Beatplans;
use App\Beatplan;
use App\Trips;
use App\TripData;
use App\BeatPlanData;
use App\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Actiondetails;
use App\Sitemaster;
use App\Misallottedzones;
use App\Verifiedloads;
use App\Divert;
use App\User;
use App\Helpers\Helper;

class BeatPlanController extends Controller
{
    public function import() 
    {
        try {
            $import = new BeatPlanImport;
            Excel::import($import, request()->file('file'));
               //dd($import->getRowCount());
            if($import->getRowCount()){
                return back()->with('success','Total '.$import->getRowCount().' rows imported successfully!');
            }else{
                return back()->with('error','Either site_id, mpzone_name or client_name does not existed in master database.!');       
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
                //dd($failures);
            $error = '';
            foreach ($failures as $failure) {
             $failure->row(); // row that went wrong
             $failure->attribute(); // either heading key (if using heading row concern) or column index
             $failure->errors(); // Actual error messages from Laravel validator
             $failure->values(); // The values of the row that has failed.
             $error .= ' '.$failure->errors()[0];
         }
         return back()->with('error',$error);
     }
        // if(Excel::import(new BeatPlanImport,request()->file('file'))){
        //     return back()->with('success','CSV imported successfully!');
        // }else{
        //     return back()->with('error','Something went wrong importation un-successfull!');
        // }
 }
 public function editBeatPlan($id='')
 {
    $plan = Beatplans::find($id);
    return view('pages.edit-beat-plan',compact('plan'));
}
public function deleteBeatPlan($id='')
{
    if($id){
        $beatPlanId = $id;
        if (BeatPlanData::where(['beatplan_id' => $beatPlanId])->exists()) {
            if (TripData::where(['beatplan_id' => $beatPlanId])->exists()) {
                $tripData = TripData::where(['beatplan_id' => $beatPlanId])->get();
                if (isset($tripData) && !empty($tripData)) {
                    foreach ($tripData as $key) {
                        $verified = Verifiedloads::where(['trip_data_id' => $key->id])->select('id')->first();
                        if(isset($verified) && !empty($verified)) {        
                            if(Divert::where(['verified_id'=>$verified['id']])->exists()){
                                Divert::where(['verified_id'=>$verified['id']])->delete();
                            } 
                            Verifiedloads::find($verified['id'])->delete();
                            Collection::where(['verified_load_id' => $verified['id']])->delete();       
                        }
                        TripData::find($key->id)->delete();   
                    }
                    Trips::where(['beatplan_id' => $beatPlanId])->delete();
                }  
            }
            BeatPlanData::where(['beatplan_id' => $beatPlanId])->delete();
            Beatplan::find($beatPlanId)->delete();
        }else{
            Beatplan::find($beatPlanId)->delete();
        }
        return back()->with('success','Data deleted successfully!');
    }
}
public function editBeatPlanAction(Request $request)
{
    $plan = Beatplans::find($request->id);
    $plan->vehicle_no = $request->vehicle_no;
    $plan->alloted_user_id = $request->alloted_user_id; 
    $plan->site_id = $request->site_id; 
    $plan->plan_date = $request->plan_date;
    $plan->site_name = $request->site_name;
    $plan->site_type = $request->site_type;
    $plan->maintenance_point = $request->maintenance_point;
    $plan->beat_plan_ltr = $request->beat_plan_ltr;
    $plan->technician_name = $request->technician_name;
    $plan->technician_mobile = $request->technician_mobile;
    $plan->route_plan = $request->route_plan;
    $plan->ro_name = $request->ro_name;
    $plan->latitude = $request->latitude;
    $plan->longitude = $request->longitude;
    $plan->driver_name = $request->driver_name;
    $plan->driver_mobile = $request->driver_mobile;
    $plan->filler_name = $request->filler_name;
    $plan->filler_mobile = $request->filler_mobile;
    $plan->save();
    return back()->with('success','Data updated successfully!');
}
public function Handbook()
{
    if(auth()->user()->type == 'subadmin'){
        $addedBy = array();
        $Ids = $this->getAllMisIdsBySubAdminId(auth()->user()->id);
        foreach ($Ids as $key) {
            array_push($addedBy, $key->id);
        }
        array_push($addedBy, auth()->user()->id);
        $plans = Beatplan::leftjoin('vendors', function($join){
            $join->on('vendors.id','=','beatplans.client_id');    
        })->whereIn('beatplans.added_by',$addedBy)->select('beatplans.*','vendors.name as clientname')->get();
        return view('collection.handbook',compact('plans'));
    }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
        $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
        if (isset($allotedData) && !empty($allotedData)) {
            $plans = Beatplan::leftjoin('vendors', function($join){
                $join->on('vendors.id','=','beatplans.client_id');    
            })->where(function($q) use ($allotedData){
                $i = 1;
                foreach ($allotedData as $key) {
                    if ($i == 1 ) {
                        $q->where(['beatplans.added_by' => auth()->user()->created_by_id, 'beatplans.mp_zone' => $key->zone, 'beatplans.client_id' => $key->client]);
                    }else{
                        $q->orWhere(['beatplans.added_by' => auth()->user()->created_by_id, 'beatplans.mp_zone' => $key->zone, 'beatplans.client_id' => $key->client]);
                    }
                    $i++;
                }
            })->select('beatplans.*','vendors.name as clientname')->paginate(10);
            return view('collection.handbook',compact('plans'));
        }
    }
}
public function handbookTrips($beatId='')
{
    $trips = Trips::where('beatplan_id','=',$beatId)->get();
    return view('collection.handbook-trips',compact('trips'));
}
public function uploadHandbookPage($tripId='')
{
    $sites = TripData::leftjoin('beatplans', function($join){
        $join->on('beatplans.id','=','trip_data.beatplan_id');
    })->where(['trip_data.trip_id' => $tripId])->select('trip_data.id','trip_data.data_id','beatplans.effective_date as plan_date','trip_data.status')->get();
    return view('collection.handbook-sites',compact('sites')); 
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
public function uploadHandbook(Request $request)
{
        // if(isset($request->ids)){
        //     $plans = $request->ids;
        //     $imageName = NULL;
        //     if($request->hasFile('handbook_image')){
        //         $imageName = $this->imageUpload($request,'handbook_image');
        //     }
        //     foreach ($plans as $key) {
        //         $beatplans = TripData::find($key);
        //         $beatplans->handbook_img = $imageName;
        //         $beatplans->save();
        //     }
        //     return back()->with('success','Handbook updated successfully!');    
        // }else{
        //     return back()->with('error','You do not have alloted id!');    
        // } 
    if($request->has('trip_data_id')){
        $tripDataId = $request->trip_data_id;
        $imageName = NULL;
        if($request->hasFile('handbook_image')){
            $imageName = $this->imageUpload($request,'handbook_image');
        }
        $beatplans = TripData::find($tripDataId);
        $beatplans->handbook_img = $imageName;
        $beatplans->save();
        return back()->with('success','Handbook updated successfully!');
    }

}
public function deleteRow(Request $request)
{
    $ids = $request->planids;
    foreach ($ids as $key) {
        Beatplans::destroy($key);
        Collections::where('beat_plans_id', $key)->delete();
    }
    return true;
}
public function createBeatPlanAction(Request $request)
{
    $validateplan = $this->validateplan($request->site_id,$request->client_name);
    if($validateplan){
        $plan = new Beatplans;
        $plan->vehicle_no = $request->vehicle_no;
        $plan->alloted_user_id = $request->alloted_user_id; 
        $plan->site_id = $request->site_id; 
        $plan->plan_date = $request->plan_date;
        $plan->site_name = $request->site_name;
        $plan->site_type = $request->site_type;
        $plan->maintenance_point = $request->maintenance_point;
        $plan->beat_plan_ltr = $request->beat_plan_ltr;
        $plan->technician_name = $request->technician_name;
        $plan->technician_mobile = $request->technician_mobile;
        $plan->route_plan = $request->route_plan;
        $plan->ro_name = $request->ro_name;
        $plan->latitude = $request->latitude;
        $plan->longitude = $request->longitude;
        $plan->driver_name = $request->driver_name;
        $plan->driver_mobile = $request->driver_mobile;
        $plan->filler_name = $request->filler_name;
        $plan->filler_mobile = $request->filler_mobile;
        $plan->save();
        if(auth()->user()->type == 'mis'){
            $action = new Actiondetails;
            $action->performed_by_user_type = auth()->user()->type;
            $action->performed_by_user_id = auth()->user()->id;
            $action->performed_in_table = 'beat_plans';
            $action->row_id = $plan->id;
            $action->subadmin_approval_required = 'YES';
            $action->performed_action = 'Create';
            $action->action_date = date("Y-m-d H:i:s");
            $action->appoved_by_mis = 'NO NEED';
        }
        return back()->with('success','Plan created successfully!');    
    }else{
        return back()->with('error','Site id or Client Name did not match!'); 
    }
}
public function validateplan($site_id, $client_name)
{
    if(isset($site_id) && isset($client_name)){
        if (Sitemaster::where(['client_name' => $client_name,'site_id' => $site_id,'created_by_id' => auth()->user()->created_by_id])->exists()) {
            return true;
        }
    }
}

    // new code
public function index(Request $request)
{
    return view('metronic.beatplan.index');

    if (auth()->user()->type == 'admin') {
        return redirect()->route('user.index');
    }elseif (auth()->user()->type == 'subadmin') {
        $addedBy = array();
        $Ids = $this->getAllMisIdsBySubAdminId(auth()->user()->id);
        foreach ($Ids as $key) {
            array_push($addedBy, $key->id);
        }
        array_push($addedBy, auth()->user()->id);
        if($request){
            if($request->has('from_date') && $request->has('to_date')){
               $plans = Beatplan::whereIn('added_by',$addedBy)->whereBetween('effective_date',[$request->from_date, $request->to_date])->orderBy('id','DESC')->paginate(10);   
               return view('beatplan.index',['plans' => $plans]);
           }elseif($request->has('head_name') && $request->has('search_val')){
            if($request->head_name != 'client_name'){
                $plans = Beatplan::whereIn('added_by',$addedBy)->where($request->head_name,'=',$request->search_val)->orderBy('id','DESC')->paginate(10);   
                return view('beatplan.index',['plans' => $plans]);
            }else{
                $cvalue = $request->search_val;
                $plans = Beatplan::whereIn('added_by',$addedBy)->whereHas('client',function($q) use($cvalue){
                    return $q->where('name', '=', $cvalue);
                })->orderBy('id','DESC')->paginate(10);   
                return view('beatplan.index',['plans' => $plans]);
            }
        }else{
            $plans = Beatplan::whereIn('added_by',$addedBy)->orderBy('id','DESC')->paginate(10);
            return view('beatplan.index',['plans' => $plans]);    
        }
    }else{
        $plans = Beatplan::whereIn('added_by',$addedBy)->orderBy('id','DESC')->paginate(10);
        return view('beatplan.index',['plans' => $plans]);
    }
}elseif (auth()->user()->type == 'vendor') {
    $plans = Beatplan::where('added_by','=',auth()->user()->id)->paginate(10);
    return view('beatplan.index',['plans' => $plans]);
}elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
    $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
    $query = Beatplan::where(function($q) use($allotedData){
        if(isset($allotedData) && !empty($allotedData)){
            $i = 1;
            foreach ($allotedData as $key) {
                if ($i == 1 ) {
                    $q->where(['added_by' => auth()->user()->created_by_id, 'mp_zone' => $key->zone, 'client_id' => $key->client]);
                }else{
                    $q->orWhere(['added_by' => auth()->user()->created_by_id, 'mp_zone' => $key->zone, 'client_id' => $key->client]);
                }
                $i++;
            }
        }
    });
    $plans = $query->paginate(10);
    return view('beatplan.index',['plans' => $plans]);
    if($request){
        if($request->has('from_date') && $request->has('to_date')){
           $plans = $query->whereBetween('effective_date',[$request->from_date, $request->to_date])->paginate(10);
           return view('beatplan.index',['plans' => $plans]);
       }elseif($request->has('head_name') && $request->has('search_val')){
        if($request->head_name != 'client_name'){
            $plans = $query->where($request->head_name,'=',$request->search_val)->paginate(10);
            return view('beatplan.index',['plans' => $plans]);
        }else{
            $plans = $query->paginate(10);
            return view('beatplan.index',['plans' => $plans]);
        }
    }else{
        $plans = $query->paginate(10);
        return view('beatplan.index',['plans' => $plans]);    
    }
}else{
    $plans = $query->paginate(10);
    return view('beatplan.index',['plans' => $plans]);
}
}
elseif (auth()->user()->type == 'filler' || auth()->user()->type == 'driver' || auth()->user()->type == 'field_officer') {
    return redirect()->route('collections');
}elseif (auth()->user()->type == 'client') {
    $all = array();
    $sudadminId = auth()->user()->created_by_id;
    $Ids = $this->getAllMisIdsBySubAdminId($sudadminId);
    foreach ($Ids as $key) {
        array_push($all, $key->id);
    }
    array_push($all, $sudadminId);
    $plans = Beatplan::where(['client_id' => Auth::user()->client->id])->whereIn('added_by',$all)->paginate(10);
    return view('beatplan.client.index',['plans' => $plans]);
}else{
    abort(404);
}
}
public function create()
{
    return view('metronic.beatplan.create');
}
public function store(Request $request)
{
    $validatedData = $request->validate([
        'zone' => 'required',
        'current_date' => 'required',
        'client_id' => 'required',
        'mode' => 'required',
        'effective_date' => 'required',
    ]);
    // if($request->has('siteid')){
    //     $siteIds = $request->siteid;
    //     $quantity = $request->quantity;
    //     $countArr = count($siteIds);
    //     $plan = new Beatplan();         
    //     $plan->mp_zone = $request->zone;
    //     $plan->added_date = $request->current_date;
    //     $plan->client_id = $request->client_id;
    //     $plan->mode = $request->mode;
    //     $plan->effective_date = $request->effective_date;
    //     $plan->added_by = auth()->user()->id;
    //     $plan->save();
    //     $plan_id = $plan->id;
    //     for ($i=0; $i < $countArr ; $i++) { 
    //         $beatplandata = new BeatPlanData;
    //         $beatplandata->beatplan_id = $plan_id;
    //         $beatplandata->site_id = $siteIds[$i];
    //         $beatplandata->quantity = $quantity[$i];
    //         $beatplandata->save();
    //     }
    //     return redirect('/beat-plan')->with('success', 'Plan created successfully!');
    // }else{
    //     return back()->with('error','You did not add any site!');  
    // }  
    $siteArray = $request->siteArray;
    $plan = new Beatplan(); 
    $plan->mp_zone = $request->zone;
    $plan->added_date = $request->current_date;
    $plan->client_id = $request->client_id;
    $plan->mode = $request->mode;
    $plan->effective_date = $request->effective_date;
    $plan->added_by = auth()->user()->id;
    if($plan->save()){
        $plan_id = $plan->id;
        if(isset($siteArray) && !empty($siteArray)){
            foreach ($siteArray as $site) {
                $beatplandata = new BeatPlanData;
                $beatplandata->beatplan_id = $plan_id;
                $beatplandata->site_id = $site['siteid'];
                $beatplandata->quantity = $site['quantity'];
                $beatplandata->save();       
            }
        }
        return redirect('/beat-plan')->with('success', 'Plan created successfully!');
    }
}
public function effectiveDateForTrip(Request $request,Beatplan $plan, $zone)
{
    $response = [];$numrecords = 10;
    if ($request->has('name')) {
        $search = $request->name;
        if(auth()->user()->type == 'subadmin'){
           $addedBy = array();
           $Ids = $this->getAllMisIdsBySubAdminId(auth()->user()->id);
           foreach ($Ids as $key) {
            array_push($addedBy, $key->id);
        }
        array_push($addedBy, auth()->user()->id);
        $data = $plan->where('effective_date', 'LIKE', "%{$search}%")->where(['mp_zone' => $zone])->whereIn('added_by',$addedBy)->limit($numrecords)->get();
    }elseif (auth()->user()->type == 'mis') {
     $clients = Helper::getClientIdsByZoneAndId($zone,auth()->user()->id);
     if(isset($clients) && !empty($clients)){
        $data = $plan->where('effective_date', 'LIKE', "%{$search}%")->where(['mp_zone' => $zone, 'added_by' => auth()->user()->created_by_id])->whereIn('client_id',$clients)->limit($numrecords)->get();
    }else{
        $data = $plan->where('effective_date', 'LIKE', "%{$search}%")->where(['mp_zone' => $zone, 'added_by' => auth()->user()->id])->limit($numrecords)->get();
    }
}
        //$data1 = $data->unique('effective_date');
foreach ($data as $p) { 
   $response[] = array("id" => $p->id, 'vendor_code'=>$p->client->vendor_code, "name" => $p->effective_date.' '.$p->client->vendor_code, "effective_date" => $p->effective_date); 
}
} else {
    $data = $plan->limit($numrecords)->get();
        //$data1 = $data->unique('effective_date');
}
return response()->json($response);
}
public function siteListForPlan(Request $request, Sitemaster $sites, $zone='', $clientId='')
{
    //return dd($zone);
    $response = [];$numrecords = 10;
    if ($request->has('name')) {
        $search = $request->name;
        if(auth()->user()->type == 'subadmin'){
            $data = $sites->where('site_id', 'LIKE', "%{$search}%")->where(['created_by_id' => auth()->user()->id, 'mp_zone' => $zone, 'client_id' => $clientId ])->limit($numrecords)->get();
        }elseif (auth()->user()->type == 'mis') {
            $data = $sites->where('site_id', 'LIKE', "%{$search}%")->where(['created_by_id' => auth()->user()->created_by_id, 'mp_zone' => $zone, 'client_id' => $clientId ])->limit($numrecords)->get();
        }
        foreach ($data as $p) { $response[] = array("id" => $p->id, "name" => $p->site_id, "site_name" => $p->site_name, 'technician_name' => $p->technician_name); }
    } else {
        $data = $sites->limit($numrecords)->get();
    }
    return response()->json($response);
}

public function siteDetailsForTrip(Request $request, $zone = '', $date = ''){
  $response = [];
  $numrecords = 10;
  if ($request->has('name')) {
   $search = $request->name;
   $sites = Beatplan::leftJoin('beatplan_data', function($join) {
    $join->on('beatplan_data.beatplan_id', '=', 'beatplans.id');
})->leftJoin('site_master', function($join) {
    $join->on('site_master.id', '=', 'beatplan_data.site_id');
});
   // })->where('beatplans.id',$request->beatPlanIdForS);
if(auth()->user()->type == 'subadmin'){
    $data = $sites->where('site_master.site_id', 'LIKE', "%{$search}%")->where(['beatplans.mp_zone' => $request->zone, 'beatplans.effective_date' => $request->date, 'beatplan_data.status' => 'pending' ])->limit($numrecords)->select('site_master.id','site_master.site_name','site_master.site_id','site_master.technician_name','beatplan_data.quantity','beatplans.id as beatplanid','beatplan_data.site_id as site_id2','beatplan_data.id as beatplandataid')->get();
                //$unique = $data->unique();
}elseif (auth()->user()->type == 'mis') {
    $data = $sites->where('site_master.site_id', 'LIKE', "%{$search}%")->where(['beatplans.added_by' => auth()->user()->created_by_id, 'beatplans.mp_zone' => $request->zone, 'beatplans.effective_date' => $request->date , 'beatplan_data.status' => 'pending'])->limit($numrecords)->select('site_master.id','site_master.site_name','site_master.site_id', 'site_master.technician_name','beatplan_data.quantity','beatplans.id as beatplanid','beatplan_data.site_id as site_id2','beatplan_data.id as beatplandataid')->get();
                //$unique = $data->unique();
}
foreach ($data as $p) {
    //  dd();
    $response[] = array("trip_data" => $p->single_trip_data($p->beatplanid, $p->id),"site_id" => $p->site_id2,"id" => $p->id, "name" => $p->site_id, "sitename" => $p->site_name, "quantity" => $p->quantity, "beatplanid" => $p->beatplanid, "beatplandataid" => $p->beatplandataid, 'technician_name' => $p->technician_name); 
}
} else {
   $data = $sites->limit($numrecords)->get();
}
return response()->json($response);
}
public function edit($id='')
{
    if(isset($id) && !empty($id)){
        $plan = Beatplan::find($id);
        return view('beatplan.edit',['plan'=> $plan]);
    }
}
public function update(Request $request)
{
    if($request->has('siteid')){
        $beatPlanId = $request->beatplan_id;
        $siteIds = $request->siteid;
        $quantity = $request->quantity;
        $planDataIds = $request->plandata_id;
        $countArr = count($siteIds);
        $plan = Beatplan::find($request->beatplan_id);         
        $plan->mp_zone = $request->zone;
        $plan->added_date = $request->current_date;
        $plan->client_id = $request->client_id;
        $plan->mode = $request->mode;
        $plan->effective_date = $request->effective_date;
        $plan->added_by = auth()->user()->id;
        $plan->save();
        for ($i=0; $i < $countArr ; $i++) { 
            if($planDataIds[$i]){
                $beatplandata = BeatPlanData::find($planDataIds[$i]);
                $beatplandata->beatplan_id = $beatPlanId;
                $beatplandata->site_id = $siteIds[$i];
                $beatplandata->quantity = $quantity[$i];
                $beatplandata->save();
            }else{
                $beatplandata = new BeatPlanData;
                $beatplandata->beatplan_id = $beatPlanId;
                $beatplandata->site_id = $siteIds[$i];
                $beatplandata->quantity = $quantity[$i];
                $beatplandata->save();
            }
        }
        return redirect('/beat-plan')->with('success', 'Plan updated successfully!');  
    }else{
        return back()->with('error','You did not update any site!');  
    }  
}
public function removeSitesFromEdit(Request $request)
{
    if($request->has('dataId')){
        $beatPlanDataId = $request->dataId;
        if (BeatPlanData::find($beatPlanDataId)->exists()) {
            $beatPlanData = BeatPlanData::find($beatPlanDataId);
            $tripData = TripData::where(['beatplan_id' => $beatPlanData['beatplan_id'], 'data_id' => $beatPlanData['site_id']])->select('id')->first();
            if (isset($tripData) && !empty($tripData) && $tripData['id']) {
                $verified = Verifiedloads::where(['trip_data_id' => $tripData['id']])->select('id')->first();
                if (isset($verified) && !empty($verified) && $verified['id']) {
                    if(Divert::where(['verified_id'=>$verified['id']])->exists()){
                        Divert::where(['verified_id'=>$verified['id']])->delete();
                    }
                    Verifiedloads::find($verified['id'])->delete();
                }
                TripData::find($tripData['id'])->delete();   
            }
            BeatPlanData::find($beatPlanDataId)->delete();
        }
        return response()->json([
            'message' => 'Data Deleted',
            'status' =>'ok'
        ]);
    }
}
public function getAllMisIdsBySubAdminId($subadminID){   
    $ids = User::where(['created_by_id' => $subadminID, 'type' => 'mis'])->select('id')->get();
    return $ids;
}
public function dataTablePlan(Request $request)
{
    $returndata = [];
    if(auth()->user()->type == 'subadmin'){
        $addedBy = array();
        $Ids = $this->getAllMisIdsBySubAdminId(auth()->user()->id);
        foreach ($Ids as $key) {
            array_push($addedBy, $key->id);
        }
        array_push($addedBy, auth()->user()->id);
        $returndata = Beatplan::whereIn('added_by',$addedBy)->get();
    }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
        $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
        $query = Beatplan::where(function($q) use($allotedData){
            if(isset($allotedData) && !empty($allotedData)){
                $i = 1;
                foreach ($allotedData as $key) {
                    if ($i == 1 ) {
                        $q->where(['added_by' => auth()->user()->created_by_id, 'mp_zone' => $key->zone, 'client_id' => $key->client]);
                    }else{
                        $q->orWhere(['added_by' => auth()->user()->created_by_id, 'mp_zone' => $key->zone, 'client_id' => $key->client]);
                    }
                    $i++;
                }
            }
        });
        $returndata = $query->get();
    }
    $columnsDefault = [
        'id'     => true,
        'added_date'     => true,
        'mp_zone'      => true,
        'effective_date'      => true,
        'client_name'     => true,
        'mode'  => true,
        'cstatus'  => true,
        'action'  => true,
    ];

    if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
        $columnsDefault = [];
        foreach ( $_REQUEST['columnsDef'] as $field ) {
            $columnsDefault[ $field ] = true;
        }
    }

    // get all raw data
    //$returndata = Beatplan::whereIn('added_by',$addedBy)->get();
    $alldata = array();
    if(isset($returndata) && !empty($returndata)){
        $i = 0;
        foreach ($returndata as $plan) {
            $alldata[$i]['id'] = $plan->id;
            $alldata[$i]['added_date'] = $plan->added_date;
            $alldata[$i]['mp_zone'] = $plan->mp_zone;
            $alldata[$i]['effective_date'] = $plan->effective_date;
            $alldata[$i]['client_name'] = $plan->client->name;
            $alldata[$i]['mode'] = $plan->mode;
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
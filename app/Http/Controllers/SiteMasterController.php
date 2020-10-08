<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitemaster;
use App\Imports\SiteMasterImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SiteMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('site_id')){
            $search = $request->site_id; 
            $site = Sitemaster::leftjoin('vendors', function($join){
                $join->on('vendors.id','=','site_master.client_id');   
            })->select('site_master.*','vendors.name','vendors.gst_no','vendors.billing_address')->where('site_master.site_id', 'LIKE', "%{$search}%")->orderBy('id','DESC')->paginate(15);
            return view('site-master.index',['sites' => $site]);
        }else{
            $site = Sitemaster::leftjoin('vendors', function($join){
                $join->on('vendors.id','=','site_master.client_id');   
            })->select('site_master.*','vendors.name','vendors.gst_no','vendors.billing_address')->orderBy('id','DESC')->paginate(15);
            return view('site-master.index',['sites' => $site]);
        //return view('site-master.server-side-index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('site-master.create');
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sitemaster  = new Sitemaster;
        $sitemaster->site_id = $request->site_id;
        $sitemaster->unique_site_id = $request->unique_site_id;
        $sitemaster->site_name = $request->site_name;
        $sitemaster->cluster_jc = $request->cluster_jc;
        $sitemaster->district = $request->district;
        $sitemaster->mp_zone = $request->mp_zone;
        $sitemaster->site_address = $request->site_address;
        $sitemaster->latitude = $request->latitude;
        $sitemaster->longitude = $request->longitude;
        if($request->site_type == 'Select Site Type'){
            $sitemaster->site_type = null;
        }else{
           $sitemaster->site_type = $request->site_type;   
       }
       if($request->bts == 'Select BTS'){
        $sitemaster->bts = null;
    }else{
        $sitemaster->bts = $request->bts;   
    }
    $sitemaster->site_category = $request->site_category;
    $sitemaster->battery_bank_ah = $request->battery_bank_ah;
    $sitemaster->cph = $request->cph;
    $sitemaster->indoor_bts = $request->indoor_bts;
    $sitemaster->outdoor_bts = $request->outdoor_bts;
    if($request->dg1_make == 'Select Site Type'){
        $sitemaster->dg1_make = null;
    }else{
       $sitemaster->dg1_make = $request->dg1_make;
   }
   if($request->dg2_make == 'Select Site Type'){
    $sitemaster->dg2_make = null;
}else{
   $sitemaster->dg2_make = $request->dg2_make;
}
$sitemaster->dg1_rating_in_kva = $request->dg1_rating_in_kva;
$sitemaster->dg2_rating_in_kva = $request->dg2_rating_in_kva;
if($request->eb_status == 'Select EB Status'){
    $sitemaster->eb_status = null;
}else{
   $sitemaster->eb_status = $request->eb_status;   
}
if($request->eb_type == 'Select EB Type'){
    $sitemaster->eb_type = null;
}else{
    $sitemaster->eb_type = $request->eb_type;   
}
$sitemaster->eb_load_kw = $request->eb_load_kw;
$sitemaster->technician_name = $request->technician_name;
$sitemaster->technician_contact2 = $request->technician_contact2;
$sitemaster->technician_contact1 = $request->technician_contact1;
$sitemaster->cluster_incharge_name = $request->cluster_incharge_name;
$sitemaster->cluster_incharge_contact1 = $request->cluster_incharge_contact1;
$sitemaster->cluster_incharge_contact2 = $request->cluster_incharge_contact2;
$sitemaster->cluster_incharge_email = $request->cluster_incharge_email;
$sitemaster->zom_name = $request->zom_name;
$sitemaster->zom_contact = $request->zom_contact;
$sitemaster->zom_email = $request->zom_email;
$sitemaster->energy_man_name = $request->energy_man_name;
$sitemaster->energy_man_contact = $request->energy_man_contact;
$sitemaster->energy_man_email = $request->energy_man_email;
$sitemaster->circle_facility_head_name = $request->circle_facility_head_name;
$sitemaster->circle_facility_head_contact = $request->circle_facility_head_contact;
$sitemaster->circle_facility_head_email = $request->circle_facility_head_email;
$sitemaster->client_id = $request->client_id;
$sitemaster->created_by_id = auth()->user()->id;
$sitemaster->save();
return back()->with('success','Site created successfully!');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Sitemaster $sites, $id)
    {
     $response = [];$numrecords = 10;
     if ($request->has('name')) {
        $search = $request->name;
        if(auth()->user()->type != 'subadmin'){
            $data = $sites->where('site_name', 'LIKE', "%{$search}%")->where(['created_by_id'=>auth()->user()->created_by_id, 'gst_no' => $id])->limit($numrecords)->get();
        }else{
            $data = $sites->where('site_name', 'LIKE', "%{$search}%")->where(['gst_no' => $id])->limit($numrecords)->get();
        }
        foreach ($data as $p) { $response[] = array("id" => $p->id, "name" => $p->site_name); }
    } else {
        $data = $sites->limit($numrecords)->get();
    }
    return response()->json($response);
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site = Sitemaster::find($id);
        return view('site-master.edit',['site' => $site]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sitemaster  = Sitemaster::find($id);
        $sitemaster->site_id = $request->site_id;
        $sitemaster->unique_site_id = $request->unique_site_id;
        $sitemaster->site_name = $request->site_name;
        $sitemaster->cluster_jc = $request->cluster_jc;
        $sitemaster->district = $request->district;
        $sitemaster->mp_zone = $request->mp_zone;
        $sitemaster->site_address = $request->site_address;
        $sitemaster->latitude = $request->latitude;
        $sitemaster->longitude = $request->longitude;
        if($request->site_type == 'Select Site Type'){
            $sitemaster->site_type = null;
        }else{
           $sitemaster->site_type = $request->site_type;   
       }
       if($request->bts == 'Select BTS'){
        $sitemaster->bts = null;
    }else{
        $sitemaster->bts = $request->bts;   
    }
    $sitemaster->site_category = $request->site_category;
    $sitemaster->battery_bank_ah = $request->battery_bank_ah;
    $sitemaster->cph = $request->cph;
    $sitemaster->indoor_bts = $request->indoor_bts;
    $sitemaster->outdoor_bts = $request->outdoor_bts;
    $sitemaster->dg1_make = $request->dg1_make;
    $sitemaster->dg2_make = $request->dg2_make;
    $sitemaster->dg1_rating_in_kva = $request->dg1_rating_in_kva;
    $sitemaster->dg2_rating_in_kva = $request->dg2_rating_in_kva;
    if($request->eb_status == 'Select EB Status'){
        $sitemaster->eb_status = null;
    }else{
       $sitemaster->eb_status = $request->eb_status;   
   }
   if($request->eb_type == 'Select EB Type'){
    $sitemaster->eb_type = null;
}else{
    $sitemaster->eb_type = $request->eb_type;   
}
$sitemaster->eb_load_kw = $request->eb_load_kw;
$sitemaster->technician_name = $request->technician_name;
$sitemaster->technician_contact2 = $request->technician_contact2;
$sitemaster->technician_contact1 = $request->technician_contact1;
$sitemaster->cluster_incharge_name = $request->cluster_incharge_name;
$sitemaster->cluster_incharge_contact1 = $request->cluster_incharge_contact1;
$sitemaster->cluster_incharge_contact2 = $request->cluster_incharge_contact2;
$sitemaster->cluster_incharge_email = $request->cluster_incharge_email;
$sitemaster->zom_name = $request->zom_name;
$sitemaster->zom_contact = $request->zom_contact;
$sitemaster->zom_email = $request->zom_email;
$sitemaster->energy_man_name = $request->energy_man_name;
$sitemaster->energy_man_contact = $request->energy_man_contact;
$sitemaster->energy_man_email = $request->energy_man_email;
$sitemaster->circle_facility_head_name = $request->circle_facility_head_name;
$sitemaster->circle_facility_head_contact = $request->circle_facility_head_contact;
$sitemaster->circle_facility_head_email = $request->circle_facility_head_email;
$sitemaster->client_id = $request->client_id;
$sitemaster->save();
return back()->with('success','Site updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Sitemaster::destroy($id);
      return back()->withStatus(__('Site successfully deleted.'));
  }
  public function import() 
  {
        //dd(request()->all());
    request()->session()->forget('siteRecordsCache');
    try {
        $import = new SiteMasterImport;
        Excel::import($import, request()->file('file'));
        return back()->with('success','Total '.$import->getRowCount().' rows imported successfully!');
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
        // if(Excel::import(new SiteMasterImport,request()->file('file'))){
        //     return back()->with('success','CSV imported successfully!');
        // }else{
        //     return back()->with('error','Something went wrong importation un-successfull!');
        // }
 }
 public function serverSideIndex(Request $request)
 {
    DB::connection()->enableQueryLog();
    $orderby = $request->input('order.0.column');
    $sort['col'] = $request->input('columns.' . $orderby . '.data');    
    $sort['dir'] = $request->input('order.0.dir');
    $query = Sitemaster::leftjoin('vendors', function($join){
        $join->on('site_master.client_id','=','vendors.id');   
    })->select('site_master.*','vendors.name','vendors.gst_no','vendors.billing_address');
        /*if(!empty($request->input('search.value'))){
            $query->where('site_master.site_id', 'like', '%'. $request->input('search.value') .'%')
            ->orWhere('beatplans.effective_date', 'like', '%'. $request->input('search.value') .'%');
        }
        if(!empty($request->input('startdate')) && !empty($request->input('enddate'))){
            $query->whereBetween('beatplans.effective_date',[$request->input('startdate'), $request->input('enddate')]);
        }*/                
        $start = $request->input('start');
        $limit = $request->input('length');
        $output['draw'] = intval($request->input('draw'));
        $output['recordsTotal'] = $query->count();
        $output['recordsFiltered'] = $output['recordsTotal'];
        $orderingTable = 'site_master';
        $output['data'] = $query->orderBy($orderingTable.'.'.$sort['col'], $sort['dir'])->take($request->input('length',10))->get();
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        return json_encode($output);
    }
}

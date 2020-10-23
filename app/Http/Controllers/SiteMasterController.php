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
        return view('v3.site-master.index',[]);
    }

    public function datatable(Request $request){
        $query  = Sitemaster::with(['client'])
        ->select('site_master.*');

        if($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)){
            $query->whereBetween('effective_date', [$request->start_date, $request->end_date]);
        }

        return \DataTables::of($query)
        ->addColumn('action', function(Sitemaster $data) {
            $html = '';
            $html .= '<a href="javascript: void(0);" class="btn btn-sm btn-clean btn-icon sModal" data-toggle="modal" data-target="#viewSiteMasterModal" site_id = "'.$data->id.'"><i class="la la-eye"></i></a>';

            $html .= '<a href="'.route('site.edit', $data->id).'" class="btn btn-sm btn-clean btn-icon" ><i class="la la-edit"></i></a>';

            $html .= '<a href="javascript: void(0);" data-href="'.route('asset.remove',$data->id).'" id="'. $data->id.'" class="delete btn btn-sm btn-clean btn-icon"><i class="la la-trash text-danger"></i></a>';
            

            return $html;
        })
        ->rawColumns(['action'])->make(true);
    }

    public function getSiteDetail(Request $request){
        $site_detail = SiteMaster::find($request->site_id);

        $html = '';
        $html .= '<tr><th>Site Id: </th><td>'.$site_detail->site_id.'</td><th>Unique Site Id: </th><td>'.$site_detail->unique_site_id.'</td></tr>';
        $html .= '<tr><th>Site Name: </th><td>'.$site_detail->site_name.'</td><th>Cluster JC: </th><td>'.$site_detail->cluster_jc.'</td></tr>';
        $html .= '<tr><th>District: </th><td>'.$site_detail->district.'</td><th>MP Zone: </th><td>'.$site_detail->mp_zone.'</td></tr>';
        $html .= '<tr><th>Site Address: </th><td>'.$site_detail->site_address.'</td><th>Latitude: </th><td>'.$site_detail->latitude.'</td></tr>';
        $html .= '<tr><th>Longitude: </th><td>'.$site_detail->longitude.'</td><th>Site Type: </th><td>'.$site_detail->site_type.'</td></tr>';
        $html .= '<tr><th>BTS: </th><td>'.$site_detail->bts.'</td><th>Site Category: </th><td>'.$site_detail->site_category.'</td></tr>';
        $html .= '<tr><th>Battery Bank Ah: </th><td>'.$site_detail->battery_bank_ah.'</td><th>CPH: </th><td>'.$site_detail->cph.'</td></tr>';
        $html .= '<tr><th>Indoor BTS: </th><td>'.$site_detail->indoor_bts.'</td><th>Outdoor BTS: </th><td>'.$site_detail->outdoor_bts.'</td></tr>';
        $html .= '<tr><th>DG1 Make: </th><td>'.$site_detail->dg1_make.'</td><th>DG2 Make: </th><td>'.$site_detail->dg2_make.'</td></tr>';
        $html .= '<tr><th>DG1 Rating In KVA: </th><td>'.$site_detail->dg1_rating_in_kva.'</td><th>DG2 Rating In KVA: </th><td>'.$site_detail->dg2_rating_in_kva.'</td></tr>';
        $html .= '<tr><th>EB Status: </th><td>'.$site_detail->eb_status.'</td><th>EB Type: </th><td>'.$site_detail->eb_type.'</td></tr>';
        $html .= '<tr><th>EB Load KW: </th><td>'.$site_detail->eb_load_kw.'</td><th>Technician Name: </th><td>'.$site_detail->technician_name.'</td></tr>';
        $html .= '<tr><th>Technician Contact2: </th><td>'.$site_detail->technician_contact2.'</td><th>Technician Contact1: </th><td>'.$site_detail->technician_contact1.'</td></tr>';
        $html .= '<tr><th>Cluster Incharge Name: </th><td>'.$site_detail->cluster_incharge_name.'</td><th>Cluster Incharge Contact1: </th><td>'.$site_detail->cluster_incharge_contact1.'</td></tr>';
        $html .= '<tr><th>Cluster Incharge Contact2: </th><td>'.$site_detail->cluster_incharge_contact2.'</td><th>Cluster Incharge Email: </th><td>'.$site_detail->cluster_incharge_email.'</td></tr>';
        $html .= '<tr><th>Zom Name: </th><td>'.$site_detail->zom_name.'</td><th>Zom Contact: </th><td>'.$site_detail->zom_contact.'</td></tr>';
        $html .= '<tr><th>Zom Email: </th><td>'.$site_detail->zom_email.'</td><th>Energy Man Name: </th><td>'.$site_detail->energy_man_name.'</td></tr>';
        $html .= '<tr><th>Energy Man Contact: </th><td>'.$site_detail->energy_man_contact.'</td><th>Energy Man Email: </th><td>'.$site_detail->energy_man_email.'</td></tr>';
        $html .= '<tr><th>Circle Facility Head Name: </th><td>'.$site_detail->circle_facility_head_name.'</td><th>Circle Facility Head Contact: </th><td>'.$site_detail->circle_facility_head_contact.'</td></tr>';
        $html .= '<tr><th>Circle Facility Head Email: </th><td>'.$site_detail->circle_facility_head_email.'</td><!--th>client_id: </th><td>'.$site_detail->client_id.'</td--></tr>';
        return response()->json($html);
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
        $site = Sitemaster::with(['client'])->find($id);
        return view('v3.site-master.edit',['site' => $site]);
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
        return response()->json('deleted');
    }
    public function import() 
    {
        request()->session()->forget('siteRecordsCache');
        try {
            $import = new SiteMasterImport;
            Excel::import($import, request()->file('file'));
         
            if($import->getRowCount()){
                
                return response()->json(['status' => '1', 'message' => 'file imported!']);
            }else{
                    
                return response()->json(['status' => '0', 'message' => 'Either Zone or Client Name does not exist in master database !']);
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
              // return back()->with('error',$error);
            return response()->json(['status' => 'ok!', 'message' => $error]);
         }
            
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

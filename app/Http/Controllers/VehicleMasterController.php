<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehiclemaster;
use App\Trips;
use App\TripData;
use App\VehicleStatus;
use App\VehicleRunData;
use App\VehicleAgreement;
use App\Helpers\Helper;
use App\Vendor;
use Illuminate\Support\Facades\DB;

class VehicleMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->type == 'subadmin') {
            $vehicles = Vehiclemaster::where('created_by_id','=',auth()->user()->id)->paginate(10);
        }else{
            $vehicles = Vehiclemaster::paginate(10);
        }
        return view('vehicle.index',['vehicles'=>$vehicles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('v3.vehicle.create',['vendor_id'=>null]);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle  = new Vehiclemaster;
        if($request->vendor_id !== null){
            $vehicle->vendor_id = $request->input('vendor_id');
        }else{
            $vehicle->vendor_id = auth()->user()->vendor->id;
        }
        $vehicle->vehicle_no = strtoupper($request->vehicle_no);
        if($request->hasFile('rc_doc')){
            $vehicle->rc_doc = $request->file('rc_doc')->store('certificate');
        }
        $vehicle->insurance_no = strtoupper($request->insurance_no);
        if($request->hasFile('insurance_doc')){
            $vehicle->insurance_doc = $request->file('insurance_doc')->store('insurance');
        }
        $vehicle->insurance_upto = $request->insurance_upto;
        $vehicle->fitness_cert_no = strtoupper($request->fitness_cert_no);
        if($request->hasFile('fitness_cert_doc')){
            $vehicle->fitness_cert_doc = $request->file('fitness_cert_doc')->store('certificate');
        }
        $vehicle->fitness_cert_upto = $request->fitness_cert_upto;
        $vehicle->permit_no = strtoupper($request->permit_no);
        if($request->hasFile('permit_doc')){
            $vehicle->permit_doc = $request->file('permit_doc')->store('certificate');
        }
        $vehicle->permit_upto = $request->permit_upto;
        $vehicle->created_by_id = auth()->user()->id;
        $vehicle->save();
        if($request->vendor_id !== null){
            return redirect('vendor/vendors')->with('success','Vendor created and Vehicle added done!');
        }else{
            return redirect('master/all-vehicles')->with('success','Vehicle added successfully!');   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->type == 'vendor') {
            $vehicle = Vehiclemaster::where(['id'=>$id,'vendor_id'=>auth()->user()->vendor->id])->firstOrFail();
        }elseif(auth()->user()->type == 'subadmin') {
            $vehicle = Vehiclemaster::find($id);
        }else{
            abort(404, 'Whatever you were looking for, look somewhere else');
        }
        return view('v3.vehicle.edit',['vehicle' => $vehicle]);
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
        if(auth()->user()->type != 'vendor' && auth()->user()->type != 'subadmin'){
            abort(404, 'Whatever you were looking for, look somewhere else');
        }
        $vehicle  = Vehiclemaster::find($id);
        if($request->vendor_id !== null){
            $vehicle->vendor_id = $request->input('vendor_id');
        }
        $vehicle->vehicle_no = $request->vehicle_no;
        if($request->hasFile('rc_doc')){
            $vehicle->rc_doc = $request->file('rc_doc')->store('certificate');
        }
        $vehicle->insurance_no = $request->insurance_no;
        if($request->hasFile('insurance_doc')){
            $vehicle->insurance_doc = $request->file('insurance_doc')->store('insurance');
        }
        $vehicle->insurance_upto = $request->insurance_upto;
        $vehicle->fitness_cert_no = $request->fitness_cert_no;
        if($request->hasFile('fitness_cert_doc')){
            $vehicle->fitness_cert_doc = $request->file('fitness_cert_doc')->store('certificate');
        }
        $vehicle->fitness_cert_upto = $request->fitness_cert_upto;
        $vehicle->permit_no = $request->permit_no;
        if($request->hasFile('permit_doc')){
            $vehicle->permit_doc = $request->file('permit_doc')->store('certificate');
        }
        $vehicle->permit_upto = $request->permit_upto;
        $vehicle->created_by_id = auth()->user()->id;
        $vehicle->save();
        if($request->vendor_id !== null){
            return redirect('master/all-vehicles')->with('success','Vehicle Updated successfully!'); 
        }else{
            return redirect('vendors/vendor')->with('success','Vehicle Updated successfully!');   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vehiclemaster::destroy($id);
        return back()->withStatus(__('Vehicle successfully deleted.'));
    }
    public function vehicleForTrip(Request $request,Vehiclemaster $vehicle)
    {
        $response = [];$numrecords = 10;
        if ($request->has('name')) {
            $search = $request->name;
            if(auth()->user()->type == 'subadmin'){
                $data = $vehicle->where('vehicle_no', 'LIKE', "%{$search}%")->where(['created_by_id' => auth()->user()->id])->limit($numrecords)->get();
            }elseif (auth()->user()->type == 'mis') {
                $data = $vehicle->where('vehicle_no', 'LIKE', "%{$search}%")->where(['created_by_id' => auth()->user()->created_by_id])->limit($numrecords)->get();
            }
            foreach ($data as $p) { $response[] = array("id" => $p->id, "name" => $p->vehicle_no); }
        } else {
            $data = $vehicle->limit($numrecords)->get();
        }
        return response()->json($response);
    }
    public function allVehicles(){
        if(auth()->user()->type == 'subadmin' || auth()->user()->type == 'mis'){
            return view('v3.vehicle.vehicle-tab');
        }else{
            return view('v3.vehicle.vendor-vehicle');
        }
    }
    public function vehicleTripsDetails($vehicleId='')
    {

        if (isset($vehicleId) && !empty($vehicleId)) {
            if(auth()->user()->type == 'subadmin'){
                $trips = Trips::where('vehicle_id','=',$vehicleId)->get();
                return view('v3.vehicle.trip-details');
                /*return view('vehicle.trip-details',['trips'=>$trips]);   */
            }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
                $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
                $trips = Trips::whereHas('beat_plan',function($q) use($allotedData){
                    if (isset($allotedData) && !empty($allotedData)) {
                        $i = 1;
                        foreach ($allotedData as $key ) {
                            if ($i == 1) {
                                $q->where(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);  
                            }else{
                                $q->orWhere(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);  
                            }
                            $i++;
                        }
                    }  
                })->where('vehicle_id','=',$vehicleId)->get();
                /*return view('vehicle.trip-details',['trips'=>$trips]);   */
                return view('v3.vehicle.trip-details');
            }
        }
    }
    public function vehicleTripsData($tripId='')
    {
        if (isset($tripId) && !empty($tripId)) {
            return view('v3.vehicle.trip-data');
        }
    }
    public function vehicle_status(Request $request, $vehicle_id){
        if(auth()->user()->type != 'vendor' && auth()->user()->type != 'subadmin'){
            abort(404, 'Whatever you were looking for, look somewhere else');
        }
        $vehicle_status  = VehicleStatus::where('vehicle_id', $vehicle_id)->orderBy('id', 'DESC')->first();
        if(isset($vehicle_status) && !empty($vehicle_status)){
            return view('v3.vehicle.vehicle-status', compact('vehicle_status'));
        }else{
            return redirect('master/all-vehicles')->with('error','No status found for this vehicle!');
        }
    }

    public function vehicle_run_data(Request $request, $vehicle_id){
        if(auth()->user()->type != 'vendor' && auth()->user()->type != 'subadmin'){
            abort(404, 'Whatever you were looking for, look somewhere else');
        }
        $vendor = auth()->user()->vendor;
        $vm     = Vehiclemaster::where(['vendor_id'=> $vendor->id, 'id' => $vehicle_id ])->first();
        
        if(!$vm){
            abort(404, 'Whatever you were looking for, look somewhere else');
        }
        $run_data  = VehicleRunData::where('vehicle_id', $vehicle_id)->paginate(10);
        $total_km  = VehicleRunData::where('vehicle_id', $vehicle_id)->sum('passed_reading');
        // return view('vehicle.vehicle_run_data', compact('run_data','total_km'));
        return view('v3.vehicle.vehicle-run-data', compact('run_data','total_km'));
    }

    public function vehicle_trip_data(Request $request){

        if(!$request->vehicle_id && !$request->trip_id){
            abort(404, 'Whatever you were looking for, look somewhere else');
        }

        $vendor = auth()->user()->vendor;
        $vm     = Vehiclemaster::where(['vendor_id'=> $vendor->id, 'id' => $request->vehicle_id])->first();
        
        if(!$vm){
            abort(404, 'Whatever you were looking for, look somewhere else');
        }

        $trip = Trips::where(['vehicle_id'=> $request->vehicle_id, 'id' => $request->trip_id ])->first();

       // return dd($trip);
        if(!$trip){
            abort(404, 'Whatever you were looking for, look somewhere else');
        }
        $trips = TripData::where('trip_id', $trip->id)->get();               
        return view('vehicle.trip-data',compact('trips'));   
    }

    public function get_agreement(Request $request){
        $agreement = VehicleAgreement::where(['vehicle_id' => $request->vehicle_id])->first();
        return response()->json($agreement);
    }

    public function vehicle_update_agreement(Request $request){
        $agreement = VehicleAgreement::firstOrNew(['vehicle_id' => $request->vehicle_id]);
        $agreement->vehicle_id = $request->vehicle_id;
        $agreement->average = $request->average;
        $agreement->rental = $request->rental;
        $agreement->salary_by = $request->salary_by;
        $agreement->save();
        return response()->json('success');
    }
    public function allVehiclesTable(Request $request)
    {
        $columnsDefault = [];
        $alldata = array();
        if(auth()->user()->type == 'subadmin'){
         $columnsDefault = [    
            'vehicle_number' => true,      
            'action' => true,      
        ];
        $returndata = Vehiclemaster::where('created_by_id','=',auth()->user()->id)->get();
        if(isset($returndata) && !empty($returndata)){
            $i = 0;
            foreach($returndata as $key){
                $alldata[$i]['vehicle_number'] = $key->vehicle_no;
                $alldata[$i]['action'] = '<a href="'.route('trips-details',$key->id).'" class="btn btn-sm btn-clean btn-icon" title="View Trips"><i class="la la-eye text-success"></i></a><a href="javascript:void(0);" onclick="contractModal('.$key->id.')" class="btn btn-sm btn-clean btn-icon" title="Update Contract"><i class="la la-file-contract text-success"></i></a>';
                $i++;
            }
        }
    }elseif (auth()->user()->type == 'vendor') {
        $columnsDefault = [    
            'vehicle_number' => true,      
            'rc_doc' => true,      
            'insurance_no' => true,      
            'insurance_doc' => true,      
            'insurance_upto' => true,
            'fitness_cert_no' => true,     
            'fitness_cert_doc' => true,      
            'fitness_cert_upto' => true,      
            'permit_no' => true,      
            'permit_doc' => true,      
            'permit_upto' => true,      
            'created_at' => true,   
            'action' => true,      
        ];
        $vehicles = Vehiclemaster::where('vendor_id','=',auth()->user()->vendor->id)->get();
        if(isset($vehicles) && !empty($vehicles)){
            $i = 0;
            foreach($vehicles as $key){
                $alldata[$i]['vehicle_number'] = $key->vehicle_no;
                $alldata[$i]['rc_doc'] = $key->rc_doc ?? 'NA';
                $alldata[$i]['insurance_no'] = $key->insurance_no;
                $alldata[$i]['insurance_doc'] = $key->insurance_doc ?? 'NA';
                $alldata[$i]['insurance_upto'] = $key->insurance_upto;
                $alldata[$i]['fitness_cert_no'] = $key->fitness_cert_no;
                $alldata[$i]['fitness_cert_doc'] = $key->fitness_cert_doc ?? 'NA';
                $alldata[$i]['fitness_cert_upto'] = $key->fitness_cert_upto;
                $alldata[$i]['permit_no'] = $key->permit_no;
                $alldata[$i]['permit_doc'] = $key->permit_doc ?? 'NA';
                $alldata[$i]['permit_upto'] = $key->permit_upto;
                $alldata[$i]['created_at'] = \Carbon\Carbon::parse($key->created_at)->format('d-m-Y');
                $alldata[$i]['action'] = '<a href="'.route('vehicle.edit',$key->id).'" class="btn btn-sm btn-clean btn-icon" title="Update vehicle"><i class="la la-pencil text-warning"></i></a><a href="'.route('vehicle-status-vendor',$key->id).'" class="btn btn-sm btn-clean btn-icon" title="Current Status"><i class="la la-road text-success"></i></a><a href="'.route('vehicle-run-data',$key->id).'" class="btn btn-sm btn-clean btn-icon" title="Run data"><i class="la la-bus text-primary"></i></a>';
                $i++;
            }
        }
    }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
     $columnsDefault = [    
        'vehicle_number' => true,      
        'action' => true,      
    ];
    $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
    $returndata = Trips::leftjoin('vehicle_master', 'vehicle_master.id', '=', 'trips.vehicle_id')->whereHas('beat_plan',function($q) use($allotedData){
        if (isset($allotedData) && !empty($allotedData)) {
            $i = 1;
            foreach ($allotedData as $key ) {
                if ($i == 1) {
                    $q->where(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);  
                }else{
                    $q->orWhere(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);  
                }
                $i++;
            }
        }  
    })->groupBy('vehicle_master.id')->get();
    if(isset($returndata) && !empty($returndata)){
        $i = 0;
        foreach($returndata as $key){
            $alldata[$i]['vehicle_number'] = $key->vehicle_no;
            $alldata[$i]['action'] = '<a href="'.route('trips-details',$key->id).'" class="btn btn-sm btn-clean btn-icon" title="View Trips"><i class="la la-eye text-success"></i></a>';
            $i++;
        }
    }
}
$data = [];
foreach ( $alldata as $d ) {
    $data[] = Helper::filterArray( $d, $columnsDefault );
}
$totalRecords = $totalDisplay = count( $data );
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
if ( isset( $_REQUEST['length'] ) ) {
    $data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
}
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
public function vehicleTrips(Request $request)
{
    $returndata = [];
    $columnsDefault = [    
        'trip_id' => true,      
        'action' => true,      
    ];
    $alldata = array();
    if(auth()->user()->type == 'subadmin'){
        $returndata = Trips::where('vehicle_id','=',$request->vehicleId)->get();
    }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
        $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
        $returndata = Trips::whereHas('beat_plan',function($q) use($allotedData){
            if (isset($allotedData) && !empty($allotedData)) {
                $i = 1;
                foreach ($allotedData as $key ) {
                    if ($i == 1) {
                        $q->where(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);  
                    }else{
                        $q->orWhere(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);  
                    }
                    $i++;
                }
            }  
        })->where('vehicle_id','=',$request->vehicleId)->get();
    }
    if(isset($returndata) && !empty($returndata)){
        $i = 0;
        foreach($returndata as $key){
            $alldata[$i]['trip_id'] = $key->trip_id;
            $alldata[$i]['action'] = '<a href="'.route('trips-data',$key->id).'" class="btn btn-sm btn-clean btn-icon" title="View Trip Data"><i class="la la-eye text-success"></i></a>';
            $i++;
        }
    }
    $data = [];
    foreach ( $alldata as $d ) {
        $data[] = Helper::filterArray( $d, $columnsDefault );
    }
    $totalRecords = $totalDisplay = count( $data );
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
    if ( isset( $_REQUEST['length'] ) ) {
        $data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
    }
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
public function vehicleTripDetails(Request $request)
{
 $returndata = [];
 $columnsDefault = [    
    'trip_id' => true,     
    'site_id' => true,      
    'site_name' => true,      
    'technician_name' => true,  
    'technician_contact' => true,  
    'quantity' => true,  
    'ro' => true,  
    'loading_status' => true,  
    'loading_date' => true,  
    'loading_start' => true,  
    'loading_finish' => true,  
    'filling_status' => true,  
    'filling_date' => true,  
    'site_in' => true,  
    'site_out' => true,    
    'remark' => true      
];
$alldata = array();
if(auth()->user()->type == 'subadmin'){
    $returndata = TripData::where('trip_data.trip_id','=',$request->tripId)->get();
}elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
    $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
    $returndata = TripData::whereHas('plan',function($q) use($allotedData){
        if (isset($allotedData) && !empty($allotedData)) {
            $i = 1;
            foreach ($allotedData as $key ) {
                if ($i == 1) {
                    $q->where(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);  
                }else{
                    $q->orWhere(['mp_zone' => $key->zone, 'client_id' => $key->client, 'added_by' => auth()->user()->created_by_id]);  
                }
                $i++;
            }
        }  
    })->where('trip_id','=',$request->tripId)->get();
}
if(isset($returndata) && !empty($returndata)){
    $i = 0;
    foreach($returndata as $key){
        $remark = '';
        if($key){
            if($key->divert_from_tripdata_id){
                if($key->beat_plan_data()->check_divert($key->divert_from_tripdata_id)){
                    if(($key->beat_plan_data()->site_data('from')))
                    $remark .= 'Diverted From: '.$key->beat_plan_data()->site_data('from')->site_name;
                }
            }if($key->divert_to_tripdata_id){
                if($key->beat_plan_data()->check_divert($key->divert_to_tripdata_id)){
                    if(($key->beat_plan_data()->site_data('to')))
                    $remark .= 'Diverted To: '.$key->beat_plan_data()->site_data('to')->site_name;
                }
            }if($key->divert_qty){
                if($key->beat_plan_data()->check_divert($key->divert_to_tripdata_id) || $key->beat_plan_data()->check_divert($key->divert_from_tripdata_id)){
                    $remark .= 'Qty: '.$key->divert_qty;
                }
            }
        }
        $remark .= $key->remarks;
        $alldata[$i]['trip_id'] = $key->trip->trip_id;     
        $alldata[$i]['site_id'] = $key->site_data($key->data_id)->site_id;      
        $alldata[$i]['site_name'] = $key->site_data($key->data_id)->site_name;      
        $alldata[$i]['technician_name'] = $key->site_data($key->data_id)->technician_name;  
        $alldata[$i]['technician_contact'] = $key->site_data($key->data_id)->technician_contact1;  
        $alldata[$i]['quantity'] = !empty($key->quantity()) ? $key->quantity()['quantity'] : '';  
        $alldata[$i]['ro'] = $key->trip->vendor->name;  
        $alldata[$i]['loading_status'] = $key->status;  
        $alldata[$i]['loading_date'] = $key->loading_start?date('d-m-Y',strtotime($key->loading_start)):'';  
        $alldata[$i]['loading_start'] = $key->loading_start?date('H:i',strtotime($key->loading_start)):'';  
        $alldata[$i]['loading_finish'] = $key->loading_finish?date('H:i',strtotime($key->loading_finish)):'';  
        $alldata[$i]['filling_status'] = '';  
        $alldata[$i]['filling_date'] = $key->filling_start;  
        $alldata[$i]['site_in'] = $key->site_in;  
        $alldata[$i]['site_out'] = $key->site_out;    
        $alldata[$i]['remark'] = $remark;      
        $i++;
    }
}
// dd($alldata);
$data = [];
foreach ( $alldata as $d ) {
    $data[] = Helper::filterArray( $d, $columnsDefault );
}
$totalRecords = $totalDisplay = count( $data );
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
if ( isset( $_REQUEST['length'] ) ) {
    $data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
}
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

public function vehicleRunStatus(Request $request)
{
 $columnsDefault = [      
    'effective_date' => true,      
    'site_id' => true,      
    'site_name' => true,      
    'site_category' => true,      
    'technician_name' => true,  
    'technician_contact' => true,
    'qty' => true,      
    'status' => true,     
];
$alldata = array();
$vehicle_status = VehicleStatus::where('vehicle_id', $request->vehicle_id)->orderBy('id', 'DESC')->first();
if(isset($vehicle_status->trip->trip_data) && !empty($vehicle_status->trip->trip_data)){
    $i = 0;
    foreach($vehicle_status->trip->trip_data as $trip_data){
        $alldata[$i]['effective_date'] = $vehicle_status->trip->effective_date;     
        $alldata[$i]['site_id'] = $trip_data->site->site_id;      
        $alldata[$i]['site_name'] = $trip_data->site->site_name;      
        $alldata[$i]['site_category'] = $trip_data->site->site_category;      
        $alldata[$i]['technician_name'] = $trip_data->site->technician_name;  
        $alldata[$i]['technician_contact'] = $trip_data->site->technician_contact1 ?? $trip_data->site->technician_contact2;  
        $alldata[$i]['qty'] = $trip_data->beat_plan_data()?$trip_data->beat_plan_data()->quantity:'';  
        $alldata[$i]['status'] = $trip_data->status;      
        $i++;
    }
}
$data = [];
foreach ( $alldata as $d ) {
    $data[] = Helper::filterArray( $d, $columnsDefault );
}
$totalRecords = $totalDisplay = count( $data );
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
if ( isset( $_REQUEST['length'] ) ) {
    $data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
}
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

public function VehicleRunData(Request $request)
{
    $run_data = VehicleRunData::where('vehicle_id', $request->vehicle_id)->get();
    $columnsDefault = [      
        'trip_id' => true,      
        'vehicle_number' => true,      
        'effective_date' => true,      
        'client' => true,      
        'km' => true,  
        'action' => true,  
    ];
    $alldata = array();
    if(isset($run_data) && !empty($run_data)){
        $i = 0;
        foreach($run_data as $data){
            $alldata[$i]['trip_id'] = '<a href="'.route('vehicle-trip-data').'?trip_id='.$data->trip_id.'&vehicle_id='.$data->vehicle_id.'" class="btn btn-sm btn-clean btn-icon">'.$data->trip->trip_id.'</a>';     
            $alldata[$i]['vehicle_number'] = $data->vehicle->vehicle_no;      
            $alldata[$i]['effective_date'] = $data->trip->effective_date;      
            $alldata[$i]['client'] = $data->beatplan->client->name;      
            $alldata[$i]['km'] = $data->passed_reading;  
            $alldata[$i]['action'] = 'Under process';  
            $i++;
        }
    }
    $data = [];
    foreach ( $alldata as $d ) {
        $data[] = Helper::filterArray( $d, $columnsDefault );
    }
    $totalRecords = $totalDisplay = count( $data );
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
    if ( isset( $_REQUEST['length'] ) ) {
        $data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
    }
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
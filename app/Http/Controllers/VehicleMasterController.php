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
       return view('vehicle.create',['vendorId' => null]);
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
            return redirect('vendor/vendors');
        }else{
            return back()->with('success','Vehicle added successfully!');   
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
        return view('vehicle.edit',['vehicle' => $vehicle]);
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
            return back()->with('success','Vehicle Updated successfully!'); 
        }else{
            return back()->with('success','Vehicle added successfully!');   
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
        if(auth()->user()->type == 'subadmin'){
            $vehicles = Vehiclemaster::where('created_by_id','=',auth()->user()->id)->paginate(10);
            return view('vehicle.vehicle-tab',['vehicles'=>$vehicles]);
        }elseif (auth()->user()->type == 'vendor') {
            $vehicles = Vehiclemaster::where('vendor_id','=',auth()->user()->vendor->id)->get();
            return view('vehicle.vendor_vehicle',['vehicles'=>$vehicles]);
        }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
            $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
            $vehicles = Trips::leftjoin('vehicle_master', 'vehicle_master.id', '=', 'trips.vehicle_id')->whereHas('beat_plan',function($q) use($allotedData){
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
            })->groupBy('vehicle_master.id')->paginate(10);
            //dd($vehicles);
            return view('vehicle.vehicle-tab',['vehicles'=>$vehicles]);
        }
    }
    public function vehicleTripsDetails($vehicleId='')
    {
        if (isset($vehicleId) && !empty($vehicleId)) {
            if(auth()->user()->type == 'subadmin'){
                $trips = Trips::where('vehicle_id','=',$vehicleId)->get();
                return view('vehicle.trip-details',['trips'=>$trips]);   
            }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id == null) {
                $allotedData = Helper::allotedZonesAndClientId(auth()->user()->id);
                //$trips = Trips::where('vehicle_id','=',$vehicleId)->get();
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
                return view('vehicle.trip-details',['trips'=>$trips]);   
            }
        }
    }
    public function vehicleTripsData($tripId='')
    {
        if (isset($tripId) && !empty($tripId)) {
            /*$trips = TripData::with('beat_plan_data')->leftjoin('trips', function($join){
                $join->on('trips.id','=','trip_data.trip_id');
            })->leftjoin('vendors', function($join){
                $join->on('vendors.id','=','trips.loading_point_id');
            })->where('trip_data.trip_id','=',$tripId)->select('vendors.name as roname','trips.trip_id as uniquetripid','trip_data.data_id','trip_data.status','trip_data.loading_start','trip_data.loading_finish','trip_data.site_in','trip_data.site_out','trip_data.remarks','trip_data.filling_start')->get();*/

            $trips = TripData::where('trip_data.trip_id','=',$tripId)
            ->get();
            return view('vehicle.trip-data',['trips'=>$trips]);   
        }
    }

    public function vehicle_status(Request $request, $vehicle_id){
        /*$client = new \GuzzleHttp\Client();

        $result = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json',
            [
                'query' => [
                        'latlng' => '44.4647452,7.3553838',
                        'key' => 'AIzaSyB_aaYKAvDUt155kQaWXYqx0PUSXk5EEk4'
                ],
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ]
         );



        $response = $result->getBody()->getContents();
        dd($response);*/
        if(auth()->user()->type != 'vendor' && auth()->user()->type != 'subadmin'){
            abort(404, 'Whatever you were looking for, look somewhere else');
        }

        $vehicle_status  = VehicleStatus::where('vehicle_id', $vehicle_id)->orderBy('id', 'DESC')->first();

        return view('vehicle.vehicle_status', compact('vehicle_status'));
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
        return view('vehicle.vehicle_run_data', compact('run_data','total_km'));
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
}
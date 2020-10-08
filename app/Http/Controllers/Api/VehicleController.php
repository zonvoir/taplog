<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehiclemaster;
use App\Trips;
use App\TripData;
use App\Misallottedzones;

class VehicleController extends Controller
{
    public function getVehicleStatusBYId(Request $request)
    {
        if ($request->id) {
            $data = Vehiclemaster::find($request->id);
            return response()->json([
                'status' => 'Ok',
                'message' => 'Vehicle Status found!',
                'details' => $data
            ]);
        }
    }
    public function getAllVehicleList(Vehiclemaster $vehicle)
    {
        $data = [];
        if(auth()->user()->type == 'subadmin'){
            $data = $vehicle->where(['created_by_id' => auth()->user()->id])->select('id','vehicle_no')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All vehicle list!',
                'details' => $data
            ]); 
        }elseif (auth()->user()->type == 'mis') {
            $allotedData = Misallottedzones::where('mis_user_id','=',auth()->user()->id)->first();
            if (isset($allotedData) && !empty($allotedData)) {
                $data = Trips::leftjoin('beatplans', function($q){
                    $q->on('beatplans.id','=','trips.beatplan_id');
                })->leftjoin('vehicle_master', function($q){
                    $q->on('vehicle_master.id','=','trips.vehicle_id');
                })->where(['trips.added_by' => auth()->user()->id, 'beatplans.mp_zone' => $allotedData['mp_zones'], 'beatplans.client_id' => $allotedData['allotted_client_id']])->orWhere(function($q) use ($allotedData){
                    $q->where(['trips.added_by' => auth()->user()->created_by_id, 'beatplans.mp_zone' => $allotedData['mp_zones'], 'beatplans.client_id' => $allotedData['allotted_client_id']]);
                })->select('vehicle_master.id','vehicle_master.vehicle_no')->groupBy('vehicle_master.id')->get();
            }
            return response()->json([
                'status' => 'Ok',
                'message' => 'All vehicle list!',
                'details' => $data
            ]); 
        }
    }
    public function vehicleTripsDetails(Request $request)
    {
        if($request->vehicleId) {
            $trips = Trips::with('vechile')->where('vehicle_id','=',$request->vehicleId)->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All Trips of vehicle!',
                'details' => $trips
            ]); 
        }
    }
    public function vehicleTripsData(Request $request)
    {
        if ($request->tripId) {
            $trips = TripData::leftjoin('trips', function($join){
                $join->on('trips.id','=','trip_data.trip_id');
            })->leftjoin('vendors', function($join){
                $join->on('vendors.id','=','trips.loading_point_id');
            })->leftjoin('users as driver', function($join){
                $join->on('driver.id','=','trips.driver_id');
            })->leftjoin('users as filler', function($join){
                $join->on('filler.id','=','trips.filler_id');
            })->leftjoin('beatplan_data', function($join){
                $join->on('beatplan_data.beatplan_id','=','trip_data.beatplan_id')
                ->on('beatplan_data.site_id', '=', 'trip_data.data_id');
            })->leftjoin('site_master', function($join){
                $join->on('site_master.id','=','trip_data.data_id');
            })->where('trip_data.trip_id','=',$request->tripId)->select('vendors.name as roname','trips.trip_id as uniquetripid','trip_data.data_id','trip_data.status','trip_data.loading_start','trip_data.loading_finish','trip_data.site_in','trip_data.site_out','trip_data.remarks','trip_data.filling_start','site_master.site_id','beatplan_data.quantity','site_master.technician_name','site_master.technician_contact1','site_master.site_name','filler.name as fillerName','filler.contact as fillerContact','driver.name as driverName','driver.contact as driverContact')->get();   
            return response()->json([
                'status' => 'Ok',
                'message' => 'All Trips data list of vehicle!',
                'details' => $trips
            ]); 
        }
    }
}

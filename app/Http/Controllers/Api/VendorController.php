<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vendor;

class VendorController extends Controller
{
    public function getClientList(Request $request,Vendor $vendors)
    {
        if(auth()->user()->type == 'subadmin'){
            $data = $vendors->where(['type'=>'client','created_by_id'=>auth()->user()->id])->select('name','id')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All client',
                'details' => $data
            ]);
        }elseif (auth()->user()->type == 'mis') {
            $data = $vendors->where(['type'=>'client','created_by_id'=>auth()->user()->created_by_id])->select('name','id')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All client',
                'details' => $data
            ]);
        }
    }
    public function getAllPumpVendorList(Vendor $vendors)
    {
        if(auth()->user()->type == 'subadmin'){
            $data = $vendors->where(['type'=>'vendor','vendor_category'=>'PUMP','created_by_id'=>auth()->user()->id])->select('name','id')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All vendor pump',
                'details' => $data
            ]);
        }elseif (auth()->user()->type == 'mis') {
            $data = $vendors->where(['type'=>'vendor','vendor_category'=>'PUMP','created_by_id'=>auth()->user()->created_by_id])->select('name','id')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All vendor pump',
                'details' => $data
            ]);
        }   
    }
    public function updateLiveLocation(Request $request)
    {
        if ($request->has('vendorId')) {
            $map = Vendor::find($request->vendorId);
            $map->latitute = $request->latitude;
            $map->longitude = $request->longitude;
            if ($map->save()) {
                return response()->json([
                    'status' => 'Ok',
                    'message' => 'Location Updated!',
                    'details' => []
                ]);     
            }else{
                return response()->json([
                    'status' => 'Not Ok',
                    'message' => 'Location not Updated!',
                    'details' => []
                ]); 
            }       
        }
    }
}

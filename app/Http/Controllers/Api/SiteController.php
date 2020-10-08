<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sitemaster;

class SiteController extends Controller
{
    public function sitesList(Request $request)
    {
        //if(auth()->user()->type == 'subadmin'){
        if(1){
            $data = '';
            if($request->clientId && $request->zone == ''){
                $data = Sitemaster::where(['client_id'=>$request->clientId, 'created_by_id'=>auth()->user()->id])->get();
            }
            elseif(!$request->has('clientId') && $request->has('zone')){
                $data = Sitemaster::where(['mp_zone'=>$request->zone, 'created_by_id'=>auth()->user()->id])->get();
            }
            else{
                $data = Sitemaster::where(['client_id'=>$request->clientId, 'mp_zone'=>$request->zone, 'created_by_id'=>auth()->user()->id])->get();
            }
            return response()->json([
                'status' => 'Ok',
                'message' => 'Success',
                'details' => $data
            ]);
        }else{
            return response()->json([
                'status' => 'Not Ok',
                'message' => 'You are not Authorized!',
                'details' => null
            ]);
        }
    }
    public function getAllZones(Request $request)
    {
        if(auth()->user()->type == 'subadmin'){
            $sites = Sitemaster::where(['created_by_id'=>auth()->user()->id])->select('mp_zone')->groupBy('mp_zone')->get();
            return response()->json([
                'status' => 'ok',
                'message' => 'All zones',
                'details' => $sites
            ]);
        }elseif (auth()->user()->type == 'mis') {
            $sites = Sitemaster::where(['created_by_id'=>auth()->user()->created_by_id])->select('mp_zone')->groupBy('mp_zone')->get();
            return response()->json([
                'status' => 'ok',
                'message' => 'All zones',
                'details' => $sites
            ]);
        }
    }
    public function siteListForPlan__Backup(Request $request, Sitemaster $sites)
    {
        if(auth()->user()->type == 'subadmin'){
            $sites = Sitemaster::where(['created_by_id' => auth()->user()->id, 'mp_zone' => $request->zone, 'client_id' => $request->clientId ])->select('id','site_id','site_name')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All sites',
                'details' => $sites
            ]);
        }elseif (auth()->user()->type == 'mis') {
            $sites = Sitemaster::where(['created_by_id' => auth()->user()->created_by_id, 'mp_zone' => $request->zone, 'client_id' => $request->clientId ])->select('id','site_id','site_name')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All sites',
                'details' => $sites
            ]);
        }
    }
    public function siteListForPlan(Request $request, Sitemaster $sites)
    {
        $response = [];$numrecords = 10;
        if ($request->has('name')) {
            $search = $request->name;
            if(auth()->user()->type == 'subadmin'){
                $data = $sites->where('site_id', 'LIKE', "%{$search}%")->where(['created_by_id' => auth()->user()->id, 'mp_zone' => $request->zone, 'client_id' => $request->clientId ])->limit($numrecords)->get();
            }elseif (auth()->user()->type == 'mis') {
                $data = $sites->where('site_id', 'LIKE', "%{$search}%")->where(['created_by_id' => auth()->user()->created_by_id, 'mp_zone' => $request->zone, 'client_id' => $request->clientId ])->limit($numrecords)->get();
            }
            foreach ($data as $p) { 
                $response[] = array("id" => $p->id, "site_id" => $p->site_id, "site_name" => $p->site_name); 
            }
        }else{
            $data = $sites->limit($numrecords)->get();
        }
        return response()->json($response);
    }
}

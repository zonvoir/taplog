<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Routes;

class RouteController extends Controller
{
	public function getRouteList(Request $request,Routes $route)
	{
		if(auth()->user()->type == 'subadmin'){
			$data = $route->where(['mp_zone' => $request->zone, 'added_by_id' => auth()->user()->id])->select('id','route_name')->get();
			return response()->json([
				'status' => 'Ok',
				'message' => 'All route list!',
				'details' => $data
			]); 
		}elseif (auth()->user()->type == 'mis') {
			$data = $route->where(['mp_zone' => $request->zone, 'added_by_id' => auth()->user()->created_by_id])->select('id','route_name')->get();
			return response()->json([
				'status' => 'Ok',
				'message' => 'All route list!',
				'details' => $data
			]); 
		}
	}
}

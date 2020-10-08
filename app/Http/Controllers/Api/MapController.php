<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FillerLiveMaps;

class MapController extends Controller
{
	public function updateLiveLocation(Request $request)
	{
		if (FillerLiveMaps::where('user_id','=',$request->userId)->exists()) {
			$map = FillerLiveMaps::where('user_id','=',$request->userId)->first();
			$map->latitude = $request->latitude;
			$map->longitude = $request->longitude;
			$map->accuracy = $request->accuracy;
			$map->timestamp = $request->timestamp;
			if ($map->save()) {
				return response()->json([
				'status' => 'Ok',
				'message' => 'Location Updated!',
				'details' => []
			]); 	
			}		
		}else{
			$map = new FillerLiveMaps();
			$map->latitude = $request->latitude;
			$map->longitude = $request->longitude;
			$map->accuracy = $request->accuracy;
			$map->timestamp = $request->timestamp;
			$map->user_id = $request->userId;
			if ($map->save()) {
				return response()->json([
				'status' => 'Ok',
				'message' => 'Location Created!',
				'details' => []
			]); 	
			}
		}
	}
	public function getLiveLocation(Request $request)
	{
		if ($request->has('userId')) {
			$map = FillerLiveMaps::where('user_id','=',$request->userId)->first();
			return response()->json([
				'status' => 'Ok',
				'message' => 'Location',
				'details' => $map
			]); 	
		}
	}
}

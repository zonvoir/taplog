<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Assets;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type == 'admin') {
            $assets = Assets::all();
        }if (auth()->user()->type == 'subadmin') {
            $assets = Assets::where('created_by_id','=',auth()->user()->id)->all();
        }
		$assets = Assets::all();
		if(!$assets->isEmpty()){
			return response()->json([
				'status' => 'Ok',
				'message' => 'Assets Listing',
				'details' => $assets
			]);
		}else{
			return response()->json([
				'status' => 'Ok',
				'message' => 'No List Available',
				'details' => null
			]);
		}
        
    }
}
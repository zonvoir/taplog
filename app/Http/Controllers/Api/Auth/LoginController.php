<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Trips;

class LoginController extends Controller
{
	use AuthenticatesUsers;
	protected function credentials($request)
	{
		if(is_numeric($request->get('username'))){
			return ['contact'=>$request->get('username'),'password'=>$request->get('password')];
		}
		elseif (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
			return ['email' => $request->get('username'), 'password'=>$request->get('password')];
		}
	}
	public function login(Request $request)
	{
		$credentials = $this->credentials($request);
		if(isset($credentials['contact'])){
			if (Auth::attempt(['contact' => $credentials['contact'], 'password' => $credentials['password'], 'status' => 'active'])) {
				if(auth()->user()->type == 'driver'){
					$trips = $this->driver_trip(auth()->user());
				}else{
					$trips = [];
				}
				//dd($trips);
            // Authentication passed...
				return response()->json([
					'status' => 'Ok',
					'message' => 'Authenticated',
					'id' => auth()->user()->id,
					'type' => auth()->user()->type,
					'name' => auth()->user()->name,
					'token' => auth()->user()->api_token,
					'trips' => $trips
				]);
			}else{
				return response()->json([
					'status' => 'Ok',
					'message' => 'Authentication Failed!'
				]);
			}
		}else{
			if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'status' => 'active'])) {
				if(auth()->user()->type == 'driver'){
					$trips = $this->driver_trip(auth()->user());
				}else{
					$trips = [];
				}
            // Authentication passed...
				return response()->json([
					'status' => 'Ok',
					'message' => 'Authenticated',
					'id' => auth()->user()->id,
					'type' => auth()->user()->type,
					'name' => auth()->user()->name,
					'token' => auth()->user()->api_token,
					'trips' => $trips
				]);
			}else{
				return response()->json([
					'status' => 'Ok',
					'message' => 'Authentication Failed!'
				]);
			}
		}

	}
	/* 
	$query = \DB::table('users')->where('id', 10); Str::replaceArray('?', $query->getBindings(), $query->toSql()); */
	public function driver_trip($user){
		date_default_timezone_set('Asia/Calcutta');
		$effective_date = \Carbon\Carbon::now()->format('d-m-Y');
		//dd($effective_date);
		$trip = Trips::where(['driver_id' => $user->id,'effective_date' => $effective_date])->get();
		return $trip;
	}
}
<?php

namespace App\Http\Controllers;

use App\User;
use App\Userdetails;
use App\Children;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'.$user->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    public function index(User $model)
    {
       
    }
    public function create()
    {
        return view('users.create');   
    }
    public function store(Request $request)
    {
        
    }   
    public function edit()
    {
    	$settings = Setting::pluck('meta_value', 'meta_key')->toArray();
       	return view('setting.edit', compact('settings'));   
   	}
   	public function update(Request $request)
   	{
    	foreach ($request->meta as $key => $value) {
    		$setting = Setting::firstOrNew(['meta_key' => $key]);
    		$setting->meta_key = $key;
    		$setting->meta_value = $value;
    		$setting->save();
    	}
    	return back()->withStatus(__('Setting successfully updated.'));
	}
}
<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sitemaster;

class TechController extends Controller
{
   public function index()
    {
    	$sites = Sitemaster::where(['technician_id' => auth()->user()->id])->get();
    	return view('clients.technician.index',compact('sites'));
    }
}

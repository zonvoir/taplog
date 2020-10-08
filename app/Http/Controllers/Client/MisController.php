<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MisController extends Controller
{
    public function index()
    {
    	return view('clients.mis.index');
    }
}

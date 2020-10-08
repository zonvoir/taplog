<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllDriverList(User $user)
    {
        if(auth()->user()->type == 'subadmin'){
            $data = $user->where(['created_by_id' => auth()->user()->id, 'type' => 'driver'])->select('id','name')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All vehicle list!',
                'details' => $data
            ]); 
        }elseif (auth()->user()->type == 'mis') {
            $data = $user->where(['created_by_id' => auth()->user()->created_by_id, 'type' => 'driver'])->select('id','name')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All driver list!',
                'details' => $data
            ]); 
        }
    }
    public function getAllFillerList(User $user)
    {
        if(auth()->user()->type == 'subadmin'){
            $data = $user->where(['created_by_id' => auth()->user()->id, 'type' => 'filler'])->select('id','name')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All vehicle list!',
                'details' => $data
            ]); 
        }elseif (auth()->user()->type == 'mis') {
            $data = $user->where(['created_by_id' => auth()->user()->created_by_id, 'type' => 'filler'])->select('id','name')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All filler list!',
                'details' => $data
            ]); 
        }
    }
    public function getAllFieldOfficerList(User $user)
    {
        if(auth()->user()->type == 'subadmin'){
            $data = $user->where(['created_by_id' => auth()->user()->id, 'type' => 'field_officer'])->select('id','name')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All vehicle list!',
                'details' => $data
            ]); 
        }elseif (auth()->user()->type == 'mis') {
            $data = $user->where(['created_by_id' => auth()->user()->created_by_id, 'type' => 'field_officer'])->select('id','name')->get();
            return response()->json([
                'status' => 'Ok',
                'message' => 'All field officer list!',
                'details' => $data
            ]); 
        }
    }
}

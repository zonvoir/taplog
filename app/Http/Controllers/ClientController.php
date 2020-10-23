<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Vendor;
use App\VendorKyc;
use App\User;
use App\Trips;
use App\VehicleStatus;
use App\Beatplan;
use Illuminate\Support\Facades\Hash;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      $data = User::where(['client_id' => auth()->user()->id])->paginate(10);
      return view('users.client.users',['users' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('users.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'email' => 'required|unique:users|max:255',
        'contact' => 'required|unique:users|max:12',
        'name' => 'required',
        'user_type' => 'required',
        'password' => 'required|confirmed',
      ]);
      $user = User::updateOrCreate([
        'name' => $request->name,
        'contact' => $request->contact,
        'email' => $request->email,
        'type' => $request->user_type,
        'password' => Hash::make($request->password),
        'status' => 'active',
        'created_by_id' => auth()->user()->id,
        'client_id' => $request->client_id,
      ]);
      if (isset($user) && !empty($user)) {
        return redirect('client/clients')->with('success', 'User created successfully!');
      }else{
        return back()->with('error','User not created!');
      }
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
     $user = User::find($id);
     return view('users.client.edit',compact('user'));   
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
      $vendor = Vendor::find($id);
      $vendor->vendor_code = $request->vendor_code;
      $vendor->name = $request->name;
      $vendor->billing_address = $request->billing_address;
      $vendor->state = $request->state;
      $vendor->gst_no = $request->gst_no;
      if($request->has('latitute')){
        if ($request->type == 'client') {
          $vendor->latitute = null;
        }else{
          $vendor->latitute = $request->latitute;
        }
      }
      if($request->has('longitude')){
        if ($request->type == 'client') {
          $vendor->longitude = null;
        }else{
          $vendor->longitude = $request->longitude;
        }
      }
      if($request->has('vendor_category')){
        if ($request->type == 'client') {
          $vendor->vendor_category = null;
          $this->deleteVehicleDetailsByVendorID($id);
        }elseif($request->type == 'vendor'){
          if($request->vendor_category == 'PUMP'){
            $vendor->vendor_category = $request->vendor_category;
            $this->deleteVehicleDetailsByVendorID($id);
          }else{
            $vendor->vendor_category = $request->vendor_category;
          }
        }
      }
      $vendor->save();
      $msg = 'Client updated successfully!';
      if($vendor->user_id){
        $user = User::where('id','!=',$vendor->user_id)->where(['email'=>$request->email])->first();
        if(!$user){
          $user                = User::firstOrNew(['id'=>$vendor->user_id, 'email'=>$request->email]);
          $user->name          = $request->name;
          $user->contact       = $request->contact;
          $user->email         = $request->email;
          $user->type          = 'client';
          if($request->has('password') && $request->password){
            $user->password      = Hash::make($request->password);
          }
          $user->save();
          $vendor->user_id      = $user->id;
          $vendor->save();
        }else{
          $msg = 'Email already exists';
        }
      }else{
        $user = User::where(['email'=>$request->email])->first();

        if(!$user){
          $user                = User::firstOrNew(['id'=>$vendor->user_id, 'email'=>$request->email]);
          $user->name          = $request->name;
          $user->contact       = $request->contact;
          $user->email         = $request->email;
          $user->type          = 'client';
          if($request->has('password') && $request->password){
            $user->password    = Hash::make($request->password);
          }
          $user->save();
          $vendor->user_id     = $user->id;
          $vendor->save();
        }else{
          $msg = 'Email already exists';
        }
      }
      return redirect()->back()->with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      dd($id);
    }
    public function profile()
    {
      $id     = Auth::user()->client->id;
      $client = Vendor::find($id);
      $kyc    = VendorKyc::where('vendor_id','=',$id)->first();
      return view('vendor.client.edit',['vendor' => $client,'vendorkyc' => $kyc]);
    }
    public function updateKyc(Request $request)
    {
      if($request->has('row_id') && !empty($request->row_id)){
        $kyc = VendorKyc::find($request->row_id);
        $kyc->adhar_no = $request->adhar_no;
        $kyc->pan_no = $request->pan_no;
        $kyc->beneficiary_name = $request->beneficiary_name;
        $kyc->bank_name = $request->bank_name;
        $kyc->bank_acc_no = $request->bank_acc_no;
        $kyc->ifsc_code = $request->ifsc_code;
        $kyc->pincode = $request->pincode;
        $kyc->save();
        return back()->with('success', 'KYC updated successfully!');
      }else{
        $kyc = new VendorKyc();
        $kyc->vendor_id = $request->client_id;
        $kyc->adhar_no = $request->adhar_no;
        $kyc->pan_no = $request->pan_no;
        $kyc->beneficiary_name = $request->beneficiary_name;
        $kyc->bank_name = $request->bank_name;
        $kyc->bank_acc_no = $request->bank_acc_no;
        $kyc->ifsc_code = $request->ifsc_code;
        $kyc->save();
        return back()->with('success', 'KYC updated successfully!');
      }

    }
    public function trips()
    {
      $userId = auth()->user()->id;
      $clientId = auth()->user()->client->id;
      $trips = Trips::with(['vechile','beat_plan' => function($q) use($clientId) {
        $q->where('client_id', '=', $clientId);
      }])->paginate(10);
      return view('trip.client.trips',['trips' => $trips]);
    }
    public function vehicle_status(Request $request, $vehicle_id){
      if(auth()->user()->type != 'client'){
        abort(404, 'Whatever you were looking for, look somewhere else');
      }
      $vehicle_status  = VehicleStatus::where('vehicle_id', $vehicle_id)->orderBy('id', 'DESC')->first();
      return view('vehicle.client.vehicle_status', compact('vehicle_status'));
    }
    public function updateUser(Request $request, $id)
    {
      $validatedData = $request->validate([
        'email' => 'required|unique:users,email, '.$id.',id',
        'contact' => 'required|unique:users,contact, '.$id.',id',
        'name' => 'required',
        'user_type' => 'required',
        'status' => 'required',
      ]);
      $user = User::updateOrCreate(
        ['id' => $id],
        ['name' => $request->name,'contact' => $request->contact,'email' => $request->email,'type' => $request->user_type,'status' => $request->status]
      );
      if (isset($user) && !empty($user)) {
        return redirect('client/clients')->with('success', 'User updated successfully!');
      }else{
        return back()->with('error','Something went wrong!');
      }
    }
    public function updatePassword(Request $request, $id)
    {
      $validatedData = $request->validate([
        'password' => 'required|confirmed'
      ]);
      $user = User::updateOrCreate(['id' => $id],['password' => Hash::make($request->password)]);
      if (isset($user) && !empty($user)) {
        return redirect('client/clients')->with('success', 'Password updated successfully!');
      }else{
        return back()->with('error','Something went wrong!');
      }
    }
    public function trip_data(Request $request){
      $beat_plan = Beatplan::findOrFail($request->beat_id);
      return view('backlog.client.not_delivered', compact('beat_plan'));
    }
    public function deleteUser($id='')
    {
      if($id){
        User::find($id)->delete();
        return back()->with('success', 'User Deleted!');
      }
    }
  }

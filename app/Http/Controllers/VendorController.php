<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\VendorKyc;
use App\Vehiclemaster;
use Hash;
use Auth;
use App\Helpers\Helper;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Vendor $vendor)
    {
      if(auth()->user()->type == 'subadmin'){
        return view('v3.vendor.index');
      }else{
        abort('403');
      }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('v3.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
      $validatedData =  $request->validate([
        'name'      => 'required',
        'email'     => 'required|unique:users|max:255',
        'contact'     => 'required|unique:users',
        'password'  => 'required',
        'type'      => 'required'
      ]);
      $user                =  new User;
      $user->name          = $request->name;
      $user->email         = strtolower($request->email);
      $user->type          = $request->type;
      $user->contact       = $request->contact;
      $user->password      = Hash::make($request->password);
      $user->created_by_id = auth()->user()->id;
      $user->save();
      if($user){
        $vendor = new Vendor();
        $vendor->user_id = $user->id;
        $vendor->vendor_code = strtoupper($request->vendor_code);
        $vendor->type = $request->type;
        $vendor->name = $request->name;
        $vendor->billing_address = $request->billing_address;
        $vendor->state = $request->state;
        $vendor->gst_no = strtoupper($request->gst_no);
        if($request->type == 'vendor'){
          if($request->has('latitute'))
            $vendor->latitute = $request->latitute;
          if($request->has('longitude'))
            $vendor->longitude = $request->longitude;
          if($request->has('vendor_category'))
            $vendor->vendor_category = $request->vendor_category;
        }
        $vendor->created_by_id = auth()->user()->id;
        $vendor->save();
        if($request->vehicleAdded == 'yes'){
          $vendor = Vendor::find($vendor->id);
          return view('v3.vehicle.create',compact('vendor'));
        }else{
          if($vendor->type == 'client')
            return redirect('vendor/vendors')->with('success', 'Client created successfully!');
          else
            return redirect('vendor/vendors')->with('success', 'Vendor created successfully!');
        }
      }else{
        return redirect('vendor/vendors')->with('success', 'Vendor created failed!');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Vendor $vendors)
    {
     $response = [];$numrecords = 10;
     if ($request->has('name')) {
      $search = $request->name;
      if(auth()->user()->type != 'subadmin'){
        $data = $vendors->where('name', 'LIKE', "%{$search}%")->where(['type'=>'client','created_by_id'=>auth()->user()->created_by_id])->limit($numrecords)->get();
      }else{
        $data = $vendors->where('name', 'LIKE', "%{$search}%")->where(['type'=>'client'])->limit($numrecords)->get();
      }
      foreach ($data as $p) { $response[] = array("id" => $p->id, "gst" => $p->gst_no, "name" => $p->name); }
    } else {
      $data = $vendors->limit($numrecords)->get();
    }
    return response()->json($response);
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = Vendor::find($id);
      return view('v3.vendor.personal-info',compact('user'));
    }

    public function profile()
    {
      $id     = Auth::user()->vendor->id;
      $vendor = Vendor::find($id);
      $kyc    = VendorKyc::where('vendor_id','=',$id)->first();
      return view('vendor.edit',['vendor' => $vendor,'vendorkyc' => $kyc]);
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
      $vendor->type = $request->type;
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

      $msg = 'Vendor updated successfully!';
      if($vendor->user_id){
        $user = User::where('id','!=',$vendor->user_id)->where(['email'=>$request->email])->first();

        if(!$user){
          $user                = User::firstOrNew(['id'=>$vendor->user_id, 'email'=>$request->email]);
          $user->name          = $request->name;
          $user->email         = $request->email;
          $user->type          = $request->type;
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
          $user->email         = $request->email;
          $user->type          = $request->type;
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
      Vendor::destroy($id);
      return redirect('vendor/vendors')->with('error', 'Vendor successfully deleted.');
    }
    public function redirectToEditVehicle($id='')
    {
      $vehicleId = Vehiclemaster::where('vendor_id','=',$id)->first();
      if($vehicleId){
        return redirect()->route('vehicle.edit', [$vehicleId['id']]);
      }else{
        return view('vehicle.create',['vendorId' => $id]);
      }
    }
    public function updateKyc(Request $request)
    {
      if($request->has('row_id') && !empty($request->row_id)){
        $kyc = VendorKyc::find($request->row_id);
        $kyc->adhar_no = $request->adhar_no;
        $kyc->mobile_no = $request->mobile_no;
        $kyc->pan_no = $request->pan_no;
        $kyc->email_id = $request->email_id;
        $kyc->beneficiary_name = $request->beneficiary_name;
        $kyc->bank_name = $request->bank_name;
        $kyc->bank_acc_no = $request->bank_acc_no;
        $kyc->ifsc_code = $request->ifsc_code;
        $kyc->save();
        return back()->with('success', 'KYC updated successfully!');
      }else{
        $kyc = new VendorKyc();
        $kyc->vendor_id = $request->vendor_id;
        $kyc->adhar_no = $request->adhar_no;
        $kyc->mobile_no = $request->mobile_no;
        $kyc->pan_no = $request->pan_no;
        $kyc->email_id = $request->email_id;
        $kyc->beneficiary_name = $request->beneficiary_name;
        $kyc->bank_name = $request->bank_name;
        $kyc->bank_acc_no = $request->bank_acc_no;
        $kyc->ifsc_code = $request->ifsc_code;
        $kyc->save();
        return back()->with('success', 'KYC updated successfully!');
      }

    }
    public function deleteVehicleDetailsByVendorID($vendorID='')
    {
      $exists = Vehiclemaster::where('vendor_id','=',$vendorID)->exists();
      if($exists){
        $res = Vehiclemaster::where('vendor_id','=',$vendorID)->delete();
      }
    }
    public function indexDataTable(Request $request)
    {
      $returndata = [];
      if(auth()->user()->type == 'subadmin'){
        $returndata = Vendor::where('created_by_id','=',auth()->user()->id)->get();
      }

      $columnsDefault = [
        'id'     => true,
        'vendor_code'     => true,
        'name'      => true,
        'type'      => true,
        'billing_address'  => true,
        'state'  => true,
        'gst_no'  => true,
        'latitute'  => true,
        'longitude'  => true,
        'vendor_category'  => true,
        'created_at'  => true,
        'action'  => true,
      ];

      if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
        $columnsDefault = [];
        foreach ( $_REQUEST['columnsDef'] as $field ) {
          $columnsDefault[ $field ] = true;
        }
      }
      $alldata = array();
      
      if(isset($returndata) && !empty($returndata)){
        $i = 0;
        foreach ($returndata as $vendor) {
          $alldata[$i]['id'] = $vendor->id;
          $alldata[$i]['vendor_code'] = $vendor->vendor_code;
          $alldata[$i]['name'] = $vendor->name;
          $alldata[$i]['type'] = $vendor->type == 'client' ? 'Client' : ($vendor->type == 'vendor' ? 'Vendor' : '');
          $alldata[$i]['billing_address'] = $vendor->billing_address;
          $alldata[$i]['state'] = $vendor->states->state;
          $alldata[$i]['gst_no'] = $vendor->gst_no;
          $alldata[$i]['latitute'] = $vendor->latitute;
          $alldata[$i]['longitude'] = $vendor->longitude;
          $alldata[$i]['vendor_category'] = $vendor->vendor_category;
          $alldata[$i]['created_at'] = \Carbon\Carbon::parse($vendor->created_at)->format('d-m-Y');
          $alldata[$i]['action'] = '<div class="dropdown dropdown-inline"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"><i class="la la-cog text-info"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column"><li class="nav-item"><a class="nav-link" href="'.route('vendors.edit',$vendor->id).'"><i class="nav-icon la la-edit"></i><span class="nav-text">Update Profile</span></a></li><li class="nav-item"></li></ul></div></div><a href="javascript:;" class="btn btn-sm btn-clean btn-icon del-vendor" vendor-id="'.$vendor->id.'" title="Delete '.$vendor->type.'"><i class="la la-trash text-danger"></i></a>';
          $i++;
        }
      }
      $data = [];
      
      foreach ( $alldata as $d ) {
        $data[] = Helper::filterArray( $d, $columnsDefault );
      }

      $totalRecords = $totalDisplay = count( $data );
      if ( isset( $_REQUEST['search'] ) ) {
        $data         = Helper::filterKeyword( $data, $_REQUEST['search'] );
        $totalDisplay = count( $data );
      }
      if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
        foreach ( $_REQUEST['columns'] as $column ) {
          if ( isset( $column['search'] ) ) {
            $data         = Helper::filterKeyword( $data, $column['search'], $column['data'] );
            $totalDisplay = count( $data );
          }
        }
      }

      

     /* if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
        $column = $_REQUEST['order'][0]['column'];
        $dir    = $_REQUEST['order'][0]['dir'];
        usort( $data, function ( $a, $b ) use ( $column, $dir ) {
          $a = array_slice( $a, $column, 1 );
          $b = array_slice( $b, $column, 1 );
          $a = array_pop( $a );
          $b = array_pop( $b );

          if ( $dir === 'desc' ) {
            return $a > $b ? true : false;
          }

          return $a < $b ? true : false;
        } );
      }*/

      if ( isset( $_REQUEST['length'] ) ) {
        $data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
      }
      if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
        $tmp  = $data;
        $data = [];
        foreach ( $tmp as $d ) {
          $data[] = array_values( $d );
        }
      }
      $secho = 0;
      if ( isset( $_REQUEST['sEcho'] ) ) {
        $secho = intval( $_REQUEST['sEcho'] );
      }

      $result = [
        'iTotalRecords'        => $totalRecords,
        'iTotalDisplayRecords' => $totalDisplay,
        'sEcho'                => $secho,
        'aaData'               => $data,
      ];
      header('Content-Type: application/json');
      header('Access-Control-Allow-Origin: *');
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
      return json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
  }

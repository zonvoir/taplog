<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\VendorKyc;
use App\Vehiclemaster;
use Hash;
use Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Vendor $vendor)
    {
        return view('vendor.index',['vendors' => $vendor->where('created_by_id','=',auth()->user()->id)->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('vendor.create');
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
                              'password'  => 'required',
                              'type'      => 'required'
                          ]);
        $user                =  new User;
        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->type          = $request->type;
        $user->password      = Hash::make($request->password);
        $user->created_by_id = auth()->user()->id;
        $user->save();

        if($user){
          $vendor = new Vendor();
          $vendor->user_id = $user->id;
          $vendor->vendor_code = $request->vendor_code;
          $vendor->type = $request->type;
          $vendor->name = $request->name;
          $vendor->billing_address = $request->billing_address;
          $vendor->state = $request->state;
          $vendor->gst_no = $request->gst_no;
          $vendor->gst_no = $request->gst_no;
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
              return view('vehicle.create',['vendorId' => $vendor->id]);
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
        $vendor = Vendor::find($id);
        $kyc    = VendorKyc::where('vendor_id','=',$id)->first();
        return view('vendor.edit',['vendor' => $vendor,'vendorkyc' => $kyc]);
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
}

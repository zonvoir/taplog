<?php

namespace App\Http\Controllers;

use App\User;
use App\Userdetails;
use App\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
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
        if(auth()->user()->type !== 'admin'){
            return view('users.index', ['users' => $model->where('type','!=','admin')->where('type','!=','vendor')->where('type','!=','client')->where('type','!=','technician')->where(['created_by_id' => auth()->user()->id])->where('type', '!=', 'other')->orderBy('id','desc')->paginate(15)]);
        }else{
            return view('users.index', ['users' => $model->where('type','=','subadmin')->where(['status' => 'active'])->paginate(15)]);
        }
    }
    public function create()
    {
        return view('users.create');   
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|unique:users',
            'name' => 'required',
            'user_type' => 'required',
            'status' => 'required',
        ]);
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        if($request->has('user_type')){
            $user->type = $request->user_type;
        }else{
            if($request->type == 'other'){
                $user->type = $request->user_type;
            }else{
                $user->type = $request->type;
            }
        }
        $user->created_by_id = auth()->user()->id;
        $user->save();
        return back()->with('success','User created successfully!');
    }   
    public function edit($id='')
    {
     $user = User::find($id);
     return view('users.edit',compact('user'));   
 }
 public function update(Request $request)
 {
    // $validator = Validator::make($request->all(), [
    //     'name' => ['required', 'string', 'max:255'],
    //     'email' => ['required', 'string', 'email', 'max:255'],
    // ]);
    $validatedData = $request->validate([
        'email' => 'required|unique:users,email, '.$request->id.',id',
        'name' => 'required',
        'user_type' => 'required',
        'status' => 'required',
    ]);
    // if ($validator->fails()) {
    //     return back()->withErrors($validator);
    // }
    $user = User::find($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->status = $request->status;
    if($request->has('user_type')){
        $user->type = $request->user_type;
    }else{
        if($request->type == 'other'){
            $user->type = $request->user_type;
        }else{
            $user->type = $request->type;
        }
    }
    $user->save();
    //return back()->withStatus(__('Profile successfully updated.'));
    return redirect('/user')->with('success','Profile successfully updated.');
}
public function destroy($id='')
{
    User::destroy($id);
    return back()->withStatus(__('Profile successfully deleted.'));
}
public function updatePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
    if ($validator->fails()) {
        return back()->withErrors($validator);
    }
    $user = User::find($request->id);
    $user->password = Hash::make($request->password);
    $user->save();
    //return back()->withStatus(__('Password successfully updated.'));
    return redirect('/user')->with('success','Password successfully updated.');
}
public function profile($id='')
{
    $userdetails = Userdetails::where('user_id','=',$id)->first();
    $children = Children::where('user_id','=',$id)->get();
    return view('users.update-profile',['userdetails'=>$userdetails,'user_id'=>$id,'children' => $children]);  
}
public function updateProfile(Request $request)
{
    if(Userdetails::where('user_id','=',$request->user_id)->exists()){
        $userdetails = Userdetails::where('user_id','=',$request->user_id)->first();
        $userdetails->emp_id = $request->emp_id;
        $userdetails->gender = $request->gender;
        $userdetails->dob = $request->dob;
        $userdetails->doj = $request->doj;
        $userdetails->father_name = $request->father_name;
        $userdetails->mother_name = $request->mother_name;
        $userdetails->marital_status = $request->marital_status;
        if($request->marital_status == 'yes'){
            $userdetails->spouse_name = $request->spouse_name;
            if($request->child_status == 'yes'){
                $userdetails->child_status = $request->child_status;
                $userdetails->children = $request->children;
                $childrenNameArray =  $request->child_name;
                $childrenAgeArray =  $request->child_age;
                $i = 0;
                Children::where('user_id',$request->user_id)->delete();
                if(isset($childrenNameArray) && !empty($childrenNameArray)){
                    foreach ($childrenNameArray as $value) {
                        Children::create([
                         'user_id' => $request->user_id,
                         'child_name' => $value,
                         'child_age' => $childrenAgeArray[$i]
                     ]); 
                        $i++;
                    }    
                }
            }elseif ($request->child_status == 'no') {
                Children::where('user_id',$request->user_id)->delete();
                $userdetails->child_status = $request->child_status;
                $userdetails->children = 0;
            }
        }elseif ($request->marital_status == 'no') {
            $userdetails->spouse_name = null;
            Children::where('user_id',$request->user_id)->delete();
            $userdetails->child_status = 'no';
            $userdetails->children = 0;
        }
        if($request->has('other_contact')){
            $userdetails->other_contact = $request->other_contact;
            $user = User::find($request->user_id);
            $user->contact = $request->other_contact;
            $user->save();
        }
        $userdetails->emergency_contact_person_name = $request->emergency_contact_person_name;
        $userdetails->emergency_contact = $request->emergency_contact;
        $userdetails->adhar_no = $request->adhar_no;
        if ($request->has('adhar_doc')) {
            $userdetails->adhar_doc = $request->file('adhar_doc')->store('adhar');
        }
        $userdetails->address = $request->address;
        if ($request->has('address_proof_doc')) {
            $userdetails->address_proof_doc = $request->file('address_proof_doc')->store('address');
        }
        $userdetails->correspond_address = $request->correspond_address;
        if ($request->has('correspond_address_proof')) {
            $userdetails->correspond_address_proof = $request->file('correspond_address_proof')->store('correspond');
        }
        if ($request->has('police_verified_doc')) {
            $userdetails->police_verified_doc = $request->file('police_verified_doc')->store('police');
        }
        $userdetails->uan_no = $request->uan_no;
        $userdetails->esic_no = $request->esic_no;
        $userdetails->bank_name = $request->bank_name;
        $userdetails->bank_account_no = $request->bank_account_no;
        $userdetails->bank_ifsc = $request->bank_ifsc;
        $userdetails->working_status = $request->working_status;
        $userdetails->filled_by_id = auth()->user()->id;
        //dd($userdetails);
        $userdetails->save();
        return back()->with('success','Profile updated successfully!');
    }else{
        //dd($request->all());
        $newUserDetails = new Userdetails();
        $newUserDetails->user_id = $request->user_id;
        $newUserDetails->emp_id = $request->emp_id;
        $newUserDetails->gender = $request->gender;
        $newUserDetails->dob = $request->dob;
        $newUserDetails->doj = $request->doj;
        $newUserDetails->father_name = $request->father_name;
        $newUserDetails->mother_name = $request->mother_name;
        $newUserDetails->marital_status = $request->marital_status;
        if($request->marital_status == 'yes'){
            $newUserDetails->spouse_name = $request->spouse_name;
            if($request->child_status == 'yes'){
                $newUserDetails->child_status = $request->child_status;
                $newUserDetails->children = $request->children;
                $childrenNameArray =  $request->child_name;
                $childrenAgeArray =  $request->child_age;
                $i = 0;
                if(isset($childrenNameArray) && !empty($childrenNameArray)){
                    foreach ($childrenNameArray as $value) {
                        Children::create([
                         'user_id' => $request->user_id,
                         'child_name' => $value,
                         'child_age' => $childrenAgeArray[$i]
                     ]); 
                        $i++;
                    }
                }
            }elseif ($request->child_status == 'no') {
                $newUserDetails->child_status = $request->child_status;
                $newUserDetails->children = 0;
            }
        }elseif ($request->marital_status == 'no') {
            $newUserDetails->spouse_name = null;
            $newUserDetails->child_status = 'no';
            $newUserDetails->children = 0;
        }
        if($request->has('other_contact')){
            $newUserDetails->other_contact = $request->other_contact;
            $user = User::find($request->user_id);
            $user->contact = $request->other_contact;
            $user->save();
        }
        $newUserDetails->emergency_contact_person_name = $request->emergency_contact_person_name;
        $newUserDetails->emergency_contact = $request->emergency_contact;
        $newUserDetails->adhar_no = $request->adhar_no;
        if ($request->has('adhar_doc')) {
            $newUserDetails->adhar_doc = $request->file('adhar_doc')->store('adhar');
        }
        $newUserDetails->address = $request->address;
        if ($request->has('address_proof_doc')) {
            $newUserDetails->address_proof_doc = $request->file('address_proof_doc')->store('address');
        }
        $newUserDetails->correspond_address = $request->correspond_address;
        if ($request->has('correspond_address_proof')) {
            $newUserDetails->correspond_address_proof = $request->file('correspond_address_proof')->store('correspond');
        }
        if ($request->has('police_verified_doc')) {
            $newUserDetails->police_verified_doc = $request->file('police_verified_doc')->store('police');
        }
        $newUserDetails->uan_no = $request->uan_no;
        $newUserDetails->esic_no = $request->esic_no;
        $newUserDetails->bank_name = $request->bank_name;
        $newUserDetails->bank_account_no = $request->bank_account_no;
        $newUserDetails->bank_ifsc = $request->bank_ifsc;
        $newUserDetails->working_status = $request->working_status;
        $newUserDetails->filled_by_id = auth()->user()->id;
        $newUserDetails->save();
        return back()->with('success','Profile created successfully!');
    }
}
public function driverForTrip(Request $request,Vehiclemaster $vehicle)
{
    $response = [];$numrecords = 10;
    if ($request->has('name')) {
        $search = $request->name;
        if(auth()->user()->type == 'subadmin'){
            $data = $vehicle->where('name', 'LIKE', "%{$search}%")->where(['created_by_id' => auth()->user()->id])->limit($numrecords)->get();
        }elseif (auth()->user()->type == 'mis') {
            $data = $vehicle->where('name', 'LIKE', "%{$search}%")->where(['created_by_id' => auth()->user()->created_by_id])->limit($numrecords)->get();
        }
        foreach ($data as $p) { $response[] = array("id" => $p->id, "name" => $p->name); }
    } else {
        $data = $vehicle->limit($numrecords)->get();
    }
    return response()->json($response);
}
public function apiToken(Request $request)
{
    if ($request->has('id')) {
        $token = Str::random(80);
        $user = User::find($request->id);
        $user->api_token = $token;
        $user->save();
        return ['token' => $token];   
    }
}
}

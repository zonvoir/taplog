<?php

namespace App\Http\Controllers;

use App\User;
use App\Userdetails;
use App\Children;
use App\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Helpers\Helper;

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
        return view('v3.users.index');
    }
    public function create()
    {
        return view('v3.users.create');   
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users',
            'contact' => 'required|unique:users',
        ]);
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = strtolower($request->email);
        $user->name = $request->name;
        $user->type = $request->type;
        $user->contact = $request->contact;
        $user->created_by_id = auth()->user()->id;
        if($request->has('app_login')){
            $user->api_token = Str::random(80);
        }
        $user->save();
        return redirect('user')->with('success','User created successfully!');
    }   
    public function edit($id='')
    {
       $user = User::find($id);
       if($user->type == 'vendor' || $user->type == 'client'){
        abort('403');
    }else{
        return view('v3.users.personal-info',compact('user'));   
    }
}
public function update(Request $request)
{
    if($request->form == 'marital'){
        $details = Userdetails::firstOrNew(['user_id'=>$request->user_id]);
        $details->child_status = $request->child_status;
        $details->spouse_name = $request->spouse_name;
        $details->children = count($request->children);
        if($details->save()){
            if($details->child_status == 'yes'){
                if(count(array_filter(array_column($request->children, 'gender'), 'strlen')) > 0){
                    $len = count(array_filter(array_column($request->children, 'gender'), 'strlen'));
                    for ($i = 0; $i<$len; $i++) {
                        $child = Children::firstOrNew(['id' => isset($request->children[$i]['child_id']) ? $request->children[$i]['child_id'] : 0]);
                        $child->child_name = $request->children[$i]['name'];
                        $child->child_age = $request->children[$i]['age'];
                        $child->gender = $request->children[$i]['gender'];
                        $child->user_id = $request->user_id;
                        $child->save();
                    }    
                }
            }else{
                Children::where('user_id','=',$request->user_id)->delete();
            }
        }
    }elseif ($request->form == 'personal') {
        $details = Userdetails::firstOrNew(['user_id'=>$request->user_id]);
        $details->first_name = $request->first_name;
        $details->last_name = $request->last_name;
        $details->dob = $request->dob;
        $details->doj = $request->doj;
        $details->gender = $request->gender;
        $details->father_name = $request->father_name;
        $details->mother_name = $request->mother_name;
        $details->marital_status = $request->married;
        if ($request->hasFile('profile_avatar')) {
            $details->profile_img = $request->file('profile_avatar')->store('user');
        }
        if($details->save()){
            $user = User::find($request->user_id);
            if($request->has('first_name') && $request->has('last_name')){
                $user->name = $request->first_name.' '.$request->last_name;
            }
            $user->save();
        }
    }elseif ($request->form == 'contact') {
        $validatedData = $request->validate([
            'email' => 'required|unique:users,email, '.$request->user_id.',id',
            'contact' => 'required|unique:users,contact, '.$request->user_id.',id',
        ]);
        $details = Userdetails::firstOrNew(['user_id'=>$request->user_id]);
        $details->emergency_contact_person_name = $request->emergency_contact_person_name;
        $details->emergency_contact = $request->emergency_contact;
        $details->address = $request->address;
        $details->other_contact = $request->other_contact;
        if ($request->hasFile('address_proof_doc')) {
            $details->address_proof_doc = $request->file('address_proof_doc')->store('address');
        }
        if ($request->hasFile('correspond_address_proof')) {
            $details->correspond_address_proof = $request->file('correspond_address_proof')->store('correspond');
        }
        if ($request->hasFile('police_verified_doc')) {
            $details->police_verified_doc = $request->file('police_verified_doc')->store('police');
        }
        if($details->save()){
            $user = User::find($request->user_id);
            $user->contact = $request->contact;
            $user->email = $request->email;
            $user->save();
        }
    }elseif ($request->form == 'password') {
        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();
    }elseif ($request->form == 'kyc') {
        $details = Userdetails::firstOrNew(['user_id'=>$request->user_id]);
        $details->adhar_no = $request->adhar_no;
        $details->uan_no = $request->uan_no;
        $details->esic_no = $request->esic_no;
        $details->bank_name = $request->bank_name;
        $details->bank_account_no = $request->bank_account_no;
        $details->bank_ifsc = $request->bank_ifsc;
        if ($request->hasFile('adhar_doc')) {
            $details->adhar_doc = $request->file('adhar_doc')->store('adhar');
        }
        $details->save();
    }
    return redirect('/user')->with('success','Profile successfully updated.');
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
public function indexDataTable(Request $request)
{
 $returndata = [];
 $alldata = array();
 if (auth()->user()->type == 'admin') {
     $returndata = User::where('type','=','subadmin')->get();
 }
 elseif(auth()->user()->type == 'subadmin'){
    $returndata = User::whereNotIn('type',['vendor','client','admin','subadmin','other'])->where('created_by_id','=',auth()->user()->id)->get();
}
$columnsDefault = [
    'id'     => true,
    'name'     => true,
    'email'      => true,
    'contact'      => true,
    'type'     => true,
    'status'  => true,
    'created_date'  => true,
    'action'  => true,
];
if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
    $columnsDefault = [];
    foreach ( $_REQUEST['columnsDef'] as $field ) {
        $columnsDefault[ $field ] = true;
    }
}
if(isset($returndata) && !empty($returndata)){
    $i = 0;
    foreach ($returndata as $user) {
        $alldata[$i]['id'] = $user->id;
        $alldata[$i]['name'] = '<button type="button" class="btn btn-outline-secondary" onclick="userDetails('.$user->id.')">'.$user->name.'</button>';
        $alldata[$i]['email'] = $user->email;
        $alldata[$i]['contact'] = $user->contact ? $user->contact : 'NA';
        $alldata[$i]['type'] = $user->type == 'mis' ? 'MIS' : ($user->type == 'field_officer' ? 'Area Officer' : ($user->type == 'filler' ? 'Filler' : ($user->type == 'driver' ? 'Driver' : 'Unknown')));;
        $alldata[$i]['status'] = $user->status == 'active' ? '<span class="label label-success label-dot mr-2"></span><span class="font-weight-bold text-success">Active</span>' : '<span class="label label-danger label-dot mr-2"></span><span class="font-weight-bold text-danger">Deactive</span>';
        $alldata[$i]['created_at'] = \Carbon\Carbon::parse($user->created_at)->format('d-m-Y');
        $alldata[$i]['action'] = '<div class="dropdown dropdown-inline"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"><i class="la la-cog text-info"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column"><li class="nav-item"><a class="nav-link" href="'.route('user.edit',$user->id).'"><i class="nav-icon la la-edit"></i><span class="nav-text">Update Profile</span></a></li><li class="nav-item"></li></ul></div></div><a href="javascript:;" class="btn btn-sm btn-clean btn-icon del-user" user-id="'.$user->id.'" title="Delete User"><i class="la la-trash text-danger"></i></a>';
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
if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
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
}
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
public function getUserDetailById(Request $request)
{
    $modalData = '';
    if ($request->has('id')) {
        if(Userdetails::where('user_id','=',$request->id)->exists()){
            $data = Userdetails::where('user_id','=',$request->id)->first();
            $modalData .= '<tbody>';
            $modalData .= '<tr><th>Employee Id: </th><td>'.$data['emp_id'].'</td><th>Gender: </th><td>'.$data['gender'].'</td></tr>';
            $modalData .= '<tr>
            <th>DOB: </th>
            <td>'.$data['dob'].'</td>
            <th>DOJ: </th>
            <td>'.$data['doj'].'</td>
            </tr>';
            $modalData .= '<tr>
            <th>Father: </th>
            <td>'.$data['father_name'].'</td>
            <th>Mother: </th>
            <td>'.$data['mother_name'].'</td>
            </tr>';
            $modalData .= '<tr>
            <th>Is Married: </th>
            <td>'.$data['marital_status'].'</td>';
            if ($data['marital_status'] == 'yes') {
                $modalData .= '<th>Spouse: </th>
                <td>'.$data['spouse_name'].'</td></tr>';
                $modalData .= '<tr>
                <th>Is Child: </th>
                <td>'.$data['child_status'].'</td>';
            }
            if ($data['child_status'] == 'yes') {
                $modalData .= '<th>Total Children: </th>
                <td>'.$data['children'].'</td>';    
            }
            $modalData .= '</tr>';
            $modalData .= '<tr>
            <th>Emergancy Person: </th>
            <td>'.$data['emergency_contact_person_name'].'</td>
            <th>Emergancy Contact: </th>
            <td>'.$data['emergency_contact'].'</td>
            </tr>';
            $modalData .= '<tr>
            <th>Adhar: </th>
            <td>'.$data['adhar_no'].'</td>
            <th>Adhar File: </th>
            <td><a href="'.$data['adhar_doc'] ? asset('public/adhar/').$data['adhar_doc'] : 'NA'.'" /download>File</a></td>
            </tr>';
            $modalData .= '<tr>
            <th>Address: </th>
            <td>'.$data['address'].'</td>
            <th>Proof: </th>
            <td><a href="'.$data['address_proof_doc'] ? asset('public/address/').$data['address_proof_doc'] : 'NA'.'" /download>File</a></td>
            </tr>';
            $modalData .= '<tr>
            <th>Correspond Address: </th>
            <td>'.$data['correspond_address'].'</td>
            <th>Proof: </th>
            <td><a href="'.$data['correspond_address_proof'] ? asset('public/correspond/').$data['correspond_address_proof'] : 'NA'.'" /download>File</a></td>
            </tr>';
            $modalData .= '<tr>
            <th>ESIC: </th>
            <td>'.$data['esic_no'].'</td>
            <th>UAN: </th>
            <td>'.$data['uan_no'].'</td>
            </tr>';
            $modalData .= '<tr>
            <th>Bank Name: </th>
            <td>'.$data['bank_name'].'</td>
            <th>A/C No.: </th>
            <td>'.$data['bank_account_no'].'</td>
            </tr>';
            $modalData .= '<tr>
            <th>IFSC: </th>
            <td>'.$data['bank_ifsc'].'</td>
            <th>Police Verified Doc: </th>
            <td>'.$data['police_verified_doc'] ? asset('public/police/').$data['police_verified_doc'] : 'NA'.'</td>
            </tr>';
            $modalData .= '<tr>
            <th>Other Contact: </th>
            <td>'.$data['other_contact'].'</td>
            <th>Working Status: </th>
            <td>'.$data['working_status'].'</td>
            </tr>
            </tbody>';
            return response()->json($modalData);
        }else{
            return false;
        }
        
    }
}
public function removeUser(Request $request)
{
    if(User::find($request->id)->delete()){
        if(Userdetails::where('user_id','=',$request->id)->exists()){
            Userdetails::where('user_id','=',$request->id)->delete();
        }
        return true;
    }
}
public function marital($id='')
{
   $user = User::find($id);
   if($user->type == 'vendor' || $user->type == 'client'){
    abort('403');
}else{
   if($user->details->marital_status == 'yes'){
    return view('v3.users.marital-info',compact('user'));   
}else{
    abort('404');
}
}
}
public function removeChild(Request $request)
{
 if(Children::find($request->id)->delete()){
    return true;
}
}
public function contact($id='')
{
   $user = User::find($id);
   if($user->type == 'vendor' || $user->type == 'client'){
    abort('403');
}else{
   return view('v3.users.contact-info',compact('user')); 
}
}
public function password($id='')
{
   $user = User::find($id);
   if($user->type == 'vendor' || $user->type == 'client'){
    abort('403');
}else{
   return view('v3.users.password-info',compact('user')); 
}
}
public function kyc($id='')
{
   $user = User::find($id);
   if($user->type == 'vendor' || $user->type == 'client'){
    abort('403');
}else{
   return view('v3.users.kyc-info',compact('user')); 
}
}
public function getAllStates(Request $request)
{
    $data = States::select('id','state as text')->get()->toArray();
    return response()->json($data);
}
}

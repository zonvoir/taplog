<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected $redirectTo = RouteServiceProvider::HOME;
    public function login(Request $request)
    {
        $validatedData = $request->validate([
        'username' => 'required',
        'password' => 'required',
      ]);
        //$credentials = $request->only('email', 'password');
        $credentials = $this->credentials($request);
        if(isset($credentials['contact'])){
            if (Auth::attempt(['contact' => $credentials['contact'], 'password' => $credentials['password'], 'status' => 'active'])) {
                // Authentication passed...
                if(auth()->user()->type == 'subadmin'){
                    return redirect()->route('beat-plan');
                }elseif(auth()->user()->type == 'vendor'){
                    return redirect()->route('all-vehicles');
                }elseif (auth()->user()->type == 'client') {
                    return redirect()->route('beat-plan');
                }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id) {
                    return redirect('/mis/index');
                }elseif (auth()->user()->type == 'technician' && auth()->user()->client_id) {
                    return redirect('/tech/index');
                }else{
                    return redirect()->intended('/');
                }
            }else{
                return redirect()->back()->with('error','Wrong credentials!');
            }
        }elseif (isset($credentials['email'])){
            if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'status' => 'active'])) {
                // Authentication passed...
                if(auth()->user()->type == 'subadmin'){
                    return redirect()->route('beat-plan');
                }elseif(auth()->user()->type == 'vendor'){
                    return redirect()->route('all-vehicles');
                }elseif (auth()->user()->type == 'client') {
                    return redirect()->route('beat-plan');
                }elseif (auth()->user()->type == 'mis' && auth()->user()->client_id) {
                    return redirect('/mis/index');
                }elseif (auth()->user()->type == 'technician' && auth()->user()->client_id) {
                    return redirect('/tech/index');
                }else{
                    return redirect()->intended('/');
                }
            }else{
                return redirect()->back()->with('error','Wrong credentials!');
            }
        }else{
            return redirect()->back()->with('error','Wrong credentials!');
        }
    }
}
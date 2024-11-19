<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdmiController extends Controller
{
    public function login_handler(Request $request){

        $fieldType = filter_var($request->login_id,FILTER_VALIDATE_EMAIL)?'email':'username';
        if($fieldType=='email'){

            $request->validate([
                'login_id'=>'required|email|exists:admins,email',
                'password'=> 'required|min:5|max:45'
            ],[
                'login_id.required'=> 'Email or Username is required',
                'login_id.email'=>'Invalid email address',
                'login_id.exists'=>'Email is not exists in system',
                'password.required'=> 'password is required'
            ]);
        }else{

            $request->validate([
                'login_id'=>'required|exists:admins,username',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=> 'Email or Username is required',
                'login_id.exists'=> 'username is not exists in system',
                'password.required'=>'password is required'
            ]);
        }
        $creds = [
            $fieldType => $request->login_id,
            'password' => $request->password,
        ];
        
        // Debugging credentials
        
        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('admin.home');
        } else {
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('admin.login');
        }
        
    }

    public function logout_handler(Request $request){

        Auth::guard('admin')->logout();
        session()->flash('fail', 'You are logout');
        return redirect()->route('admin.login');
    }
}

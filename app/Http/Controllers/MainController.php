<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use App\User;

class MainController extends Controller
{
    function account(){
        $user = User::where('id',Auth::user()->id);

        return view('account', ['user', $user]);
    }

    function updateUser(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users',
            'password' => 'required|required_with:password_confirmation|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        $use = User::find($request->input("user_id"));
        
        $use->name = $request->input("name");
        $use->username = $request->input("username");
        $use->password = $request->input("password");

        $use->save();

        Session::flash('success', 'Event successfully updated.');

        return redirect()->route('user.edit', ['use', $use]);
    }

    function index(){
    	return view('login');
    }

    function checklogin(Request $request)
    {
     $this->validate($request, [
      'email'   => 'required|email',
      'password'  => 'required|string|min:3'
     ]);

     $user_data = array(
      'email'  => $request->get('email'),
      'password' => $request->get('password')
     );

     if(Auth::attempt($user_data))
     {
         Session::flash('success', ' Logged In Successfully');
        return redirect('main/successlogin');
     }
     else
     {
         Session::flash('failed', ' Wrong Log In Details');
        return back();
     }

    }

    function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|required_with:password_confirmation|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        $user = new User([
            'name'=> $request->input('name'),
            'username'=> $request->input('username'),
            'email'=> $request->input('email'),
            'password'=> $request->input('password'),
        ]); 
        $user->save();
        Session::flash('success', 'Event Created Successfully');
        return redirect('/main');
    }
    function successlogin()
    {
        return redirect('/sched');
    }

    function logout()
    {
     Auth::logout();
     return redirect('/main');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function registerPost(Request $request){
        $this->validate($request, [
            'username' => 'required|min:3|unique:users',
            'email' => 'required|min:4|email|unique:users',
            'password' => 'required|min:6',
            'captcha' => 'required|captcha',
        ]);

        $data = new User();
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();
        return redirect('login')->with('alert-success','Kamu berhasil Register');
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);
        $username = $request->username;
        $password = $request->password;

        $data = User::where('username',$username)->first();
        //dd($data);
        if($data){ //apakah email tersebut ada atau tidak
            //$akses = $data->role;
            //dd($akses);
            if(Hash::check($password,$data->password)){
              if($akses = $data->role == "2"){
                Session::put('username',$data->username);
                Session::put('id',$data->id);
                Session::put('email',$data->email);
                Session::put('role', 'admin');
                Session::put('login',TRUE);
                return redirect('/admin');
              }else if($akses = $data->role == "1"){  
                Session::put('username',$data->username);
                Session::put('id',$data->id);
                Session::put('email',$data->email);
                Session::put('role','user');
                Session::put('login',TRUE);
                return redirect('/');
              }          
            }
            else{
                return redirect('login')->with('alert','Password atau Username, Salah !');
            }
        }
        else{
            return redirect('login')->with('alert','User belum terdaftar!');
        }
    }

    public function logout(){
        Session::flush();
        return redirect('/')->with('alert','Kamu sudah logout');
    }
}

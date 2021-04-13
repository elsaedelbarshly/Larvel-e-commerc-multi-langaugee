<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;



class LoginController extends Controller
{
    public function getlogin(){
        return view('admin.login');
    }

    public function postlogin(loginRequest $request){
      // make validation in antore file

      
      $remember_me = $request->has('remember_me') ? true : false;

      if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
         // notify()->success('تم الدخول بنجاح  ');
          return redirect() -> route('admin.dashboard');
      }
     // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
      return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);

    }
    // in tinker
    // public function save(){
    //     $admin = new App\Models\Admin();
    //     $admin -> name ="Elsaed Elbarshly";
    //     $admin -> email ="elsaed@gmail.com";
    //     $admin -> password =bcrypt ("nnnnn12345");
    //     $admin -> save();

    // }
}

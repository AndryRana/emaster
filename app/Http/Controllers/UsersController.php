<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

   public function register(Request $request)
   {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            // Check if user already exists
            $usersCount = User::where('email',$data['email'])->count();
            if($usersCount>0){
                return redirect()->back()->with('flash_message_error','L\'adresse email existe déjà!');
            }else{
                echo "Success";die;
            }
        }
        return view('users.login_register');
   }

   public function checkEmail(Request $request)
   {
       // Check if user already exists
       $data = $request->all();
       $usersCount = User::where('email',$data['email'])->count();
       if($usersCount>0){
          echo "false";
       }else{
           echo "Success";die;
       }
       
   }
}

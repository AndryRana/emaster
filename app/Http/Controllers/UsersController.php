<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{

    public function userLoginRegister()
    {
        return view('users.login_register');
    }
    

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
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->admin = "0";
                $user->password = bcrypt($data['password']);
                $user->save();
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    return redirect('/cart');

                }
            }
        }
     
   }


    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                return redirect('/cart');
            }else{
                return redirect()->back()->with('flash_message_error', 'Identifiant ou mot de passe invalide!');
            }
        }
    }


   public function logout()
   {
       Auth::logout();
       return redirect('/');
   }


   public function checkEmail(Request $request)
   {
       // Check if user already exists
       $data = $request->all();
       $usersCount = User::where('email',$data['email'])->count();
       if($usersCount>0){
          echo "false";
       }else{
           echo "true";die;
       }
       
   }
}

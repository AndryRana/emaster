<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
                    Session::put('frontSession',$data['email']);
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
                Session::put('frontSession',$data['email']);
                return redirect('/cart');
            }else{
                return redirect()->back()->with('flash_message_error', 'Identifiant ou mot de passe invalide!');
            }
        }
    }


    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
        // echo "<pre>";print_r($userDetails);die;
        $countries = Country::get();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            if(empty($data['name'])){
                return redirect()->back()->with('flash_message_error', 'Merci de saisir votre Nom pour modifier votre compte!');
            }
            
            if(empty($data['address'])){
                $data['address'] = "";
            }

            if(empty($data['city'])){
                $data['city'] = "";
            }

            if(empty($data['state'])){
                $data['state'] = "";
            }

            if(empty($data['country'])){
                $data['country'] = "";
            }

            if(empty($data['pincode'])){
                $data['pincode'] = "";
            }

            if(empty($data['mobile'])){
                $data['mobile'] = "";
            }
            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            return redirect()->back()->with('flash_message_success', 'Votre compte a été mise à jour avec succès!');

        }
        return view('users.account')->with(compact('countries','userDetails'));
    }


    public function chkUserPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data);die;
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id',$user_id)->first();
        if(Hash::check($current_password,$check_password->password)){
            echo "true";die;
        }echo "false";die;
    }


    public function updatePassword(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            $old_pwd = User::where('id', Auth::User()->id)->first();
            $current_pwd = $data['current_pwd'];
            if(Hash::check($current_pwd,$old_pwd->password)){
                // Update password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
                return redirect()->back()->with('flash_message_success', 'Le mot de passe a été modifié avec succès!');
            }else{
                return redirect()->back()->with('flash_message_error', 'Le mot de passe actuel est incorrect!');
            }

        }
    }


   public function logout()
   {
       Auth::logout();
       Session::forget('frontSession');
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

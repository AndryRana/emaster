<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

// use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{

    public function userLoginRegister()
    {
        $meta_title = "S'identifier ou Créer un compte sur Emaster.com";
        return view('users.login_register')->with(compact('meta_title'));
    }


    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $userStatus = User::where('email', $data['email'])->first();
                if ($userStatus->status == 0) {
                    return redirect()->back()->with('flash_message_error', 'Votre compte n\'est pas activé\! Veuillez confirmer votre email pour l\'activer.');
                }

                session()->put('frontSession', $data['email']);
                if (!empty(session()->get('session_id'))) {
                    $session_id = session()->get('session_id');
                    DB::table('carts')->where('session_id', $session_id)->update(['user_email' => $data['email']]);
                }

                return redirect('/cart');
            } else {
                return redirect()->back()->with('flash_message_error', 'Identifiant ou mot de passe invalide!');
            }
        }
    } 



    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            // Check if user already exists
            $usersCount = User::where('email', $data['email'])->count();
            if ($usersCount > 0) {
                return redirect()->back()->with('flash_message_error', 'L\'adresse email existe déjà!');
            } else {
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->admin = "0";
                $user->password = bcrypt($data['password']);
                $user->save();

                // // Send Register Email
                // $email = $data['email'];
                // $messageData = ['email'=>$data['email'], 'name'=>$data['name']];
                // Mail::send('email.register',$messageData,function($message) use($email){
                //     $message->to($email)->subject('Création de compte sur le site Emaster');
                // });

                // Send  Confirmation Email
                $email = $data['email'];
                $messageData = ['email' => $data['email'], 'name' => $data['name'], 'code' => base64_encode($data['email'])];
                Mail::send('email.confirmation', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Confirmation de votre compte sur le site Emaster');
                });

                return redirect()->back()->with('flash_message_success', 'Merci de confirmer votre email pour activer votre compte!');

                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    session()->put('frontSession', $data['email']);

                    if (!empty(session()->get('session_id'))) {
                        $session_id = session()->get('session_id');
                        DB::table('carts')->where(['session_id', $session_id])->update(['user_email' => $data['email']]);
                    }

                    return redirect('/cart');
                }
            }
        }
    }


    public function forgotPassword(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            $userCount = User::where('email',$data['email'])->count();

            if($userCount == 0){
                return redirect()->back()->with('flash_message_error', 'Aucun compte n\'est attaché à cet email!' );
            }

            // Get user Details
            $userDetails = User::where('email', $data['email'])->first();

            // Generate random password
            $random_password = Str::random(8);

            // Encode/secure Password
            $new_password = bcrypt($random_password);

            // Update password
            User::where('email',$data['email'])->update([ 'password'=> $new_password]);

            // Send Forgot password Email code
            $email = $data['email'];
            $name = $userDetails->name;
            $messageData = [
                'email'=>$email,
                'name'=>$name,
                'password'=>$random_password
            ];
            Mail::send('email.forgotpassword',$messageData,function($message) use($email){
                $message->to($email)->subject('Votre nouveau mot de passe sur le site Emaster' );
            });

            return redirect('login-register')->with('flash_message_success','Votre nouveau mot de passe a été envoyé par email');
            
        }
        return view('users.forgot_password');
    }

    
    public function confirmAccount($email)
    {
        $email = base64_decode($email);
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {
                return redirect('login-register')->with('flash_message_success', 'Votre email a déjà été activé avec succès. Vous pouvez vous connecter maintenant.');
            } else {
                User::where('email', $email)->update(['status' => 1]);

                // send Welcome Email
                $messageData = ['email' => $email, 'name' => $userDetails->name];
                Mail::send('email.welcome', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Bienvenue sur le site Emaster');
                });

                return redirect('login-register')->with('flash_message_success', 'Votre email a déjà été activé avec succès. Vous pouvez vous connecter maintenant.');
            }
        } else {
            abort(404);
        }
    }



    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
        // echo "<pre>";print_r($userDetails);die;
        $countries = Country::get();

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            if (empty($data['name'])) {
                return redirect()->back()->with('flash_message_error', 'Merci de saisir votre Nom pour modifier votre compte!');
            }

            if (empty($data['address'])) {
                $data['address'] = "";
            }

            if (empty($data['city'])) {
                $data['city'] = "";
            }

            if (empty($data['state'])) {
                $data['state'] = "";
            }

            if (empty($data['country'])) {
                $data['country'] = "";
            }

            if (empty($data['pincode'])) {
                $data['pincode'] = "";
            }

            if (empty($data['mobile'])) {
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
        return view('users.account')->with(compact('countries', 'userDetails'));
    }


    public function chkUserPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data);die;
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id', $user_id)->first();
        if (Hash::check($current_password, $check_password->password)) {
            echo "true";
            die;
        }
        echo "false";
        die;
    }


    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            $old_pwd = User::where('id', Auth::User()->id)->first();
            $current_pwd = $data['current_pwd'];
            if (Hash::check($current_pwd, $old_pwd->password)) {
                // Update password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id', Auth::User()->id)->update(['password' => $new_pwd]);
                return redirect()->back()->with('flash_message_success', 'Le mot de passe a été modifié avec succès!');
            } else {
                return redirect()->back()->with('flash_message_error', 'Le mot de passe actuel est incorrect!');
            }
        }
    }


    public function logout()
    {
        Auth::logout();
        session()->forget('frontSession');
        session()->forget('session_id');
        return redirect('/');
    }


    public function checkEmail(Request $request)
    {
        // Check if user already exists
        $data = $request->all();
        $usersCount = User::where('email', $data['email'])->count();
        if ($usersCount > 0) {
            echo "false";
        } else {
            echo "true";
            die;
        }
    }


    public function viewUsers()
    {
        $users = User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }
}

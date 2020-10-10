<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use function GuzzleHttp\Psr7\hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
                $data = $request->input();
                $adminCount = Admin::where(['username'=> $data['username'], 'password'=>md5($data['password']), 'status'=>1])->count();

            if($adminCount > 0){
                session()->put('adminSession', $data['username']);
                return redirect('/admin/dashboard');
            }else{
                return redirect('/admin')->with('flash_message_error', 'Identifiant ou mot de passe incorrect');
            }

        }
        return view('admin.admin_login');
    }

    public function dashboard()
    {
        // if(Session::has('adminSession')) {
        //     // Perform all dashboard tasks
        // }else{
        //     return redirect('admin')->with('flash_message_error', 'Veuillez vous connecter pour accéder à votre compte Administrateur');
        // }
        return view('admin.dashboard');
    }


    public function settings()
    {
        $adminDetails = Admin::where(['username'=>session()->get('adminSession')])->first();

        // echo "<pre>"; print_r($adminDetails); die;

        return view('admin.settings')->with(compact('adminDetails'));
    }


    public function chkPassword(Request $request)
    {
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $adminCount = Admin::where(['username'=> session()->get('adminSession'), 'password'=>md5($data['current_pwd'])])->count();

        if($adminCount == 1){
            echo "true"; die;
        }else{
            echo "false"; die;
        }
    }

    public function updatePassword(Request $request)
    {
        if($request->isMethod('post')){
            $data =  $request->all();
            // echo "<pre>"; print_r($data); die;
            $adminCount = Admin::where(['username'=> session()->get('adminSession'), 'password'=>md5($data['current_pwd'])])->count();
            if($adminCount == 1){
                $password = md5($data['new_pwd']);
                Admin::where('username',Session::get('adminSession'))->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_message_success', 'Mise à jour du mot de passe avec succès!');
            }else{
                return redirect('/admin/settings')->with('flash_message_error', 'Mot de passe actuel incorrect!');
            }
        }
    }

    public function logout()
    {
        // Clear off all sessions
        Session::flush();
        return redirect('/admin')->with('flash_message_success', 'Déconnecté avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'admin' => '1'])) {
                // echo "Success"; die;
                // Adding session variable with Session::put
                // Session::put('adminSession', $data['email']);
                return redirect('admin/dashboard');
            } else {
                // 
                return redirect('/admin')->with('flash_message_error', 'Votre e-mail ou votre mot de passe n’est pas correct.');
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

    public function logout()
    {
        // Clear off all sessions
        Session::flush();
        return redirect('/admin')->with('flash_message_success', 'Déconnecté avec succès.');
    }
}

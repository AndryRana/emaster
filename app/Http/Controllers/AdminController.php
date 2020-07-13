<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('post')) {
            $data = $request->input();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'admin' => '1'])){
            echo "Success"; die;
            }else{
                echo "Failed"; die;
            }
        }
        return view('admin.admin_login');
    }
}

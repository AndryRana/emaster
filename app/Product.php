<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    
    public function getPrice()
    {
        $price = $this->price ;
        return number_format($price, 2, ',', ' ') . ' €';
    }

    public function attributes()
    {
        return $this->hasMany('App\ProductsAttribute', 'product_id');
    }

    public static function cartCount()
    {
        if(Auth::check()){
            // User is logged in. use Auth
            $user_email = Auth::user()->email;
            $cartCount = DB::table('carts')->where('user_email',$user_email)->sum('quantity');
            
        }else{
            // User is not logged in . Use the Session
            $session_id = Session::get('session_id');
            $cartCount = DB::table('carts')->where('session_id',$session_id)->sum('quantity');
        }
        return $cartCount;
    }

    public static function productCount($cat_id) 
    {
        $catCount = Product::where(['category_id'=>$cat_id,'status'=>1])->count();
        return $catCount;
    }
}

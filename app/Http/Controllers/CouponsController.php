<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    
   public function addCoupon(Request $request)
   {
       return view('admin.coupons.add_coupon');
   }
}

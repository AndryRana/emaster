<?php

namespace App\Http\Controllers;

use App\ShippingCharge;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
   public function viewShipping()
   {
        $shipping_charges = ShippingCharge::get();
        // $shipping_charges = json_decode(json_encode($shipping_charges));
        // echo "<pre>"; print_r($shipping_charges);die;
        return view('admin.shipping.view_shipping')->with(compact('shipping_charges'));
   }

   public function editShipping(Request $request, $id)
   {
       if($request->isMethod('post')){
           $data = $request->all();
        //    echo "<pre>"; print_r($data); die;
        ShippingCharge::where('id',$id)->update(['shipping_charges0_500g'=>$data['shipping_charges0_500g'],'shipping_charges501_1000g'=>$data['shipping_charges501_1000g'],
        'shipping_charges1001_2000g'=>$data['shipping_charges1001_2000g'],'shipping_charges2001g_5000g'=>$data['shipping_charges2001g_5000g']]);
        return redirect()->back()->with('flash_message_success','Le frais de port a été mise à jour avec succès!');
       }
       $shippingDetails = ShippingCharge::where('id',$id)->first();
       return view('admin.shipping.edit_shipping')->with(compact('shippingDetails'));
   }
}

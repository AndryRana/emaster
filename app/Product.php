<?php

namespace App;

use Cartalyst\Stripe\Api\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;
    
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

    public static function getProductStock($product_id,$product_size)
    {
        $getProductStock = ProductsAttribute::select('stock')->where([ 'product_id'=>$product_id, 'size'=>$product_size])->first();
        return $getProductStock->stock;
    }

    public static function getProductPrice($product_id,$product_size){
        $getProductPrice = ProductsAttribute::select('price')->where(['product_id'=>$product_id,'size'=>$product_size])->first();
        return $getProductPrice->price;
    }

    public static function deleteCartProduct($product_id,$user_email){
        DB::table('carts')->where(['product_id'=>$product_id,'user_email'=>$user_email])->delete();
    }

    public static function getProductStatus($product_id){
        $getProductStatus = Product::select('status')->where('id',$product_id)->first();
        return $getProductStatus->status;
    }

    public static function getCategoryStatus($category_id){
        $getCategoryStatus = Category::select('status')->where('id',$category_id)->first();
        return $getCategoryStatus->status;
    }

    public static function getAttributeCount($product_id,$product_size){
        $getAttributeCount = ProductsAttribute::where([ 'product_id'=>$product_id, 'size'=>$product_size])->count();
        return $getAttributeCount;
    }

    public static function getShippingCharges($total_weight, $country)
    {
        $shippingDetails = ShippingCharge::where('country',$country)->first();
        if($total_weight>0){
            if($total_weight>0 && $total_weight <= 500){
                $shipping_charges = $shippingDetails->shipping_charges0_500g;
            }else if($total_weight>501 && $total_weight <= 1000){
                $shipping_charges = $shippingDetails->shipping_charges501_1000g;
            }else if($total_weight>1001 && $total_weight <= 2000){
                $shipping_charges = $shippingDetails->shipping_charges1001_2000g;
            }else if($total_weight>2001 && $total_weight <= 5000){
                $shipping_charges = $shippingDetails->shipping_charges2001g_5000g;
            }else{
                $shipping_charges = 0;
            }
        }else{
            $shipping_charges = 0;
        }
        return $shipping_charges;
    }


    public  static function getGrandTotal(){
        $getGrandTotal = "";
        $username = Auth::user()->email;
        $userCart = DB::table('carts')->where('user_email', $username)->get();
        $userCart = json_decode(json_encode($userCart),true);
        // echo "<pre>";print_r($userCart); die;
        foreach($userCart as $product){
            $productPrice = ProductsAttribute::where(['product_id'=>$product['product_id'],'size'=>$product['size']])->first();
            $priceArray[] = $productPrice->price;
        }
        // echo print_r($priceArray);die;
        $getGrandTotal = array_sum($priceArray) - session()->get('CouponAmount') + session()->get('shippingCharges');

        return $getGrandTotal;
    }


      /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $products = Product::orderBy('id', 'DESC')->get();
        foreach ($products as $key => $value) {
            $category_name = Category::where(['id' => $value->category_id])->first();
            $products[$key]->category_name = $category_name->name;
            // echo "<pre>"; print_r($category_name);die;    
            foreach($products as $pro)
            $extraFields = [
                'categories' => Category::all()->pluck('name')->toArray(),
            ];
        }
      

        return array_merge($array,$extraFields);
    }

}

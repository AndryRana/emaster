<?php

namespace App\Http\Controllers;

use App\Category;
use App\Country;
use App\Coupon;
use App\DeliveryAddress;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\User;
use Illuminate\Contracts\Session\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function addProduct(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            if (empty($data['category_id'])) {
                return redirect()->back()->with('flash_message_error', 'Veuillez choisir une catégorie!');
            }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if (!empty($data['description'])) {
                $product->description = $data['description'];
            } else {
                $product->description = '';
            }

            if (!empty($data['care'])) {
                $product->care = $data['care'];
            } else {
                $product->care = '';
            }

            $product->price = $data['price'];

            // Upload Image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/product/large/' . $fileName;
                    $medium_image_path = 'images/backend_images/product/medium/' . $fileName;
                    $small_image_path = 'images/backend_images/product/small/' . $fileName;
                    // Resize Image code
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                    //  Store image name in products table
                    $product->image = $fileName;
                }
            }

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            $product->status = $status;

            $product->save();
            // return redirect()->back()->with('flash_message_success', 'Le produit a été ajouté avec succès!');
            return redirect('/admin/view-products')->with('flash_message_success', 'Le produit a été ajouté avec succès!');
        }

        // Categories drop down start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_drop_down = "<option value='' selected disabled>Choisir une catégorie</option>";
        foreach ($categories as $cat) {
            $categories_drop_down .= "<option value='" . $cat->id . "'>" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_drop_down .= "<option value='" . $sub_cat->id . "'>&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }
        // Categories drop down ends

        return view('admin.products.add_product')->with(compact('categories_drop_down'));
    }


    public function editProduct(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;

            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/product/large/' . $fileName;
                    $medium_image_path = 'images/backend_images/product/medium/' . $fileName;
                    $small_image_path = 'images/backend_images/product/small/' . $fileName;
                    // Resize Image code
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                }
            } else if (!empty($data['current_image'])) {
                $fileName = $data['current_image'];
            } else {
                $filename = '';
            }


            if (empty($data['description'])) {
                $data['description'] = '';
            }

            if (empty($data['care'])) {
                $data['care'] = '';
            }

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            Product::where(['id' => $id])->update([
                'category_id' => $data['category_id'], 'product_name' => $data['product_name'], 'product_code' => $data['product_code'],
                'product_color' => $data['product_color'], 'description' => $data['description'], 'care' => $data['care'], 'price' => $data['price'], 'image' => $fileName, 'status' =>$status
            ]);

            return redirect()->back()->with('flash_message_success', 'Le produit a été modifié avec succès!');
        }


        // Get products
        $productDetails = Product::where(['id' => $id])->first();

        // Categories drop down start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_drop_down = "<option value='' selected disabled>Choisir une catégorie</option>";
        foreach ($categories as $cat) {
            if ($cat->id == $productDetails->category_id) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $categories_drop_down .= "<option value='" . $cat->id . "' " . $selected . ">" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                if ($sub_cat->id == $productDetails->category_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $categories_drop_down .= "<option value='" . $sub_cat->id . "'  " . $selected . ">&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }
        // Categories drop down ends

        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_drop_down'));
    }

    public function deleteProduct($id = null)
    {
        Product::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Le produit a été supprimé avec succès!');
    }


    public function viewProducts()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        foreach ($products as $key => $value) {
            $category_name = Category::where(['id' => $value->category_id])->first();
            $products[$key]->category_name = $category_name->name;
            // echo "<pre>"; print_r($category_name);die;    
        }
        // echo "<pre>"; print_r($products);die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProductImage($id = null)
    {
        //  Get Product Image Name
        $productImage = Product::where(['id' => $id])->first();
        // echo $productImage->image;die;

        // Get Product Image PAths
        $large_image_path = 'images/backend_images/product/large/';
        $medium_image_path = 'images/backend_images/product/medium/';
        $small_image_path = 'images/backend_images/product/small/';

        // Delete Large Image if not exists in Folder
        if (file_exists($large_image_path . $productImage->image)) {
            // echo $large_image_path.$productImage->image;die;
            unlink($large_image_path . $productImage->image);
        }

        // Delete medium Image if not exists in Folder
        if (file_exists($medium_image_path . $productImage->image)) {
            // echo $medium_image_path.$productImage->image;die;
            unlink($medium_image_path . $productImage->image);
        }

        // Delete small Image if not exists in Folder
        if (file_exists($small_image_path . $productImage->image)) {
            // echo $small_image_path.$productImage->image;die;
            unlink($small_image_path . $productImage->image);
        }

        Product::where(['id' => $id])->update(['image' => '']);
        return redirect()->back()->with('flash_message_success', 'L\'image du produit a été supprimée avec succès!');
    }


    public function addAttributes(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        // $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>"; print_r($productDetails);die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            //    echo "<pre>"; print_r($data);die;
            foreach ($data['sku'] as $key => $val) {
                if (!empty($val)) {
                    $attrCountSKU = ProductsAttribute::where(['sku' => $val])->count();
                    if ($attrCountSKU > 0) {
                        return redirect('admin/add-attributes/' . $id)->with('flash_message_error', 'SKU existe déjà. Entrer un nouveau SKU.');
                    }
                    $attrCountSizes = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if ($attrCountSizes > 0) {
                        return redirect('admin/add-attributes/' . $id)->with('flash_message_error', ' La taille "' . $data['size'][$key] . '" existe déjà. Entrer une nouvelle taille.');
                    }
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }

            return redirect('admin/add-attributes/' . $id)->with('flash_message_success', 'Les attributs de ce produit ont bien été ajoutés');
        }
        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }


    public function editAttributes(Request $request, $id = null)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            foreach ($data['idAttr'] as $key => $attr) {
               ProductsAttribute::where(['id' =>$data['idAttr'][$key]])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success', 'Mise à jour de(s) attribut(s) de produits avec succès!');
        }
    }


    public function addImages(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        // $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>"; print_r($productDetails);die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                // echo "<pre>"; print_r($files);die;
                foreach ($files as $file) {
                    //  Upload Images after resize
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/product/large/' . $fileName;
                    $medium_image_path = 'images/backend_images/product/medium/' . $fileName;
                    $small_image_path = 'images/backend_images/product/small/' . $fileName;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);

                    $image->image = $fileName;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }
            
            return redirect('admin/add-images/'.$id)->with('flash_message_success', 'Image(s) du produit ajoutée(s) avec succès');
        }
        $productsImages = ProductsImage::where(['product_id' =>$id])->get();

        return view('admin.products.add_images')->with(compact('productDetails', 'productsImages'));
    }

    public function deleteAltImage($id = null)
    {
        //  Get Product Image Name
        $productImage = ProductsImage::where(['id' => $id])->first();
        // echo $productImage->image;die;

        // Get Product Image PAths
        $large_image_path = 'images/backend_images/product/large/';
        $medium_image_path = 'images/backend_images/product/medium/';
        $small_image_path = 'images/backend_images/product/small/';

        // Delete Large Image if not exists in Folder
        if (file_exists($large_image_path . $productImage->image)) {
            // echo $large_image_path.$productImage->image;die;
            unlink($large_image_path . $productImage->image);
        }

        // Delete medium Image if not exists in Folder
        if (file_exists($medium_image_path . $productImage->image)) {
            // echo $medium_image_path.$productImage->image;die;
            unlink($medium_image_path . $productImage->image);
        }

        // Delete small Image if not exists in Folder
        if (file_exists($small_image_path . $productImage->image)) {
            // echo $small_image_path.$productImage->image;die;
            unlink($small_image_path . $productImage->image);
        }

        ProductsImage::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'image(s) supplémentaire(s) du produit supprimée avec succès!');
    }

    public function deleteAttribute($id = null)
    {
        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Les attributs de ce produit ont été supprimés avec succès!');
    }


    public function products($url = null)
    {
        // show 404 page if Category URL doesn't exist
        $countCategory = Category::where(['url' => $url, 'status' => 1])->count();
        // echo "<pre>";print_r($countCategory);die;
        if ($countCategory == 0) {
            abort(404);
        }
        //  Get all Categories and Sub Categories
        $categories =  Category::with('categories')->where(['parent_id' => 0])->get();
        $categoryDetails = Category::where(['url' => $url])->first();
        // echo $categoryDetails; die;

        if ($categoryDetails->parent_id == 0) {

            $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
            foreach ($subCategories as $subcat) {
                $cat_ids[] = $subcat->id;
            }

            $productsAll = Product::whereIn('category_id', $cat_ids)->orWhere(['category_id' => $categoryDetails->id])->where('status',1)->get();
        } else {
            $productsAll = Product::where(['category_id' => $categoryDetails->id])->where('status',1)->get();
        }

        return view('products.listing')->with(compact('categories', 'categoryDetails', 'productsAll'));
    }

    public function product($id = null)
    {
        // show 404 page if product is disabled
        $productsCount = Product::where(['id'=>$id, 'status'=> 1])->count();
        if($productsCount == 0) {
            abort(404);
        }
        //  Get Product Details
        $productDetails = Product::with('attributes')->where('id', $id)->first();
        // $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>";print_r($productDetails);die;
        
        $relatedProducts = Product::where('id','!=',$id)->where(['category_id'=>$productDetails->category_id])->get();
        // $relatedProducts = json_decode(json_encode($relatedProducts));
        // echo "<pre>";print_r($relatedProducts);die;
        
        // foreach($relatedProducts->chunk(3) as $chunk) {
        //     foreach($chunk as $item){
        //         echo $item; echo "<br>";
        //     }
        //     echo "<br><br><br>";
        // }
        // die;

        //  Get all Categories and Sub Categories
        $categories =  Category::with('categories')->where(['parent_id' => 0])->get();
        
        // Get Product Alternate Images
        $productAltImages = ProductsImage::where('product_id',$id)->get();
        // $productAltImages = json_decode(json_encode($productAltImages));
        // echo "<pre>";print_r($productAltImages);die;

       $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');

        return view('products.detail')->with(compact('productDetails', 'categories','productAltImages', 'total_stock','relatedProducts'));
    }


    public function getProductPrice(Request $request)
    {
        $data = $request->all();
        // echo "<pre>";print_r($data);die;
        $proArr = explode("-", $data['idSize']);
        // echo $proArr[0]; echo $proArr[1]; die;
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        // echo $proAttr->getAttrPrice();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
        
    }



    public function addtocart(Request $request)
    {
        session()->forget('CouponAmount');
        session()->forget('CouponCode');

        $data = $request->all(); 
        // echo "<pre>";print_r($data);die;

        if(empty($data['user_email'])){
            $data['user_email'] = '' ;
        }

        if(empty($data['session_id'])){
            $data['session_id'] = '' ;
        }

        $session_id = session()->get('session_id');
        if(empty($session_id)){
            $session_id = Str::random(40);
            session()->put('session_id',$session_id);
        }

        $sizeArr = explode("-", $data['size']);

        $countProducts = DB::table('cart')->where(['product_id'=>$data['product_id'],'product_color'=>$data['product_color'],
        'size'=>$sizeArr[1],'session_id' => $session_id])->count();
        // echo $countProducts;die;
        if($countProducts>0){
            return redirect()->back()->with('flash_message_error', 'Le produit existe déjà dans le panier!');
        }else{

            $getSKU = ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'],'size'=>$sizeArr[1]])->first();

            DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],
            'product_code'=>$getSKU->sku,'product_color'=>$data['product_color'],'price'=>$data['price'],'size'=>$sizeArr[1],
            'quantity'=>$data['quantity'],'user_email' => $data['user_email'],'session_id' => $session_id
             ]);
        }
        
         return redirect('cart')->with('flash_message_success','Le produit a bien été ajouté au panier!');
    }


    public function cart(Request $request)
    {

        $session_id = session()->get('session_id');
        $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
        foreach ($userCart as $key => $product) {
            // echo $product->product_id;
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        // echo "<pre>"; print_r($userCart); die;

        return view('products.cart')->with(compact('userCart'));
    }



    public function deleteCartProduct($id = null)
    {

        session()->forget('CouponAmount');
        session()->forget('CouponCode');
        // echo $id;die;
        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success', 'Le produit a bien été supprimer du panier!');
    }


    public function updateCartQuantity($id = null, $quantity=null)
    {
        session()->forget('CouponAmount');
        session()->forget('CouponCode');
        
        $getCartDetails = DB::table('cart')->where('id', $id)->first();
        $getAttributeStock = ProductsAttribute::where('sku', $getCartDetails->product_code)->first(); 
        // echo $getAttributeStock->stock; echo "--";
        $updated_quantity = $getCartDetails->quantity+ $quantity;
        if($getAttributeStock->stock >= $updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity', $quantity);
            return redirect('cart')->with('flash_message_success', 'La quantité a été mise à jour avec succès!');
        }else{
            return redirect('cart')->with('flash_message_error', 'La quantité du produit demandée n\'est pas disponible!');
        }

    }


    public function applyCoupon(Request $request)
    {

        session()->forget('CouponAmount');
        session()->forget('CouponCode');


        $data = $request->all();
        // echo "<pre>"; print_r($data);die;
        $couponCount = Coupon::where('coupon_code', $data['coupon_code'])->count();
        if($couponCount == 0) {
            return redirect()->back()->with('flash_message_error', 'Ce coupon n\'existe pas!');
        }else{
            // echo "Success";die;
            // Get coupon details
            $couponDetails = Coupon::where('coupon_code', $data['coupon_code'])->first();

            // if coupon is inactive
            if($couponDetails->status==0){
                return redirect()->back()->with('flash_message_error', 'Ce coupon n\'est pas activé!'); 
            }

            // If coupon is Expired
           $expiry_date = $couponDetails->expiry_date;
           $current_date = date('Y-m-d');
            if($expiry_date < $current_date){
                return redirect()->back()->with('flash_message_error', 'Ce coupon est déjà expiré!'); 
            }

            // Coupon is valid for Discount

            // Get cart Total amount
            $session_id = session()->get('session_id');
            $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
            $total_amount = 0;
            foreach ($userCart as $item) {
                $total_amount = $total_amount + ($item->price * $item->quantity);
            }


            //  Check if the amount type is fixed or Percentage
            if($couponDetails->amount_type == 'Fixe'){
               $couponAmount = $couponDetails->amount; 
            }else{
               $couponAmount = $total_amount * ($couponDetails->amount/100) ;
            }

            // echo $couponAmount; die;

            // Add coupon code and Amount
            session()->put('CouponAmount', $couponAmount);
            session()->put('CouponCode', $data['coupon_code']);

            return redirect()->back()->with('flash_message_success', 'La réduction s\'est bien appliquée!');
        }
    }


    public function checkout(Request $request)
    {
        $user_id =  Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();

        // Check if Shipping address exists
        $shippingCount = DeliveryAddress::where('user_id', $user_id)->count();
        $shippingDetails = array();
        if($shippingCount>0){
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }

        // Update cart table with user email
        $session_id = session()->get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);


        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            // dump($data);

            // Return to checkout page if any of Field is empty
            if(empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state'])
            || empty($data['billing_country']) || empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) 
            || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country'])
            || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])  ){
                return redirect()->back()->with('flash_message_error', 'Merci de remplir tous les champs pour passer la commande!');
            }

            //  Update User Details
            User::where('id', $user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],
            'country'=>$data['billing_country'],'pincode'=>$data['billing_pincode'], 'mobile'=>$data['billing_mobile']
            ]);
            
            if($shippingCount>0){
                //  Update Shipping address
                DeliveryAddress::where('user_id', $user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],
                'country'=>$data['shipping_country'],'pincode'=>$data['shipping_pincode'], 'mobile'=>$data['shipping_mobile']]);
            }else{
                // Add new shipping Address
                $shipping = new DeliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->name = $data['shipping_name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->country = $data['shipping_country'];
                $shipping->pincode = $data['shipping_pincode'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();
            }
            return redirect()->action('ProductsController@orderReview');
        }

        return view('products.checkout')->with(compact('userDetails','countries','shippingDetails'));
    }


    public function orderReview()
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id',$user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        // $shippingDetails = json_decode(json_encode($shippingDetails));
        // echo "<pre>";print_r($shippingDetails);die;
        // dump($userDetails);
        $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        foreach ($userCart as $key => $product) {
            // echo $product->product_id;
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        // echo "<pre>";print_r($userCart);die;
        return view('products.order_review')->with(compact('userDetails', 'shippingDetails','userCart'));
    }
}

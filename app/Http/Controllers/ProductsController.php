<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\Country;
use App\Coupon;
use App\DeliveryAddress;
use App\Exports\productExport;
use App\Order;
use App\OrdersProduct;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\User;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Charge;
use Stripe\Stripe;
use Dompdf\Dompdf;

use function GuzzleHttp\json_decode;

class ProductsController extends Controller
{
    public function addProduct(Request $request)
    {
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
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
            if (!empty($data['weight'])) {
                $product->weight = $data['weight'];
            } else {
                $product->weight = 0;
            }
            if (!empty($data['description'])) {
                $product->description = $data['description'];
            } else {
                $product->description = '';
            }

            if (!empty($data['sleeve'])) {
                $product->sleeve = $data['sleeve'];
            } else {
                $product->sleeve = '';
            }

            if (!empty($data['pattern'])) {
                $product->pattern = $data['pattern'];
            } else {
                $product->pattern = '';
            }

            if (!empty($data['care'])) {
                $product->care = $data['care'];
            } else {
                $product->care = '';
            }

            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }

            if (empty($data['feature_item'])) {
                $feature_item = 0;
            } else {
                $feature_item = 1;
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

            // Upload video
            if($request->hasFile('video')){
                $video_tmp = $request->file('video');
                $video_name = $video_tmp->getClientOriginalName();
                $video_path = 'videos/';
                $video_tmp->move($video_path,$video_name);
                $product->video = $video_name;
            }
          

            $product->feature_item = $feature_item;
            $product->status = $status;

            $product->save();
            // return redirect()->back()->with('flash_message_success', 'Le produit a été ajouté avec succès!');
            return redirect('/admin/view-products')->with('flash_message_success', 'Le produit a été ajouté avec succès!');
        }

        // Categories drop down start
        $categories = Category::where(['parent_id' => 0])->get();
       
        $categories_drop_down = "<option value='none' selected disabled>Choisir une catégorie</option>";
        foreach ($categories as $cat) {
            $categories_drop_down .= "<option value='" . $cat->id . "'>" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_drop_down .= "<option value='" . $sub_cat->id . "'>&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }

        // Categories drop down ends
        $sleeveArray = array('Full Sleeve','Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $patternArray = array('Checked','Plain','Printed','Self','Solid');

        return view('admin.products.add_product')->with(compact('categories_drop_down','sleeveArray','patternArray'));
    }


    public function editProduct(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
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

            // Upload video
            if($request->hasFile('video')){
                $video_tmp = $request->file('video');
                $video_name = $video_tmp->getClientOriginalName();
                $video_path = 'videos/';
                $video_tmp->move($video_path,$video_name);
                $videoName = $video_name;
            }else if (!empty($data['current_video'])) {
                $videoName = $data['current_video'];
            }else {
                $videoName = '';
            }

            if (empty($data['description'])) {
                $data['description'] = '';
            }

            if (!empty($data['sleeve'])) {
                $sleeve = $data['sleeve'];
            } else {
                $sleeve = '';
            }

            if (!empty($data['pattern'])) {
                $pattern = $data['pattern'];
            } else {
                $pattern = '';
            }

            if (empty($data['care'])) {
                $data['care'] = '';
            }

            if (empty($data['feature_item'])) {
                $feature_item = 0;
            } else {
                $feature_item = 1;
            }
            
            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }

            Product::where(['id' => $id])->update([
                'category_id' => $data['category_id'], 'product_name' => $data['product_name'], 'product_code' => $data['product_code'],
                'product_color' => $data['product_color'], 'description' => $data['description'], 'care' => $data['care'], 'price' => $data['price'],'weight' => $data['weight'],
                 'image' => $fileName,'video' => $videoName, 'sleeve' =>$sleeve,'pattern' =>$pattern, 'status' => $status, 'feature_item' => $feature_item
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

        $sleeveArray = array('Full Sleeve','Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $patternArray = array('Checked','Plain','Printed','Self','Solid');

        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_drop_down','sleeveArray','patternArray'));
    }

    public function deleteProduct($id = null)
    {
        Product::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Le produit a été supprimé avec succès!');
    }


    public function viewProducts()
    {
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
        $products = Product::orderBy('id', 'DESC')->get();
        
        foreach ($products as $key => $value) {
            $category_name = Category::where(['id' => $value->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        
        // echo "<pre>"; print_r($products);die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProductImage($id)
    {
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
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


    public function deleteProductvideo($id)
    {
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
        //  Get Video Name
        $productVideo = Product::select('video')->where('id',$id)->first();

        // Get videoPath
        $video_path = "videos/";

        // Delete Video if esists in videos folder
        if(file_exists($video_path.$productVideo->video)){
            unlink($video_path.$productVideo->video);
        }

        // Delete Video from Product Table
        Product::where('id',$id)->update(['video'=>'']);

        return redirect()->back()->with('flash_message_success', 'La vidéo du produit a été supprimée avec succès!');
    }

    
    /**
     * addAttributes
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function addAttributes(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
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

    
    /**
     * editAttributes
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function editAttributes(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            foreach ($data['idAttr'] as $key => $attr) {
                ProductsAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success', 'Mise à jour de(s) attribut(s) de produits avec succès!');
        }
    }


    public function addImages(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
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

            return redirect('admin/add-images/' . $id)->with('flash_message_success', 'Image(s) du produit ajoutée(s) avec succès');
        }
        $productsImages = ProductsImage::where(['product_id' => $id])->get();

        return view('admin.products.add_images')->with(compact('productDetails', 'productsImages'));
    }

    public function deleteAltImage($id = null)
    {
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
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
        if(Session::get('adminDetails')['products_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Les attributs de ce produit ont été supprimés avec succès!');
    }


    public function products($url=null)
    {
        // show 404 page if Category URL doesn't exist
        $countCategory = Category::where(['url'=> $url, 'status' => 1])->count();
        // echo "<pre>";print_r($countCategory);die;
        if ($countCategory == 0) {
            abort(404);
        }
        //  Get all Categories and Sub Categories
        $categories =  Category::with('categories')->where(['parent_id' => 0])->get();
        $categoryDetails = Category::where(['url'=>$url])->first();
        // echo $categoryDetails; die;

        if ($categoryDetails->parent_id == 0) {

            $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
            foreach ($subCategories as $subcat) {
                $cat_ids[] = $subcat->id;
            }
            $productsAll = Product::whereIn('products.category_id', $cat_ids)->where('products.status', 1)->orderBy('products.id','Desc');
            $breadcrumb = "<a href='/'>Home</a> / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a>";
        } else {
            $productsAll = Product::where(['products.category_id' => $categoryDetails->id])->where('products.status', 1)->orderBy('products.id','Desc');
            $mainCategory = Category::where('id',$categoryDetails->parent_id)->first();
            $breadcrumb = "<a href='/'>Home</a> / <a href='".$mainCategory->url."'>".$mainCategory->name."</a> / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a>";
        }

        if(!empty($_GET['color'])){
            $colorArray = explode('-',$_GET['color']);
            $productsAll = $productsAll->whereIn('products.product_color',$colorArray);
        }

        if(!empty($_GET['sleeve'])){
            $sleeveArray = explode('-',$_GET['sleeve']);
            $productsAll = $productsAll->whereIn('products.sleeve',$sleeveArray);
        }

        if(!empty($_GET['pattern'])){
            $patternArray = explode('-',$_GET['pattern']);
            $productsAll = $productsAll->whereIn('products.pattern',$patternArray);
        }

        if(!empty($_GET['size'])){
            $sizeArray = explode('-',$_GET['size']);
            $productsAll = $productsAll->join('products_attributes', 'products_attributes.product_id','=', 'product_id')
            ->select('products.*','products_attributes.product_id','products_attributes.size')
            ->groupBy('products_attributes.product_id')
            ->whereIn('products_attributes.size',$sizeArray);
        }



        $productsAll = $productsAll->paginate(6);
        // $productsAll = json_decode(json_encode($productsAll));
        // echo "<pre>"; print_r($productsAll); die;
        // $colorArray = array('Black','Blue','Brown','Gold','Green','Orange','Pink','Purple','Red','Silver','White','Yellow');

        $colorArray = Product::select('product_color')->groupBy('product_color')->get();
        $colorArray = Arr::flatten(json_decode(json_encode($colorArray),true));
        // echo "<pre>";print_r($colorArray);die;

        $sleeveArray = Product::select('sleeve')->where('sleeve','!=','')->groupBy('sleeve')->get();
        $sleeveArray = Arr::flatten(json_decode(json_encode($sleeveArray),true));
        // echo "<pre>";print_r($sleeveArray);die;

        $patternArray = Product::select('pattern')->where('pattern','!=','')->groupBy('pattern')->get();
        $patternArray = Arr::flatten(json_decode(json_encode($patternArray),true));
        // echo "<pre>";print_r($patternArray);die;

        $sizesArray = ProductsAttribute::select('size')->groupBy('size')->get();
        $sizesArray = Arr::flatten(json_decode(json_encode($sizesArray),true));
        // echo "<pre>";print_r($sizesArray);die;

        $meta_title = $categoryDetails->meta_title;
        $meta_description = $categoryDetails->meta_description;
        $meta_keywords = $categoryDetails->meta_keywords;
        return view('products.listing')->with(compact('categories', 'categoryDetails', 'productsAll','meta_title','meta_description','meta_keywords','url','colorArray','sleeveArray','patternArray', 'sizesArray','breadcrumb'));
    }



    public function filter(Request $request )
    {
        
        $data = $request->all();
        // echo "<pre>";print_r($data);die;
        $colorUrl="";
        if(!empty($data['colorFilter'])){
            foreach($data['colorFilter'] as $color){
                if(empty($colorUrl)){
                    $colorUrl = "&color=".$color;
                }else{
                    $colorUrl .= "-".$color;
                }
            }
        }

        $sleeveUrl="";
        if(!empty($data['sleeveFilter'])){
            foreach($data['sleeveFilter'] as $sleeve){
                if(empty($sleeveUrl)){
                    $sleeveUrl = "&sleeve=".$sleeve;
                }else{
                    $sleeveUrl .= "-".$sleeve;
                }
            }
        }

        $patternUrl="";
        if(!empty($data['patternFilter'])){
            foreach($data['patternFilter'] as $pattern){
                if(empty($patternUrl)){
                    $patternUrl = "&pattern=".$pattern;
                }else{
                    $patternUrl .= "-".$pattern;
                }
            }
        }

        $sizeUrl="";
        if(!empty($data['sizeFilter'])){
            foreach($data['sizeFilter'] as $size){
                if(empty($sizeUrl)){
                    $sizeUrl = "&size=".$size;
                }else{
                    $sizeUrl .= "-".$size;
                }
            }
        }
        $finalUrl = "products/".$data['url']."?".$colorUrl.$sleeveUrl.$patternUrl.$sizeUrl;
        return redirect::to($finalUrl);
    }


    /**
     * @param Request $request
     * SEARCH PRODUCT
     * @return [type]
     */
    public function searchProducts(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
                $request->validate([
                    'product' => 'required|min:3',
                ]);
            // echo "<pre>";print_r($data);die;

            $categories = Category::with('categories')->where(['parent_id' => 0])->get();

            $search_product = $data['product'];
            // $productsAll = Product::where('product_name', 'like', '%' . $search_product . '%')->orwhere('product_code', $search_product)->where('status', 1)->get();
             
            $productsAll = Product::where(function($query) use($search_product){
                $query->where('product_name','like','%'.$search_product.'%')
                ->orWhere('product_code','like','%'.$search_product.'%' )
                ->orWhere('description','like','%'.$search_product.'%')
                ->orWhere('product_color','like','%'.$search_product.'%');
            })->where('status',1)->get();

            $breadcrumb = "<a href='/'>Home</a> / " .$search_product;

            return view('products.listing')->with(compact('categories', 'productsAll', 'search_product','breadcrumb'));
        }
    }


    public function searchAlgolia(Request $request)
    {
        return view('products.search-results-algolia');
    }


    public function product($id = null)
    {
        // show 404 page if product is disabled
        $productsCount = Product::where(['id' => $id, 'status' => 1])->count();
        if ($productsCount == 0) {
            abort(404);
        }
        //  Get Product Details
        $productDetails = Product::with('attributes')->where('id', $id)->first();
        // $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>";print_r($productDetails);die;

        $relatedProducts = Product::where('id', '!=', $id)->where(['category_id' => $productDetails->category_id])->get();
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
        // echo "<pre>";print_r($categories);die;

        $categoryDetails = Category::where('id',$productDetails->category_id)->first();
        // echo $categoryDetails; die;

        if ($categoryDetails->parent_id == 0) {

            $breadcrumb = "<a href='/'>Home</a> / <a href='/products/".$categoryDetails->url."'>".$categoryDetails->name."</a> / ".$productDetails->product_name;
        } else {
            $mainCategory = Category::where('id',$categoryDetails->parent_id)->first();
            $breadcrumb = "<a href='/'>Home</a> / <a href='/products/".$mainCategory->url."'>".$mainCategory->name."</a> / <a href='/products/".$categoryDetails->url."'>".$categoryDetails->name."</a> / ".$productDetails->product_name;
        }        

        // Get Product Alternate Images
        $productAltImages = ProductsImage::where('product_id', $id)->get();
        // $productAltImages = json_decode(json_encode($productAltImages));
        // echo "<pre>";print_r($productAltImages);die;

        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');

        $meta_title = $productDetails->product_name;
        $meta_description = $productDetails->description;
        $meta_keywords = $productDetails->product_name;

        return view('products.detail')->with(compact('productDetails', 'categories', 'productAltImages', 'total_stock', 'relatedProducts','meta_title', 'meta_description', 'meta_keywords', 'breadcrumb'));
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
        //  echo "<pre>";print_r($data);die;

        if(!empty($data['wishListButton']) && $data['wishListButton']=="Wish List" ){
            // echo "Wish List is selected";die;

            // Check User is logged in 
            if(!Auth::check()){
                return redirect()->back()->with('flash_message_error','Merci de vous connecter afin d\'ajouter le produit dans votre liste');
            }

            // Check Size selected
            if(empty($data['size'])){
                return redirect()->back()->with('flash_message_error','Merci de selectionner la taille afin d\'ajouter le produit dans votre liste');
            }

            // Get productSize
            $sizeIDArr = explode("-", $data['size']);
            $product_size = $sizeIDArr[1];
            
            // Get the product price
            $proPrice = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$product_size])->first();
            $product_price = $proPrice->price;

            // Get User email/Username
            $user_email = Auth::user()->email;

            // Set Quantity
            $quantity = 1;

            // Get current Date
            $created_at = Carbon::now();

            $wishListCount = DB::table('wish_list')->where(['user_email'=>$user_email,'product_id'=>$data['product_id'],
            'product_color'=>$data['product_color'],'size'=>$product_size])->count();
            // echo "<pre>";print_r($wishListCount);die;

            if($wishListCount>0){
                return redirect()->back()->with('flash_message_error','Le produit est déjà dans votre liste!');
            }else{
                // Insert Product in wish List 
                DB::table('wish_list')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],
                'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'price'=>$product_price,
                'size'=>$product_size,'quantity'=>$quantity,'user_email'=>$user_email,'created_at'=>$created_at]);
                return redirect()->back()->with('flash_message_success', 'Le produit a été ajouté à  votre liste avec succès');
            }
        }else{

            // If product added from wish list
            if(!empty($data['cartButton']) && $data['cartButton']=="Add to Cart"){
                $data['quantity'] = 1;
            
            }
    
            // Check product stock is available or not
            $product_size = explode("-", $data['size']);
            if(empty($data['size'])){
                return redirect()->back()->with('flash_message_error','Merci de selectionner la taille afin d\'ajouter le produit dans votre panier');
            }
            $getProductStock = ProductsAttribute::where(['product_id' => $data['product_id'], 'size' => $product_size[1]])->first();
            // echo $getProductStock->stock;die;
    
            if ($getProductStock->stock < $data['quantity']) {
                return redirect()->back()->with('flash_message_error', 'La quantité du produit demandé n\'est pas disponible!');
            }
    
            
            if (empty(Auth::user()->email)) {
                $data['user_email'] = '';
            } else {
                $data['user_email'] = Auth::user()->email;
            }

            if (empty($data['session_id'])) {
                $data['session_id'] = '';
            }
    
            $session_id = session()->get('session_id');
            if (empty($session_id)) {
                $session_id = Str::random(40);
                session()->put('session_id', $session_id);
            }
    
    
            $sizeIDArr = explode("-", $data['size']);
            $product_size = $sizeIDArr[1];
    
            if (empty(Auth::check())) {
                $countProducts = DB::table('carts')->where([
                    'product_id' => $data['product_id'], 'product_color' => $data['product_color'],
                    'size' => $product_size, 'session_id' => $session_id
                ])->count();
                // echo $countProducts;die;
                if ($countProducts > 0) {
                    return redirect()->back()->with('flash_message_error', 'Le produit existe déjà dans le panier!');
                }
            }else{
                $countProducts = DB::table('carts')->where([
                    'product_id' => $data['product_id'], 'product_color' => $data['product_color'],
                    'size' => $product_size, 'user_email' => $data['user_email']
                ])->count();
                // echo $countProducts;die;
                if ($countProducts > 0) {
                    return redirect()->back()->with('flash_message_error', 'Le produit existe déjà dans le panier!');
                }
            }
    
    
            // echo $product_size;
            $getSKU = ProductsAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $product_size])->first();
            // echo $getSKU;die;
            DB::table('carts')->insert([
                'product_id' => $data['product_id'], 'product_name' => $data['product_name'],
                'product_code' => $getSKU->sku, 'product_color' => $data['product_color'], 'price' => $data['price'], 'size' => $product_size,
                'quantity' => $data['quantity'], 'user_email' => $data['user_email'], 'session_id' => $session_id
            ]);
    
    
            return redirect('cart')->with('flash_message_success', 'Le produit a bien été ajouté au panier!');
        }
    }


    public function cart(Request $request)
    {
        if (Auth::check()) {
            $user_email = Auth::user()->email;
            $userCart = DB::table('carts')->where(['user_email' => $user_email])->get();
        } else {
            $session_id = session()->get('session_id');
            $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
        }

        foreach ($userCart as $key => $product) {
            // echo $product->product_id;
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        // echo "<pre>"; print_r($userCart); die;

        $meta_title = "Votre panier sur Emaster.com";
        $meta_description = "Voir votre panier sur Emaster.com";
        $meta_keywords = "Panier,site emaster";
        return view('products.cart')->with(compact('userCart','meta_title','meta_description','meta_keywords'));
    }



    public function wishList()
    {
        if(Auth::check()){
            $user_email = Auth::user()->email;
            $userWishList = DB::table('wish_list')->where('user_email',$user_email)->get();
            foreach ($userWishList as $key => $product) {
                // echo $product->product_id;
                $productDetails = Product::where('id', $product->product_id)->first();
                $userWishList[$key]->image = $productDetails->image;
            }
        }else{
            $userWishList = array();
        }
        $meta_title = "Votre liste sur Emaster.com";
        $meta_description = "Voir votre liste sur Emaster.com";
        $meta_keywords = "Votre liste,site emaster";

        return view('products.wish_list')->with(compact('userWishList','meta_title','meta_description','meta_keywords'));
    }


    public function deleteWishListProduct($id)
    {
        DB::table('wish_list')->where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Le produit a été supprimé de votre liste d\'envies avec succès');
    }


    public function deleteCartProduct($id = null)
    {

        session()->forget('CouponAmount');
        session()->forget('CouponCode');
        // echo $id;die;
        DB::table('carts')->where('id', $id)->delete();
        return redirect('cart')->with('flash_message_success', 'Le produit a bien été supprimer du panier!');
        // return redirect()->back()->with('flash_message_success', 'Le produit a bien été supprimer du panier!');
    }


    public function updateCartQuantity($id = null, $quantity = null)
    {
        session()->forget('CouponAmount');
        session()->forget('CouponCode');

        $getCartDetails = DB::table('carts')->where('id', $id)->first();
        $getAttributeStock = ProductsAttribute::where('sku', $getCartDetails->product_code)->first();
        // echo $getAttributeStock->stock; echo "--";
        $updated_quantity = $getCartDetails->quantity + $quantity;
        if ($getAttributeStock->stock >= $updated_quantity) {
            DB::table('carts')->where('id', $id)->increment('quantity', $quantity);
            return redirect('cart')->with('flash_message_success', 'La quantité a été mise à jour avec succès!');
        } else {
            return redirect('cart')->with('flash_message_error', 'La quantité du produit demandé n\'est pas disponible!');
        }
    }


    public function applyCoupon(Request $request)
    {

        session()->forget('CouponAmount');
        session()->forget('CouponCode');


        $data = $request->all();
        // echo "<pre>"; print_r($data);die;
        $couponCount = Coupon::where('coupon_code', $data['coupon_code'])->count();
        if ($couponCount == 0) {
            return redirect()->back()->with('flash_message_error', 'Ce coupon n\'existe pas!');
        } else {
            // echo "Success";die;
            // Get coupon details
            $couponDetails = Coupon::where('coupon_code', $data['coupon_code'])->first();

            // if coupon is inactive
            if ($couponDetails->status == 0) {
                return redirect()->back()->with('flash_message_error', 'Ce coupon n\'est pas activé!');
            }

            // If coupon is Expired
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('Y-m-d');
            if ($expiry_date < $current_date) {
                return redirect()->back()->with('flash_message_error', 'Ce coupon est déjà expiré!');
            }

            // Coupon is valid for Discount

            // Get cart Total amount
            $session_id = session()->get('session_id');

            if (Auth::check()) {
                $user_email = Auth::user()->email;
                $userCart = DB::table('carts')->where(['user_email' => $user_email])->get();
            } else {
                $session_id = session()->get('session_id');
                $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
            }

            $total_amount = 0;
            foreach ($userCart as $item) {
                $total_amount = $total_amount + ($item->price * $item->quantity);
            }


            //  Check if the amount type is fixed or Percentage
            if ($couponDetails->amount_type == 'Fixe') {
                $couponAmount = $couponDetails->amount;
            } else {
                // echo $total_amount;die;
                $couponAmount = $total_amount * ($couponDetails->amount / 100);
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
        // $session_id = session()->get('session_id');
        // $cartCount = DB::table('carts')->where(['session_id' => $session_id])->count();
        // if($cartCount<=0){
        //     return redirect()->route('index');
        // }
        $user_id =  Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();

        // Check if Shipping address exists
        $shippingCount = DeliveryAddress::where('user_id', $user_id)->count();
        $shippingDetails = array();
        if ($shippingCount > 0) {
            $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        }

        // Update cart table with user email
        $session_id = session()->get('session_id');
        DB::table('carts')->where(['session_id' => $session_id])->update(['user_email' => $user_email]);


        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            // dump($data);

            // Return to checkout page if any of Field is empty
            if (
                empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state'])
                || empty($data['billing_country']) || empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name'])
                || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country'])
                || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])
            ) {
                return redirect()->back()->with('flash_message_error', 'Merci de remplir tous les champs pour passer la commande!');
            }

            //  Update User Details
            User::where('id', $user_id)->update([
                'name' => $data['billing_name'], 'address' => $data['billing_address'], 'city' => $data['billing_city'], 'state' => $data['billing_state'],
                'country' => $data['billing_country'], 'pincode' => $data['billing_pincode'], 'mobile' => $data['billing_mobile']
            ]);

            if ($shippingCount > 0) {
                //  Update Shipping address
                DeliveryAddress::where('user_id', $user_id)->update([
                    'name' => $data['shipping_name'], 'address' => $data['shipping_address'], 'city' => $data['shipping_city'], 'state' => $data['shipping_state'],
                    'country' => $data['shipping_country'], 'pincode' => $data['shipping_pincode'], 'mobile' => $data['shipping_mobile']
                ]);
            } else {
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


        $pincodeCount = DB::table('pincodes')->where('pincode',$data['shipping_pincode'])->count();
        // $cbpincodeCount = DB::table('cb_pincodes')->where('pincode',$shippingDetails->pincode)->count();
        // echo "<pre>";print_r($cbpincodeCount);die;
        if($pincodeCount == 0 ){
            return redirect()->back()->with('flash_message_error', 'Votre localisation n\'est pas valide. Merci de saisir un autre code postal pour la livraison!');
        }
        // if($cbpincodeCount == 0 ){
        //     return redirect()->back()->with('flash_message_error', 'Votre CB n\'est pas valide. Merci de saisir un autre code postal pour la livraison!');
        // }


            return redirect()->action('ProductsController@orderReview');
        }
        $meta_title = "Votre adresse sur Emaster.com ";
        $meta_title = "Votre adresse sur Emaster.com ";
        return view('products.checkout')->with(compact('userDetails', 'countries', 'shippingDetails','meta_title'));
    }


    public function orderReview()
    {
        $session_id = session()->get('session_id');
        $cartCount = DB::table('carts')->where(['session_id' => $session_id])->count();
        if ($cartCount <= 0) {
            return redirect()->route('index');
        }
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id', $user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        // $shippingDetails = json_decode(json_encode($shippingDetails));
        // echo "<pre>";print_r($shippingDetails);die; 
        $userCart = DB::table('carts')->where(['user_email' => $user_email])->get();
        $total_weight = 0;

        foreach ($userCart as $key => $product) {
            // echo $product->product_id;
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
            $total_weight = $total_weight + $productDetails->weight;

        }
        // echo $total_weight; die;

        $cbpincodeCount = DB::table('cb_pincodes')->where('pincode',$shippingDetails->pincode)->count();
        // echo "<pre>";print_r($cbpincodeCount);die;

        // Fetch shipping charges
        $shippingCharges = Product::getShippingCharges($total_weight, $shippingDetails->country);
        session()->put('shippingCharges',$shippingCharges);

        return view('products.order_review')->with(compact('userDetails', 'shippingDetails', 'userCart','cbpincodeCount','shippingCharges'));
        // echo "<pre>";print_r($userCart);die;
    }


    public function placeOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;

            // Prevent out of stock Products from ordering
            $userCart = DB::table('carts')->where('user_email',$user_email)->get();
            // $userCart = json_decode(json_encode($userCart));
            foreach($userCart as $cart){
                $getAttributeCount = Product::getAttributeCount($cart->product_id,$cart->size);
                if($getAttributeCount==0){
                    Product::deleteCartProduct($cart->product_id, $user_email);
                    return redirect('/cart')->with('flash_message_error', 'Produit(s) non disponible en vente et supprimer du panier. Merci d\'essayer avec un autre produit!');
                }
                
                $product_stock = Product::getProductStock($cart->product_id,$cart->size);
                if($product_stock==0){
                    Product::deleteCartProduct($cart->product_id, $user_email);
                    return redirect('/cart')->with('flash_message_error', 'Produit(s) supprimer du panier suite à une rupture de sotck. Merci d\'essayer avec un autre produit!');
                }
                // echo "Original stock: " . $product_stock;
                // echo "demanded stock: " . $cart->quantity;die;
                if($cart->quantity>$product_stock){
                    return redirect('/cart')->with('flash_message_error', 'Merci de mettre à jour la quantité du produit dans votre panier suite à une réduction de stock!');
                }

                $product_status = Product::getProductStatus($cart->product_id);

                if($product_status==0){
                    Product::deleteCartProduct($cart->product_id, $user_email);
                    return redirect('/cart')->with('flash_message_error', 'Un de vos produits n\'est plus en vente et a été supprimé de votre panier . Merci d\'essayer avec un autre produit!');
                }

                $getCategoryId = Product::select('category_id')->where('id',$cart->product_id)->first();
                // echo $getCategoryId->category_id; die;
                $category_status = Product::getCategoryStatus($getCategoryId->category_id);
                if($category_status==0){
                    Product::deleteCartProduct($cart->product_id, $user_email);
                    return redirect('/cart')->with('flash_message_error', 'Un de vos produits n\'est plus en vente et a été supprimé de votre panier . Merci d\'essayer avec un autre produit!');
                }
                
            }
            // echo "<pre>";print_r($userCart);die;

            // Get shipping address of User
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();

            $pincodeCount = DB::table('pincodes')->where('pincode',$shippingDetails->pincode)->count();
            
            if($pincodeCount == 0 ){
                return redirect()->back()->with('flash_message_error', 'Votre localisation n\'est pas valide. Merci de saisir un autre code postal!');
            }
            // $shippingDetails = json_decode(json_encode($shippingDetails));
            // echo "<pre>";print_r($shippingDetails);die;
            // echo "<pre>";print_r($data);die;

            if (empty(session()->get('CouponCode'))) {
                $coupon_code = '';
            } else {
                $coupon_code = session()->get('CouponCode');
            }

            if (empty(session()->get('CouponAmount'))) {
                $coupon_amount = '';
            } else {
                $coupon_amount = session()->get('CouponAmount');
            }

             // Fetch shipping charges
            // $shippingCharges = Product::getShippingCharges($shippingDetails->country);

            $grand_total =  Product::getGrandTotal();
            // session()->put('grand_total', $grand_total);

            $order = new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->country = $shippingDetails->country;
            $order->pincode = $shippingDetails->pincode;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->shipping_charges = session()->get('shippingCharges');
            $order->grand_total = $grand_total;
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            $cartProducts = DB::table('carts')->where(['user_email' => $user_email])->get();

            foreach ($cartProducts as $pro) {
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_color = $pro->product_color;
                $cartPro->product_size = $pro->size;
                $product_price = Product::getProductPrice($pro->product_id,$pro->size);
                $cartPro->product_price = $product_price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->save();

                // Reduce stock script starts
                $getProductStock = ProductsAttribute::where('sku',$pro->product_code)->first();
                // echo "Original stock:" .$getProductStock->stock;
                // echo "Stock to reduce:" .$pro->quantity;
                $newStock = $getProductStock->stock - $pro->quantity;
                if($newStock<0) {
                    $newStock=0;
                }
                ProductsAttribute::where('sku',$pro->product_code)->update([ 'stock'=>$newStock]);
                // Reduce stock script ends
            }
            session()->put('order_id', $order_id); 
            session()->put('grand_total', $grand_total);

            // if ($data['payment_method'] == "CB") {
                // CB Redirect user to thanks page after saving order
                // return redirect('/place-order');
            // } 
            // else {
            //     //PAYPAL Redirect user to thanks page after saving order
            //     return redirect('/paypal');
            // }

            return redirect('/paiement');
        }
    }



    public function payment(Request $request)
    {
        $session_id = session()->get('session_id');
        $user_id = Auth::user()->id;
        $cartCount = DB::table('carts')->where(['session_id' => $session_id])->count();
        if ($cartCount <= 0) {
            return redirect()->route('index');
        }
        // dd($request->all());
        $user_email = Auth::user()->email;
        // DB::table('carts')->where('user_email', $user_email)->delete();

        $orderDetails = Order::getOrderDetails(session()->get('order_id'));
        //  echo"<pre>";print_r($orderDetails);die;

        $orderProducts = OrdersProduct::getOrderProducts(session()->get('order_id'));
        // echo"<pre>";print_r($orderProducts);die;

        $content = $orderProducts->map(function ($item) {
            return ' || ' . $item->product_name . ',' . ' code_pdt = ' . $item->product_code . ',' . ' Prix = ' . $item->product_price . ',' . ' Qty = ' . $item->product_qty;
        })->values()->toJson();

        // $getCountryCode = Order::getCountryCode($orderDetails->country);
        //    echo"<pre>";print_r($getCountryCode->country_name);die;
        // $grand_total = session()->get('grand_total');
        $grand_total = number_format(session()->get('grand_total'), 2, '', ' ');
        // echo "<pre>";print_r($grand_total);die;
        // Stripe::setApiKey(config('services.stripe.secret_key'));
        // $intent = PaymentIntent::create([
        //     'amount' => $grand_total,
        //     'currency' => 'EUR',
        //     'description' => 'Commande',
        //     // Verify your integration in this guide by including this parameter
        //     'metadata' => [
        //         'Contenu' => $content,

        //     ],
        //   ]);

        //   $clientSecret = Arr::get($intent, 'client_secret');
        //   echo "<pre>";print_r($intent);die;

        return view('orders.payment')->with(compact('orderDetails', 'orderProducts'));
    }


    public function checkoutPayment(Request $request)
    {
        $email = Auth::user()->email;
        $user_id = Auth::user()->id;
        $userDetails = User::where('id', $user_id)->first();

        $data = $request->all();
        // dd($data);
        $order_id = $data['order_id'];

        // Get shipping address of User
        $shippingDetails = DeliveryAddress::where(['user_email' => $email])->first();

        $grand_total = number_format($data['grand_total'], 2, '', ' ');

        $productDetails = Order::with('orders')->where('id', $order_id)->first();
        // echo"<pre>";print_r($productDetails);die;

        $orderProducts = OrdersProduct::getOrderProducts($order_id);
        // echo"<pre>";print_r($orderProducts);die;

        $contents = $orderProducts->map(function ($item) {
            return ' || ' . $item->product_name . ',' . ' code_pdt = ' . $item->product_code . ',' . ' Prix = ' . number_format($item->product_price, 2, ',', ' ') . ' €' . ',' . ' Qty = ' . $item->product_qty;
        })->values()->toJson();
        // echo"<pre>";print_r($contents);die;


        /**
         * handling payment with POST
         */
        $stripe = Stripe::setApiKey(config('services.stripe.secret_key'));

        $charges = Charge::create([
            'amount' => $grand_total,
            'currency' => 'EUR',
            'source' => $request->stripeToken,
            'description' => 'Order',
            'receipt_email' => $request->user_email,
            'metadata' => [
                'contents' => $contents,
            ]
        ]);

        // Code for order Email Start
        $messageData = [
            'email' => $email,
            'name' => $shippingDetails->name,
            'order_id' => $order_id,
            'productDetails' => $productDetails,
            'userDetails' => $userDetails
        ];
        Mail::send('email.order', $messageData, function ($message) use ($email) {
            $message->to($email)->subject('Votre commande a été traité avec succès - Equipe Emaster');
        });

        // Code for Order Email Ends
        Order::where('id', $order_id)->update(['order_status' => "Paid"]);
        DB::table('carts')->where('user_email', $email)->delete();
        session()->forget('CouponAmount');

        return redirect('/thanks')->with('flash_message_success', 'Merci! Votre paiement a bien été accepté !');
    }


    public function thanks(Request $request)
    {
        $user_email = Auth::user()->email;
        // DB::table('carts')->where('user_email', $user_email)->delete();

        return view('orders.thanks');
    }


    // public function thanksPaypal()
    // {
    //     return view('orders.thanks_paypal');
    // }


    // public function cancelPaypal()
    // {
    //     return view('orders.cancel_paypal');
    // }

    public function paypal(Request $request)
    {
        $user_email = Auth::user()->email;
        DB::table('carts')->where('user_email', $user_email)->delete();
        $orderDetails = Order::getOrderDetails(session()->get('order_id'));
        $nameArr = explode(' ', $orderDetails->name);
        // $orderDetails = json_decode(json_encode($orderDetails));
        // echo"<pre>";print_r($orderDetails);die;
        $getCountryCode = Order::getCountryCode($orderDetails->country);
        return view('orders.paypal')->with(compact('orderDetails', 'nameArr', 'getCountryCode'));
    }


    public function userOrders()
    {
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id', $user_id)->latest()->get();
        // $orders = json_decode(json_encode($orders));
        // echo "<pre>";print_r($orders);die;

        return view('orders.users_orders')->with(compact('orders'));
    }


    public function userOrdersDetails($order_id)
    {
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        // $orderDetails = json_decode(json_encode($orderDetails));
        // echo "<pre>";print_r($orderDetails);die;
        return view('orders.user_order_details')->with(compact('orderDetails'));
    }


    public function viewOrders()
    {
        if(Session::get('adminDetails')['orders_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
        $orders = Order::with('orders')->orderBy('id', 'DESC')->get();
        // $orders = json_decode(json_encode($orders));
        // echo"<pre>";print_r($orders);die;
        return view('admin.orders.view_orders')->with(compact('orders'));
    }


    public function viewOrdersDetails($order_id)
    {
        if(Session::get('adminDetails')['orders_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        // $orderDetails = json_decode(json_encode($orderDetails));
        // echo"<pre>";print_r($orderDetails);die;
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        // $userDetails = json_decode(json_encode($userDetails));
        // echo "<pre>"; print_r($userDetails);
        return view('admin.orders.order_details')->with(compact('orderDetails', 'us\erDetails'));
    }


    public function viewOrdersInvoice($order_id)
    {
        if(Session::get('adminDetails')['orders_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','Vous n\'avez pas accès à ce module');
        }
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        // $orderDetails = json_decode(json_encode($orderDetails));
        // echo"<pre>";print_r($orderDetails);die;
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        // $userDetails = json_decode(json_encode($userDetails));
        // echo "<pre>"; print_r($userDetails);die;
        return view('admin.orders.order_invoice')->with(compact('orderDetails', 'userDetails'));
    }

    
    public function viewPDFInvoice($order_id)
    {
        $orderDetails = Order::with('orders')->where('id', $order_id)->first();
        // $orderDetails = json_decode(json_encode($orderDetails));
        // echo"<pre>";print_r($orderDetails);die;
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        // $userDetails = json_decode(json_encode($userDetails));
        // echo "<pre>"; print_r($userDetails);


        $output = '<!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <title>Facture</title>
            <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
                }
                
                a {
                color: #5D6975;
                text-decoration: underline;
                }
                
                body {
                position: relative;
                width: 21cm;  
                height: 29.7cm; 
                margin: 0 auto; 
                color: #001028;
                background: #FFFFFF; 
                font-family: Arial, sans-serif; 
                font-size: 12px; 
                font-family: Arial;
                }
                
                header {
                padding: 10px 0;
                margin-bottom: 30px;
                }
                
                #logo {
                text-align: center;
                margin-bottom: 10px;
                }
                
                #logo img {
                width: 90px;
                }
                
                h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background: url(dimension.png);
                }
                
                #project {
                float: left;
                }
                
                #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
                }
                
                #company {
                float: right;
                text-align: right;
                }
                
                #project div,
                #company div {
                white-space: nowrap;        
                }
                
                table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
                }
                
                table tr:nth-child(2n-1) td {
                background: #F5F5F5;
                }
                
                table th,
                table td {
                text-align: center;
                }
                
                table th {
                padding: 5px 20px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;        
                font-weight: normal;
                }
                
                table .service,
                table .desc {
                text-align: left;
                }
                
                table td {
                padding: 20px;
                text-align: right;
                }
                
                table td.service,
                table td.desc {
                vertical-align: top;
                }
                
                table td.unit,
                table td.qty,
                table td.total {
                font-size: 1.2em;
                }
                
                table td.grand {
                border-top: 1px solid #5D6975;;
                }
                
                #notices .notice {
                color: #5D6975;
                font-size: 1.2em;
                }
                
                footer {
                color: #5D6975;
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
                }
            </style>
          </head>
          <body>
            <header class="clearfix">
            <div id="logo" >
               <img src="images/backend_images/emasterlogo.png">
            </div>
              <h1>Facture Numéro: '.$orderDetails->id.'</h1>
              <div id="project" class="clearfix" style="margin-left:40px;">
                <div><span>Commande ID</span> '.$orderDetails->id.'</div>
                <div><span>Date de la commande</span> '.$orderDetails->created_at->format('d-m-Y H:i:s').'</div>
                <div><span>Montant</span> '.$orderDetails->grand_total.'</div>
                <div><span>Statut</span> '.$orderDetails->order_status.'</div>
                <div><span>Mode de paiement</span> '.$orderDetails->payment_method.'</div>
              </div>
              <div id="project" style="float:right;">
                <div><strong>Shipping Address</strong></div>
                <div>'.$orderDetails->name.'</div>
                <div>'.$orderDetails->address.'</div>
                <div>'.$orderDetails->city.', '.$orderDetails->state.'</div>
                <div>'.$orderDetails->pincode.'</div>
                <div>'.$orderDetails->country.'</div>
                <div>'.$orderDetails->mobile.'</div>
              </div>
            </header>
            <main>
              <table>
                <thead>
                    <tr>
                        <td style="width:18%"><strong>Code Produit</strong></td>
                        <td style="width:18%" class="text-center"><strong>Taille</strong></td>
                        <td style="width:18%" class="text-center"><strong>Couleur</strong></td>
                        <td style="width:18%" class="text-center"><strong>Prix</strong></td>
                        <td style="width:18%" class="text-center"><strong>Quantité</strong></td>
                        <td style="width:18%" class="text-right"><strong>Total</strong></td>
                    </tr>
                </thead>
                <tbody>';
                $Subtotal = 0;
                foreach($orderDetails->orders as $pro){
                    $output .= '<tr>
                        <td class="text-left">'.$pro->product_code.'</td>
                        <td class="text-center">'.$pro->product_size.'</td>
                        <td class="text-center">'.$pro->product_color.'</td>
                        <td class="text-center">'.number_format($pro->product_price, 2, ',', ' ') . ' €'.'</td>
                        <td class="text-center">'.$pro->product_qty.'</td>
                        <td class="text-right">'.number_format($pro->product_price * $pro->product_qty, 2, ',', ' ') . ' €'.'</td>
                    </tr>';
                    $Subtotal = $Subtotal + ($pro->product_price * $pro->product_qty); }
                $output .= '<tr>
                    <td colspan="5">SOUS-TOTAL</td>
                    <td class="total"> '.number_format($Subtotal , 2, ',', ' ') . ' €'.'</td>
                  </tr>
                  <tr>
                    <td colspan="5">FRAIS DE PORT (+)</td>
                    <td class="total">'.number_format($orderDetails->shipping_charges, 2, ',', ' ').'</td>
                  </tr>
                  <tr>
                    <td colspan="5">COUPON DISCOUNT (-)</td>
                    <td class="total">'.number_format($orderDetails->coupon_amount, 2, ',', ' ').'</td>
                  </tr>
                  <tr>
                    <td colspan="5">TVA(20% inclus)</td>
                    <td class="total">'.number_format($orderDetails->grand_total*0.20, 2, ',', ' ').'</td>
                  </tr>
                  <tr>
                    <td colspan="5" class="grand total">TOTAL</td>
                    <td class="grand total">'.number_format($orderDetails->grand_total, 2, ',', ' ').'</td>
                  </tr>
                </tbody>
              </table>
            </main>
            <footer>
            La facture a été créée sur un ordinateur et est valide sans la signature et le sceau.
            </footer>
          </body>
        </html>';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

    }


    public function updateOrderStatus(Request $request)
    {
        
        if ($request->isMethod('POST')) {
            $data = $request->all();
            Order::where('id', $data['order_id'])->update(['order_status' => $data['order_status']]);
            return redirect()->back()->with('flash_message_success', 'Le status de la commande a bien été mise à jour!');
        }
    }


    public function checkPincode(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            $pincodeCount = DB::table('pincodes')->where('pincode',$data['pincode'])->count();
            if($pincodeCount>0){
                echo "Le code postal est valable pour la livraison";
            }else{
                echo "Merci de saisir un code postal valide pour la livraison";
            }
        }
        
    }

    
    public function exportProducts()
    {
        return Excel::download(new productExport,'products.xlsx');

    }


    public function viewOrdersCharts()
    {
        $current_month_orders = Order::where('order_status','Paid')->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)->count();
         $last_month_orders = Order::where('order_status','Paid')->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
         $last_to_last_month_orders = Order::where('order_status','Paid')->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        return view('admin.products.view_orders_charts')->with(compact('current_month_orders','last_month_orders', 'last_to_last_month_orders'));
    }

    
}

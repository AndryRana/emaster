<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

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
            $product->price = $data['price'];

            // Upload Image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/product/large/' . $filename;
                    $medium_image_path = 'images/backend_images/product/medium/' . $filename;
                    $small_image_path = 'images/backend_images/product/small/' . $filename;
                    // Resize Image code
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                    //  Store image name in products table
                    $product->image = $filename;
                }
            }


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
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/product/large/' . $filename;
                    $medium_image_path = 'images/backend_images/product/medium/' . $filename;
                    $small_image_path = 'images/backend_images/product/small/' . $filename;
                    // Resize Image code
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                } else {
                    $filename = $data['current_image'];
                }


                if (empty($data['description'])) {
                    $data['description'] = '';
                }

                Product::where(['id' => $id])->update(
                    [
                        'category_id' => $data['category_id'], 'product_name' => $data['product_name'], 'product_code' => $data['product_code'],
                        'product_color' => $data['product_color'], 'description' => $data['description'], 'price' => $data['price'], 'image' => $filename
                    ]
                );
            }
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
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Le produit a été supprimé avec succès!');
    }


    public function viewProducts()
    {
        $products = Product::get();
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
        Product::where(['id' => $id])->update(['image' => '']);
        return redirect()->back()->with('flash_message_success', 'L\'image du produit a été supprimée avec succès!');
    }
}

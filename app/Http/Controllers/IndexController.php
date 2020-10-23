<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Product;
use BeyondCode\DumpServer\Dumper;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // In Ascending order (by default)
        // $productsAll = Product::get();

        // In Descneding order
        // $productsAll = Product::orderBy('id', 'DESC')->get();
        
        // In Random order Get all products
        $productsAll = Product::inRandomOrder()->where('status',1)->where('feature_item', '1')->paginate(6);
    //    dump($productsAll);

        //  Get all Categories and Sub Categories
        $categories =  Category::with('categories')->where(['parent_id'=>0])->get();
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>";print_r($categories);die;
        /*$categories_menu = "";
        foreach($categories as $cat) {
            $categories_menu .= "<div class='panel-heading'>
                                <h4 class='panel-title'>
                                    <a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
                                        <span class='badge pull-right'><i class='fa fa-plus'></i></span>
                                        ".$cat->name."
                                    </a>
                                </h4>
                            </div>
                            <div id='".$cat->id."' class='panel-collapse collapse'>
                                <div class='panel-body'>
                                    <ul>";
                                    $sub_categories = Category::where(['parent_id'=> $cat->id])->get();
                                    foreach($sub_categories as $subcat){
                                        $categories_menu .= "<li><a href='".$subcat->url."'>".$subcat->name."</a></li>";
                                    }
                                    $categories_menu .= 
                                    "</ul>
                                </div>
                            </div>";
          
        }*/

        $banners = Banner::where('status','1')->get();

        // Meta tags
        $meta_title = "Emaster.com site Officiel - Offres bons plans ";
        $meta_description = "Vente en ligne de divers produits pour femmes, hommes, enfants, Accessoires cuisine, mobiliers,high-tech, maison ";
        $meta_keywords = "bons plans,mode hommes, mode femmes, mode enfants, maison, cuisine, beauté, high-tech, Iphone, sport, jardin";


        return view('index')->with(compact('productsAll','categories','banners','meta_title', 'meta_description', 'meta_keywords'));
    }
   
}

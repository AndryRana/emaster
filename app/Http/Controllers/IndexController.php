<?php

namespace App\Http\Controllers;

use App\Product;
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
        
        // In Random order
        $productsAll = Product::inRandomOrder()->get();
        return view('index')->with(compact('productsAll'));
    }

   
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index()
    {  
       
        $all_published_product = DB::table('products')
                         ->join('categorys','products.category_id', '=', 'categorys.category_id')
                         ->join('brands', 'products.manufacture_id', '=', 'brands.manufacture_id')
                         ->select('products.*', 'categorys.category_name','brands.manufacture_name')
                         ->where('products.publication_statues',1)
                         ->limit(12)
                         ->get();
        $manage_published_product = view('pages.home')
                         ->with('all_published_product', $all_published_product);
              return view('layout')
                      ->with('pages.home', $manage_published_product);

        //return view('pages.home');
    }

     public function show_product_by_category($category_id)
    {
        $product_by_category = DB::table('products')
              ->join('categorys','products.category_id', '=', 'categorys.category_id')
              ->select('products.*', 'categorys.category_name')
              ->where('categorys.category_id', $category_id)
              ->where('products.publication_statues',1)
             ->limit(18)
             ->get();
        $manage_product_by_category = view('pages.category_by_products')
        ->with('product_by_category', $product_by_category);
              return view('layout')
        ->with('pages.category_by_products', $manage_product_by_category);

    }

    public function show_product_by_manufacture($manufacture_id)
    {
        $product_by_manufacture = DB::table('products')
                 ->join('categorys','products.category_id', '=', 'categorys.category_id')
                 ->join('brands', 'products.manufacture_id', '=', 'brands.manufacture_id')
                 ->select('products.*', 'categorys.category_name','brands.manufacture_name')
                 ->where('products.publication_statues',1)
                 ->where('brands.manufacture_id', $manufacture_id)
                 ->limit(18)
                 ->get();
         $manage_product_by_manufacture = view('pages.manufacture_by_products')
              ->with('product_by_manufacture', $product_by_manufacture);
         return view('layout')
             ->with('pages.manufacture_by_products', $manage_product_by_manufacture);
         
    }

    public function product_details_by_id($product_id)
    {
        $product_by_details = DB::table('products')
              ->join('categorys','products.category_id', '=', 'categorys.category_id')
              ->join('brands', 'products.manufacture_id', '=', 'brands.manufacture_id')
              ->select('products.*', 'categorys.category_name','brands.manufacture_name')
              ->where('products.product_id', $product_id)
              ->where('products.publication_statues',1)
              ->first();
        $manage_product_by_details = view('pages.product_details')
        ->with('product_by_details', $product_by_details);
              return view('layout')
        ->with('pages.product_details', $manage_product_by_details); 
    }

  
   

   

}

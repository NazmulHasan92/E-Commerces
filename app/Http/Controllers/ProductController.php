<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function index()
    {
        $this->AdminAuthCheek();
        return view('admin.add_product');
    }

    public function all_product($product_id)
    {
        $this->AdminAuthCheek();
        $all_product_info = DB::table('products')
                         ->join('categorys','products.category_id', '=', 'categorys.category_id')
                         ->join('brands', 'products.manufacture_id', '=', 'brands.manufacture_id')
                         ->select('products.*', 'categorys.category_name','brands.manufacture_name')
                         ->get();
        $manage_product = view('admin.all_product')
                         ->with('all_product_info', $all_product_info);
              return view('admin_layout')
                      ->with('admin.all_product', $manage_product);
                      
                      
        //return view('admin.all_product');
    }

    public function save_product(Request $request)
    {
        $this->AdminAuthCheek();
        $data = array();
        $data['product_name']=$request->product_name;
        $data['category_id']=$request->category_id;
        $data['manufacture_id']=$request->manufacture_id;
        $data['product_short_description']=$request->product_short_description;
        $data['product_long_description']=$request->product_long_description;
        $data['product_price']=$request->product_price;
        $data['product_size']=$request->product_size;
        $data['product_color']=$request->product_color;
        $data['publication_statues']=$request->publication_statues;

        $image=$request->file('product_image');
        if($image){
              $image_name=str::random(20);
              $ext=strtolower($image->getClientOriginalExtension());
              $image_full_name=$image_name.'.'.$ext;
              $upload_path='image/';
              $image_url=$upload_path.$image_full_name;
              $success=$image->move($upload_path,$image_full_name);
              if($success){
                  $data['product_image']=$image_url;

                  DB::table('products')->insert($data);
                  Session::put('message','Product Added Successfully');
                  return Redirect::to('/add-product');
              }
        }

        $data['product_image']='';
        DB::table('products')->insert($data);
        Session::put('message','Product Added Without Image Successfully');
        return Redirect::to('/add-product');

    }

    public function unactive_product($product_id)
    {
        $this->AdminAuthCheek();
          DB::table('products')
                  ->where('product_id', $product_id)
                  ->update(['publication_statues' => 0]);
                  Session::put('message','Product Unactive Successfully');
                  return Redirect::to('/all-product');
    }

    public function active_product($product_id)
    {
        $this->AdminAuthCheek();
          DB::table('products')
                  ->where('product_id', $product_id)
                  ->update(['publication_statues' => 1]);
                  Session::put('message','Product Active Successfully');
                  return Redirect::to('/all-product');
    } 

    public function delete_product($product_id)
    {
        $this->AdminAuthCheek();
        DB::table('products')
           ->where('product_id', $product_id)
           ->delete();
            Session::put('message','Product Delete Successfully');
            return Redirect::to('/all-product');
    }

    public function edit_product($product_id)
      {  
        $this->AdminAuthCheek();
          $edit_product_info = DB::table('products')
                              ->where('product_id', $product_id)
                              ->first();

            $product_info = view('admin.edit_product')
                              ->with('product_info', $edit_product_info);
                              return view('admin_layout')
                           ->with('admin.edit_product', $product_info);             

     }

     public function update_product(Request $request,$product_id)
    {     
        $this->AdminAuthCheek();
          $data = array();
          $data['product_name'] =$request->product_name;
          $data['product_image']=$request->product_image;
          $data['product_price']=$request->product_price;

          DB::table('products')
            ->where('product_id',$product_id)
            ->update($data);

            Session::put('message','Product Update Successfully');
            return Redirect::to('/all-product');
    }



    public function AdminAuthCheek()
    {
        $admin_id=Session::get('admin_id');
        if($admin_id){
            return;
        }else{
            return Redirect::to('/admin')->send();
        }
    }
}

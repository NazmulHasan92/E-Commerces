<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Cart;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckController extends Controller
{
    public function login_check()
    {
        return view('pages.login');
    }

    public function customer_registration(Request $request)
    {
        $data=array();
        $data['customer_name']=$request->customer_name;
        $data['customer_email']=$request->customer_email;
        $data['password']=md5($request->password);
        $data['mobile_number']=$request->mobile_number;

        $customer_id = DB::table('customers')
                    ->insertGetId($data);

             Session::put('customer_id', $customer_id);
             Session::put('customer_name', $request->customer_name);
             return Redirect('/checkout');       

    }

    public function check_out()
    {
      return view('pages.checkout');
    }

    public function save_shipping(Request $request)
    {
          $data=array();
          $data['shipping_email']=$request->shipping_email;
          $data['shipping_first_name']=$request->shipping_first_name;    
          $data['shipping_last_name']=$request->shipping_last_name;  
          $data['shipping_address']=$request->shipping_address;  
          $data['shipping_phone_number']=$request->shipping_phone_number;
          $data['shipping_city']=$request->shipping_city;
           

          $shipping_id=DB::table('shipping')
                   ->insertGetId($data);
           Session::put('shipping_id',$shipping_id);
           return Redirect::to('/payment');
    }

    public function customer_login(Request $request)
    {
        $customer_email=$request->customer_email;
        $password=md5($request->password);
        $result_customer=DB::table('customers')
              ->where('customer_email',$customer_email)
              ->where('password',$password) 
              ->first();
              
              if($result_customer)
              {
                Session::put('customer_id',$result_customer->customer_id);  
                return Redirect::to('/checkout');
              }else{
                return Redirect::to('/login-check');
              }
    }

    public function payment()
    {
      return view('pages.payment');
    }

    public function customer_logout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    public function order_place(Request $request)
    {
          $payment_gateway=$request->payment_method;

          $pdata=array();
          $pdata['payment_method']=$payment_gateway;
          $pdata['payment_status']='pending';
          $payment_id=DB::table('payments')
               ->insertGetId($pdata);

          $odata=array();
          $odata['customer_id']=Session::get('customer_id');
          $odata['shipping_id']=Session::get('shipping_id');
          $odata['payment_id']=$payment_id;
          $odata['order_total']=Cart::total();
          $odata['order_status']='pending';
          $order_id=DB::table('orders')
             ->insertGetId($odata);
             
           $contents=Cart::content();
           $oddata=array();
           
           foreach($contents as $v_content)
           {
             $oddata['order_id']=$order_id;
             $oddata['product_id']=$v_content->id;
             $oddata['product_name']=$v_content->name;
             $oddata['product_price']=$v_content->price;
             $oddata['product_sales_quantity']=$v_content->qty;

             DB::table('order_details')
               ->insert($oddata);
           }

          if($payment_gateway=='visa'){
            Cart::destroy();
            return view('pages.handcash');
           
          }elseif($payment_gateway=='master') {
            echo "Successfully Done By MasterCart";
          }elseif($payment_gateway=='handcash'){
            Cart::destroy();
            return view('pages.handcash');
            
          }elseif ($payment_gateway=='cart') {
            echo "Successfully Done By DebitCart";
          }elseif($payment_gateway=='bkash'){
            echo "Successfully Done By Bkash";
          }else{
            echo "No Seleted";
          } 

     }

   public function manage_order()
   {
    $all_order_info = DB::table('orders')
                         ->join('customers','orders.customer_id', '=', 'customers.customer_id')
                         ->select('orders.*', 'customers.customer_name')
                         ->get();
        $manage_order = view('admin.manage_order')
                         ->with('all_order_info', $all_order_info);
              return view('admin_layout')
                      ->with('admin.manage_order', $manage_order);
   }

   public function view_order($order_id)
   {
    $order_by_id = DB::table('orders')
                         ->join('customers','orders.customer_id', '=', 'customers.customer_id')
                         ->join('order_details','orders.order_id', '=', 'order_details.order_id')
                         ->join('shipping','orders.shipping_id', '=', 'shipping.shipping_id')
                         ->select('orders.*','order_details.*','shipping.*','customers.*')
                         ->get();
        $view_order = view('admin.view_order')
                         ->with('order_by_id', $order_by_id);
              return view('admin_layout')
                      ->with('admin.view_order', $view_order);
   }

    }
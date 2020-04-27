<?php

Route::get('/', 'HomeController@index');

//Show Category Wise Product--------->

Route::get('/product_by_category/{category_id}','HomeController@show_product_by_category');
Route::get('/product_by_manufacture/{manufacture_id}','HomeController@show_product_by_manufacture');
Route::get('/view_product/{product_id}','HomeController@product_details_by_id');

//Cart Router-------->

Route::post('/add-to-cart','CartController@add_to_cart');
Route::get('/show-cart','CartController@show_cart');
Route::get('/delete-cart/{rowId}','CartController@delete_cart');
Route::post('/update-cart','CartController@update_cart');

//CheckOut Router---------------->

Route::get('/login-check','CheckController@login_check');
Route::post('/customer-registration','CheckController@customer_registration');
Route::get('/checkout','CheckController@check_out');
Route::post('/save-shipping','CheckController@save_shipping');

// Customer Login and Logout Route-------------->

Route::post('/customer-login','CheckController@customer_login');
Route::get('/customer-logout','CheckController@customer_logout');

//Payment Route----------------------->

Route::get('/payment','CheckController@payment');
Route::post('/order-place','CheckController@order_place');

//Order Route---------------------->

Route::get('/manage-order','CheckController@manage_order');
Route::get('/view-order/{order_id}','CheckController@view_order');


//Backend Routes------------->

Route::get('/admin', 'AdminController@index');
Route::get('/dashboard','SuperAdminController@index');
Route::post('/admin-dashboard','AdminController@a_dashboard');
Route::get('/logout','SuperAdminController@logout');


//Category Router--------->

Route::get('/add-category','CategoryController@index');
Route::get('/all-category','CategoryController@all_category');
Route::post('/save-category','CategoryController@save_category');
Route::get('/unactive_category/{category_id}','CategoryController@unactive_category');
Route::get('/active_category/{category_id}','CategoryController@active_category');
Route::get('/edit_category/{category_id}','CategoryController@edit_category');
Route::post('/update_category/{category_id}','CategoryController@update_category');
Route::get('/delete_category/{category_id}','CategoryController@delete_category');

//Manufacture Router------------->

Route::get('/add-manufacture','ManufactureController@index');
Route::post('/save-manufacture','ManufactureController@save_manufacture');
Route::get('/all-manufacture','ManufactureController@all_manufacture');
Route::get('/delete_manufacture/{manufacture_id}','ManufactureController@delete_manufacture');
Route::get('/unactive_manufacture/{manufacture_id}','ManufactureController@unactive_manufacture');
Route::get('/active_manufacture/{manufacture_id}','ManufactureController@active_manufacture');
Route::get('/edit_manufacture/{manufacture_id}','ManufactureController@edit_manufacture');
Route::post('/update_manufacture/{manufacture_id}','ManufactureController@update_manufacture');

//Product Router------------>

Route::get('/add-product','ProductController@index');
Route::post('/save-product','ProductController@save_product');
Route::get('/all-product','ProductController@all_product');
Route::get('/unactive_product/{product_id}','ProductController@unactive_product');
Route::get('/active_product/{product_id}','ProductController@active_product');
Route::get('/delete_product/{product_id}','ProductController@delete_product');
Route::get('/edit_product/{product_id}','ProductController@edit_product');
Route::post('/update_product/{product_id}','ProductController@update_product');

//Slider Router------------------>

Route::get('/add-slider','SliderController@index');
Route::post('/save-slider','SliderController@save_slider');
Route::get('/all-slider','SliderController@all_slider');
Route::get('/unactive_slider/{slider_id}','SliderController@unactive_slider');
Route::get('/active_slider/{slider_id}','SliderController@active_slider');
Route::get('/delete_slider/{slider_id}','SliderController@delete_slider');

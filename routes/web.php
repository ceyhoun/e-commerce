<?php

use App\Http\Controllers\CartControllers;
use App\Http\Controllers\FavoryControllers;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PanelCotrollers;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix'=>'admin'],function () {



        Route::get('login', [PanelCotrollers::class, 'adminlogin'])->name('adminlogin');
        Route::post('auth', [PanelCotrollers::class, 'adminloginauth'])->name('adminloginauth');

        Route::group(['middleware'=> 'check'],function () {

        // Admin panel-backend
        Route::get('index', [PanelCotrollers::class, 'panel'])->name('panel');
        Route::get('forms/category', [PanelCotrollers::class, 'category'])->name('category');
        Route::get('forms/category/subcategory', [PanelCotrollers::class, 'subcategory'])->name('subcategory');
        Route::post('forms/category/add/subcategory', [PanelCotrollers::class, 'addsubcategory'])->name('addsubcategory');
        Route::post('forms/addcategory', [PanelCotrollers::class, 'addcategory'])->name('addcategory');
        Route::get('forms/products', [PanelCotrollers::class, 'products'])->name('products');
        Route::post('forms/addproducts', [PanelCotrollers::class, 'addproducts'])->name('addproducts');
        Route::get('forms/add/employee', [PanelCotrollers::class, 'pemployee'])->name('pemployee');
        Route::post('forms/add/new/employee', [PanelCotrollers::class, 'addpemployee'])->name('addpemployee');
        //referances
        Route::get('/forms/referances',[PanelCotrollers::class,'referances'])->name('referances');
        Route::post('/forms/add/referances',[PanelCotrollers::class,'addreferances'])->name('addreferances');
        //tables
        Route::get('/tables', [PanelCotrollers::class, 'tables'])->name('tables');
        Route::get('/admlogout', [PanelCotrollers::class, 'admlogout'])->name('admlogout');
        Route::get('/mailbox',[PanelCotrollers::class,'mailbox'])->name('mailbox');
});

});
//Pages-frontend



Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('/register', [HomePageController::class, 'register'])->name('register');
Route::get('/login', [HomePageController::class, 'login'])->name('login');

Route::get('/logout', [HomePageController::class, 'userlogout'])->name('userlogout');

Route::post('/create/user', [HomePageController::class, 'createuser'])->name('createuser');
Route::post('/create/login', [HomePageController::class, 'createlogin'])->name('createlogin');

Route::get('/detail/{slug?}', [HomePageController::class, 'detail'])->name('detail');
Route::get('/shop', [HomePageController::class, 'shop'])->name('shop');
Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');
Route::get('/checkout', [HomePageController::class, 'checkout'])->name('checkout');
Route::get('/cart', [HomePageController::class, 'cart'])->name('cart');
Route::get('/error', [HomePageController::class, 'error'])->name('error');
Route::post('/sent/messages',[HomePageController::class,'messages'])->name('messages');
Route::get('/favory',[HomePageController::class,'favory'])->name('favory');
Route::get('/employee',[HomePageController::class,'employee'])->name('employee');


//chars
Route::get('admin/chars', [PanelCotrollers::class, 'chars'])->name('chars');

//cart

Route::get('cart/additem/{productId}', [CartControllers::class, 'addToCart'])->name('additemget');
Route::post('cart/additem/{productId}', [CartControllers::class, 'addToCart'])->name('additem');

//cartdelete
Route::delete('/cart/item/{id}/{product_id}', [CartControllers::class, 'itemDelete'])->name('itemDelete');

//favory
Route::post('fav/addfav/{productId}',[FavoryControllers::class,'addFavory'])->name('addfavory');

Route::get('/favorites', [FavoryControllers::class, 'showFavorites'])->name('favorites');

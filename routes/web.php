<?php

use App\Http\Controllers\CartControllers;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoryControllers;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PanelCotrollers;
use App\Http\Controllers\RatingControllers;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'admin'], function () {



    Route::get('login', [PanelCotrollers::class, 'adminlogin'])->name('adminlogin');
    Route::post('auth', [PanelCotrollers::class, 'adminloginauth'])->name('adminloginauth');

    Route::group(['middleware' => 'check'], function () {


        // Admin panel-backend
        Route::get('index', [PanelCotrollers::class, 'panel'])->name('panel');

        //tables
        Route::get('/tables', [PanelCotrollers::class, 'tables'])->name('tables');
        Route::get('/admlogout', [PanelCotrollers::class, 'admlogout'])->name('admlogout');
        Route::get('/mailbox', [PanelCotrollers::class, 'mailbox'])->name('mailbox');
        Route::get('/product/discount/percent',[PanelCotrollers::class,'discountpercent'])->name('discountpercent');
        Route::post('/product/discount/add/percent',[PanelCotrollers::class,'adddiscountpercent'])->name('adddiscountpercent');

        Route::group(['prefix' => 'forms'], function () {
            Route::group(['prefix' => 'category'], function () {
                Route::get('subcategory', [PanelCotrollers::class, 'subcategory'])->name('subcategory');
                Route::post('add/subcategory', [PanelCotrollers::class, 'addsubcategory'])->name('addsubcategory');
            });
            Route::get('category', [PanelCotrollers::class, 'category'])->name('category');
            Route::post('addcategory', [PanelCotrollers::class, 'addcategory'])->name('addcategory');

            Route::group(['prefix' => 'add'], function () {
                Route::get('employee', [PanelCotrollers::class, 'pemployee'])->name('pemployee');
                Route::post('new/employee', [PanelCotrollers::class, 'addpemployee'])->name('addpemployee');
                Route::post('referances', [PanelCotrollers::class, 'addreferances'])->name('addreferances');

            });
            Route::get('products', [PanelCotrollers::class, 'products'])->name('products');
            //referances
            Route::get('referances', [PanelCotrollers::class, 'referances'])->name('referances');
        });


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
//Route::post('/cart', [HomePageController::class, 'cart'])->name('cart');
Route::get('/error', [HomePageController::class, 'error'])->name('error');
Route::post('/sent/messages', [HomePageController::class, 'messages'])->name('messages');
Route::get('/favory', [HomePageController::class, 'favory'])->name('favory');
Route::get('/employee', [HomePageController::class, 'employee'])->name('employee');
//chars
Route::get('admin/chars', [PanelCotrollers::class, 'chars'])->name('chars');

Route::group(['prefix' => 'cart'], function () {
    //cart
    Route::get('additem/{productId}', [CartControllers::class, 'addToCart'])->name('additemget');
    Route::post('additem/{productId}', [CartControllers::class, 'addToCart'])->name('additem');
    Route::get('getproduct/{productId}', [CartControllers::class, 'getproduct'])->name('getproduct');
    Route::delete('/cart/item/{id}/{product_id}', [CartControllers::class, 'itemDelete'])->name('itemDelete');
});


Route::group(['prefix' => 'fav'], function () {
    //favory
    Route::post('addfav/{product_id}', [FavoryControllers::class, 'addFavory'])->name('addfavory');
    Route::delete('{id}/{product_id}', [FavoryControllers::class, 'deleteFavory'])->name('deletefavory');
});
Route::get('search', [HomePageController::class, 'search'])->name('search');
//comm and rat

Route::group(['prefix' => 'comment'], function () {
    Route::post('newcomment/{product_id}', [HomePageController::class, 'comments'])->name('comment');
    Route::get('{user_id}', [HomePageController::class, 'showUserComments'])->name('showcomment');
    Route::delete('{product_id}', [CommentController::class, 'deletecomment'])->name('deletecomment');
});

//lang
Route::get('/locale/{locale}', [LocaleController::class, 'setLang'])->name('locale');

//sale product

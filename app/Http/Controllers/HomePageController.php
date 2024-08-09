<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Shopping;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Return_;

class HomePageController extends Controller
{

    public function register()
    {
        $categories = Category::all();

        $data['categories'] = $categories;

        $shops = Shopping::sum('product_qty');


        $data['shops'] = $shops;
        return view('frontend.auth.register', $data);
    }

    public function createuser(Request $request)
    {
        $name = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));


        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'ip_address' => $request->ip(),

        ]);

        if ($user) {
            return redirect()->route('login')->with('success', 'Profiliniz uğurla yaradıldı, e-postanızı doğrulayın ve giriş yapabilirsiniz.');
        } else {
            return redirect()->route('register')->with('error', 'Xəta baş verdi, lütfən yenidən cəhd edin.');
        }
    }



    public function login()
    {
        $categories = Category::all();

        $data['categories'] = $categories;

        $shops = Shopping::sum('product_qty');


        $data['shops'] = $shops;

        return view('frontend.auth.login', $data);
    }

    public function createlogin(Request $request)
    {
        $user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);


        if ($user) {
            return redirect()->route('home');
        } else {
            return back();
        }
    }

    public function userlogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Shopping::where('session_id', $request->session()->getId())
            ->whereNull('user_id') // Sadece oturum ID'sine sahip öğeleri temizle
            ->delete();

        return redirect()->route('home');
    }

    public function index(Request $request)
    {




        $categories = Category::where('status', '1')->with('subcategories')->get();
        $subcategories = Subcategory::where('status', '1')->get();
        $data['subcategories'] = $subcategories;





        $products = Product::select('products.*', DB::raw('COALESCE(SUM(product_size_color.qty)) as total_qty'))
            ->join('product_size_color', 'products.id', '=', 'product_size_color.product_id')
            ->where('products.status', '1')
            ->groupBy('products.id')
            ->with([
                'sizes' => function ($query) {
                    $query->select('sizes.name');
                }
            ])
            ->with([
                'colors' => function ($query) {
                    $query->select('colors.name');
                }
            ])
            ->get();

        $user_id = Auth::id();
        $session_id = $request->session()->get('_token');


        $shops = Shopping::where(function ($q) use ($user_id, $session_id) {
            if ($user_id) {
                // Kullanıcı ID'sine göre filtrele
                $q->where('user_id', $user_id);
            } else {
                // Oturum ID'sine göre filtrele
                $q->where('session_id', $session_id);
            }
        })->sum('product_qty');
        $data['shops'] = $shops;
        $data['products'] = $products;
        $data['categories'] = $categories;
        $productsDesc = Product::whereStatus('1')->orderBy('created_at', 'asc')->limit(5)->get();
        $data['productsDesc'] = $productsDesc;




        $data['categories'] = $categories;

        return view('frontend.pages.index', $data);
    }

    public function detail($slug = null, $id = null)
    {
        if (!$slug) {
            return redirect()->back();
        }

        $singleProduct = Product::select('products.*', DB::raw('COALESCE(SUM(product_size_color.qty)) as productstock'))
            ->join('product_size_color', 'products.id', '=', 'product_size_color.product_id')
            ->groupBy('products.id')
            ->first();
        if (!$singleProduct) {
            return redirect()->back();
        }

        $shops = Shopping::sum('product_qty');


        $data['shops'] = $shops;

        $data['singleProduct'] = $singleProduct;

        $categories = Category::whereStatus('1')->get();
        $data['categories'] = $categories;


        $likeProducts = Product::with('subcategory')
            ->where('subcategory_id', $singleProduct->subcategory_id)
            ->where('id', '<>', $singleProduct->id)
            ->get();




        $data['likeProducts'] = $likeProducts;


        return view('frontend.pages.detail', $data);
    }

    public function shop(Request $request)
    {

        $shops = Shopping::sum('product_qty');


        $data['shops'] = $shops;
        $categories = Category::all();
        $subcategories = Subcategory::withCount('products')->get();
         $sizes = Size::select('sizes.*', DB::raw('COALESCE(SUM(product_size_color.qty)) as totalSize'))
            ->join('product_size_color', 'sizes.id', '=', 'product_size_color.size_id')
            ->groupBy('sizes.id')
            ->get();





        $data['sizes'] = $sizes;
        $data['categories'] = $categories;
        $data['subcategories'] = $subcategories;

        //

        $productQuery = Product::query();



        if ($request->has('parent')) {

            $parentSlug = $request->get('parent');

            $parentCategory = Category::where('slug', $parentSlug)->first();

            $filterCategories = Subcategory::where('category_id', $parentCategory->id)->pluck('id');

            $productQuery->whereIn('subcategory_id', $filterCategories);

        } else {

            if ($request->has('filtre')) {

                $childSlug = $request->get('filtre');

                $productQuery->whereHas('subcategory', function ($q) use ($childSlug) {
                    $q->where('slug', $childSlug);
                });
            }

            if ($request->ajax()) {

                if ($request->has('size')) {
                    $size = $request->size ?? null;

                    $productQuery->whereHas('sizes', function ($query) use ($size) {
                        if (!empty($size)) {
                            $query->where('name', $size);
                        }
                    });
                }

                $filteredProducts = $productQuery->get();

                return response()->json([
                    'products' => $filteredProducts,
                ]);
            }
        }




        $products = $productQuery->get();
        $data['products'] = $products;
        return view('frontend.pages.shop', $data);

    }

    public function contact()
    {
        $shops = Shopping::sum('product_qty');

        $data['shops'] = $shops;
        $categories = Category::whereStatus('1')->get();
        $data['categories'] = $categories;

        return view('frontend.pages.contact', $data);
    }

    public function checkout()
    {
        $categories = Category::whereStatus('1')->get();
        $data['categories'] = $categories;

        return view('frontend.pages.checkout', $data);
    }

    public function cart(Request $request)
    //sepetin içi
    {

        $categories = Category::whereStatus('1')->get();
        $user_id = Auth::id();
        $session_id = $request->session()->get('_token');

        $userorders = Shopping::where(function ($q) use ($user_id, $session_id) {
            if ($user_id) {
                $q->where('user_id', $user_id);
            } else {
                $q->where('session_id', $session_id);
            }
        })
            ->with([
                'products' => function ($q) {
                    $q->select('id', 'name', 'price', 'images');

                }
            ])
            ->with('sizes')
            ->with('colors')
            ->get();



        $shops = Shopping::where(function ($q) use ($user_id, $session_id) {
            if ($user_id) {
                // Kullanıcı ID'sine göre filtrele
                $q->where('user_id', $user_id);
            } else {
                // Oturum ID'sine göre filtrele
                $q->where('session_id', $session_id);
            }
        })->sum('product_qty');


        $data['shops'] = $shops;

        $data['categories'] = $categories;
        $data['userorders'] = $userorders;

        return view('frontend.pages.cart', $data);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Return_;

class HomePageController extends Controller
{

    public function register()
    {
        return view('frontend.auth.register');
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
        ]);

        if ($user) {
            return redirect()->route('login')->with('success', 'Profiliniz uğurla yaradıldı, e-postanızı doğrulayın ve giriş yapabilirsiniz.');
        } else {
            return redirect()->route('register')->with('error', 'Xəta baş verdi, lütfən yenidən cəhd edin.');
        }
    }



    public function login()
    {
        return view('frontend.auth.login');
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

    public function userlogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function index(Request $request)
    {




        $categories = Category::where('status', '1')->with('subcategories')->get();
        $subcategories = Subcategory::where('status', '1')->get();
        $data['subcategories'] = $subcategories;



        $products = Product::where('status', '1')
            ->with('sizes')
            ->with('colors')
            ->get();
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
        $singleProduct = Product::where('status', 1)->where('slug', $slug)
            ->with('sizes')
            ->with('colors')
            ->with('subcategory')
            ->first();
        if (!$singleProduct) {
            return redirect()->back();
        }


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

        $categories = Category::all();
        $subcategories = Subcategory::withCount('products')->get();

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

        }


        if ($request->ajax()) {

            if ($request->has('size')) {
                $size = $request->size ?? null;

                $productQuery->whereHas('sizes', function ($query) use ($size) {
                    $query->where('name', $size);
                });
            }

            $filteredProducts = $productQuery->get();

            return response()->json([
                'products' => $filteredProducts,
            ]);
        }


        $products = $productQuery->get();
        $data['products'] = $products;
        return view('frontend.pages.shop', $data);

    }

    public function contact()
    {
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

    public function cart()
    {
        $categories = Category::whereStatus('1')->get();
        $data['categories'] = $categories;

        return view('frontend.pages.cart', $data);
    }

}

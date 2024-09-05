<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Contact;
use App\Models\Employee;
use App\Models\Favory;
use App\Models\Product;
use App\Models\Referance;
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
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Return_;

class HomePageController extends Controller
{

    public function register()
    {
        $categories = Category::all();

        $data['categories'] = $categories;

        $shops = getAuthController();

        $favcount = getFavoryController();
        $data['favcount'] = $favcount;


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

        $shops = getAuthController();

        $data['shops'] = $shops;

        $favcount = getFavoryController();
        $data['favcount'] = $favcount;

        return view('frontend.auth.login', $data);
    }

    public function createlogin(Request $request)
    {
        $remember = $request->has('remember') ? true : false;

        $user = Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember);


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

        Favory::where('session_id', $request->session()->getId())
            ->whereNull('user_id')
            ->delete();

        return redirect()->route('home');
    }

    public function index(Request $request)
    {




        $categories = Category::where('status', '1')->with('subcategories')->get();
        $referances = Referance::where('status', 1)->get();
        $data['referances'] = $referances;
        $subcategories = Subcategory::where('status', '1')->get();
        $data['subcategories'] = $subcategories;
        $favcount = Favory::count();
        $data['favcount'] = $favcount;

        $favcount = getFavoryController();
        $data['favcount'] = $favcount;




         $products = Product::select('products.*', DB::raw('COALESCE(SUM(product_size_color.qty)) as total_qty')
        ,DB::raw('COALESCE(SUM(product_shoe_color.QTY)) as number_qty'))
            ->leftJoin('product_size_color', 'products.id', '=', 'product_size_color.product_id')
            ->leftJoin('product_shoe_color', 'products.id', '=', 'product_shoe_color.product_id')
            ->where('products.status', '1')
            ->groupBy('products.id')
            ->with([
                'sizes' => function ($query) {
                    $query->select('id','name');
                }
            ])
            ->with([
                'colors' => function ($query) {
                    $query->select('id','name');
                }
            ])
            ->get();


        $shops = getAuthController();
        $data['shops'] = $shops;
        $data['products'] = $products;
        $data['categories'] = $categories;
        $productsDesc = Product::whereStatus('1')->orderBy('created_at', 'asc')->limit(2)->get();
        $data['productsDesc'] = $productsDesc;




        $data['categories'] = $categories;

        return view('frontend.pages.index', $data);
    }

    public function detail($slug = null)
    {
        if (!$slug) {
            return redirect()->back();
        }

        $singleProduct = Product::select('products.*')
            ->leftJoin('product_size_color', 'products.id', '=', 'product_size_color.product_id')
            ->leftJoin('product_shoe_color', 'products.id', '=', 'product_shoe_color.product_id')
            ->select(
                'products.*',
                DB::raw('COALESCE(SUM(product_size_color.qty), 0) as size_stock'),
                DB::raw('COALESCE(SUM(product_shoe_color.qty), 0) as shoe_stock')
            )
            ->groupBy('products.id')
            ->where('products.slug', $slug)
            ->with('sizes', 'shoes', 'colors:id,name')
            ->first();


        $singleProduct = Product::with(['sizes', 'shoes', 'colors:id,name'])
            ->where('slug', $slug)
            ->first();

        $sizeStock = DB::table('product_size_color')
            ->where('product_id', $singleProduct->id)
            ->sum('qty');

        $shoeStock = DB::table('product_shoe_color')
            ->where('product_id', $singleProduct->id)
            ->sum('qty');


        $singleProduct->size_stock = $sizeStock;
        $singleProduct->shoe_stock = $shoeStock;

        $shoeColors = DB::table('product_shoe_color')
            ->join('colors', 'product_shoe_color.color_id', '=', 'colors.id')
            ->where('product_shoe_color.product_id', $singleProduct->id)
            ->select('colors.id', 'colors.name')
            ->distinct()
            ->get();

        $sizeColors = DB::table('product_size_color')
            ->join('colors', 'product_size_color.color_id', '=', 'colors.id')
            ->where('product_size_color.product_id', $singleProduct->id)
            ->select('colors.id', 'colors.name')
            ->distinct()
            ->get();

        $singleProduct->shoe_colors = $shoeColors;
        $singleProduct->size_colors = $sizeColors;


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



        $shops = getAuthController();
        $data['shops'] = $shops;


        $favcount = getFavoryController();
        $data['favcount'] = $favcount;

        $data['likeProducts'] = $likeProducts;


        return view('frontend.pages.detail', $data);
    }

    public function shop(Request $request)
    {
        $shops = getAuthController();

        $data['shops'] = $shops;
        $categories = Category::all();
        $subcategories = Subcategory::withCount('products')->get();
        $sizes = Size::select('sizes.*', DB::raw('COALESCE(SUM(product_size_color.qty)) as totalSize'))
            ->join('product_size_color', 'sizes.id', '=', 'product_size_color.size_id')
            ->groupBy('sizes.id')
            ->get();
        $allTotalSize = $sizes->sum('totalSize');
        $colors = Color::select('colors.*', DB::raw('COALESCE(SUM(product_size_color.qty)) as totalColor'))
            ->join('product_size_color', 'colors.id', '=', 'product_size_color.color_id')
            ->groupBy('colors.id')
            ->get();
        ;



        $favcount = getFavoryController();
        $data['favcount'] = $favcount;

        $allTotalColor = $colors->sum('totalColor');

        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['allTotalSize'] = $allTotalSize;
        $data['allTotalColor'] = $allTotalColor;
        $data['categories'] = $categories;
        $data['subcategories'] = $subcategories;

        //Product query

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

                //size
                if ($request->has('size')) {
                    $size = $request->size ?? null;

                    $productQuery->whereHas('sizes', function ($query) use ($size) {
                        if (!empty($size)) {
                            $query->where('name', $size);
                        }
                    });
                }

                //color
                if ($request->has('color')) {
                    $color = $request->color ?? null;

                    $productQuery->whereHas('colors', function ($q) use ($color) {
                        if (!empty($color)) {
                            $q->where('name', $color);
                        }
                    });
                }

                //sort
                if ($request->has('sort_asc')) {
                    $sort_asc = $request->sort_asc ?? null;

                    $productQuery->orderBy('name', $sort_asc);

                } elseif ($request->has('sort_desc')) {

                    $sort_desc = $request->sort_desc ?? null;

                    $productQuery->orderBy('name', $sort_desc);
                }


                if ($request->has('sort_price_increment')) {

                    $price_asc = 'asc';

                    $productQuery->orderBy('price', $price_asc);

                } elseif ($request->has('sort_price_decrement')) {
                    $price_desc = 'desc';

                    $productQuery->orderBy('price', $price_desc);
                }

                //min&max price

                $minPrice =$request->input('minprice');
                $maxPrice =$request->input('maxprice');

                if (! is_null($minPrice) && ! is_null($maxPrice)) {
                   $productQuery->whereBetween('price',[$minPrice,$maxPrice]);
                }elseif (! is_null($minPrice)) {
                    $productQuery->where('price','>=',$minPrice);
                }elseif (! is_null($maxPrice)) {
                    $productQuery->where('price','<=',$minPrice);
                }


                //all get()

                $filteredProducts = $productQuery->paginate(3);

                return response()->json([
                    'products' => $filteredProducts,
                ]);

            }
        }

        $products = $productQuery->paginate(3);

        $data['products'] = $products;
        return view('frontend.pages.shop', $data);

    }

    public function contact()
    {
        $shops = getAuthController();

        $data['shops'] = $shops;
        $categories = Category::whereStatus('1')
            ->get();
        $data['categories'] = $categories;
        $favcount = getFavoryController();
        $data['favcount'] = $favcount;

        return view('frontend.pages.contact', $data);
    }
    public function messages(Request $request)
    {

        $status = $request->has('status') ? 1 : 0;

        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|alpha|min:3|max:100',
                'email' => 'required|email|max:100',
                'subject' => 'required|alpha|string',
                'message' => 'required',
            ],
            [
                'name.required' => 'Required field',
                'name.alpha' => 'Your name cannot be written with numbers',
                'name.min' => 'Your name must be a minimum of 3 characters',
                'name.max' => 'Your name must be a maximum of 100 characters',

                //mail
                'email.required' => 'Required field',
                'email.email' => 'Wrong email format',
                'email.max' => 'Your email must be a maximum of 100 characters',
                //subject
                'subject.required' => 'Required field',
                'subject.alpha' => 'Your name cannot be written with numbers',
                //message
                'message.required' => 'Required field',
            ]
        );



        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $validateData = $validate->validated();

        $name = $validateData['name'];
        $email = $validateData['email'];
        $subject = $validateData['subject'];
        $message = $validateData['message'];

        // Veriyi kaydet
        $contact = Contact::create([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'status' => $status,
        ]);

        // Başarı ya da hata mesajı
        if ($contact) {
            return redirect()->route('contact')->with('success', 'Mesajınız Gönderildi');
        } else {
            return redirect()->route('contact')->with('danger', 'Mesajınız Gönderilmedi');
        }


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

        $favcount = getFavoryController();
        $data['favcount'] = $favcount;

        $shops = getAuthController();


        $data['shops'] = $shops;
        $data['categories'] = $categories;
        $data['userorders'] = $userorders;

        return view('frontend.pages.cart', $data);
    }

    public function favory()
    {
        $categories = Category::whereStatus('1')
            ->get();
        $shops = getAuthController();

        $user_id = Auth::id();
        $session_id = request()->session()->get('_token');

        $favorites = Favory::where(function ($query) use ($user_id, $session_id) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->where('session_id', $session_id);
            }
        })

            ->with([
                'products' => function ($q) {
                    $q->select('id', 'name', 'price', 'images');
                }
            ])->get();





        $favcount = getFavoryController();
        $data['favcount'] = $favcount;


        $data['categories'] = $categories;
        $data['shops'] = $shops;
        $data['favorites'] = $favorites;
        return view('frontend.pages.favory', $data);

    }

    public function employee()
    {
        $categories = Category::whereStatus('1')->get();
        $shops = getAuthController();
        $employies = Employee::whereStatus('1')->get();
        $data['shops'] = $shops;
        $data['categories'] = $categories;
        $data['employies'] = $employies;
        $favcount = getFavoryController();
        $data['favcount'] = $favcount;

        return view('frontend.pages.employee', $data);
    }



}

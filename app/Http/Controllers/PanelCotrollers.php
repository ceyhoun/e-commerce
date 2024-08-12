<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Shopping;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\TopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class PanelCotrollers extends Controller
{

    public function adminlogin()
    {
        if (Auth::check()) {
            return redirect()->route('panel');
        }
        return view('backend.adminlogin');
    }

    public function adminloginauth(Request $request)
    {
        $email = $request->email;
        $password = $request->password;


        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->route('panel');
        } else {
            return redirect()->back()->with('error', 'İstifadeçi adı veya şifre sehvdir!...');
        }
    }

    public function admlogout()
    {
        Auth::logout();
        return redirect()->route('adminlogin');

    }
    public function panel()
    {
        $a = [1, 2, 3];
        return view('backend.pages.index', compact('a'));
    }

    public function category()
    {

        return view('backend.section.forms.addcategory');
    }

    public function addcategory(Request $request)
    {
        $categoryname = $request->categoryname;
        $categorycheck = $request->categorycheck === 'on' ? '1' : '0';



        //img
        $imagename = time() . '.' . $request->categoryimage->extension();
        $request->categoryimage->move(public_path('category_images'), $imagename);
        $file = "category_images/" . $imagename;




        $category = Category::create([
            'name' => $categoryname,
            'slug' => Str::slug($categoryname),
            'image' => $file,
            'status' => $categorycheck,
        ]);

        if ($category) {
            return redirect()->route('category');
        }



    }


    public function products()
    {
        //sizes
        $sizes = Size::all();
        $data['sizes'] = $sizes;
        //colors
        $colors = Color::all();
        $data['colors'] = $colors;

        $subcategories = Subcategory::where('status', '1')->get();
        $data['subcategories'] = $subcategories;

        return view('backend.section.forms.addproduct', $data);
    }

    public function addproducts(Request $request)
    {
        $name = $request->productname;
        $subcategory = $request->subcategoryid;
        $slug = Str::slug($name);
        $price = $request->productprice;
        $desctription = $request->productdesc;

        //img
        $image = null;
        if ($request->hasFile('productimg')) {
            $file = $request->file('productimg');

            // Dosya türü kontrolü
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = $file->getClientOriginalExtension();

            if ($file->isValid() && in_array($extension, $allowedExtensions)) {
                $imageName = time() . '.' . $extension;
                $file->move(public_path('product_images'), $imageName);
                $image = "product_images/" . $imageName;
            } else {
                // Dosya yükleme başarısız
                return back()->withErrors(['error' => 'Geçersiz dosya formatı veya dosya boyutu çok büyük']);
            }
        }



        $check = $request->productcheck === 'on' ? '1' : '0';

        $product = Product::create([
            'name' => $name,
            'subcategory_id' => $subcategory,
            'slug' => $slug,
            'price' => $price,
            'description' => $desctription,
            'images' => $image,
            'status' => $check,
        ]);


        if ($product) {
            if ($request->has('productsize') && $request->has('productcolor') && $request->has('productqty')) {
                $sizes = $request->productsize;
                $colors = $request->productcolor;
                $qtys = $request->productqty;

                foreach ($sizes as $size_id) {
                    foreach ($colors as $color_id) {
                        if (isset($qtys[$size_id][$color_id])) {
                            $quantity = $qtys[$size_id][$color_id];

                            DB::table('product_size_color')->insert(
                                [
                                    'product_id' => $product->id,
                                    'size_id' => $size_id,
                                    'color_id' => $color_id,
                                    'qty' => $quantity,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]
                            );
                        }
                    }
                }
            }


            return redirect()->route('products');
        }
    }

    public function subcategory()
    {
        $categories = Category::where('status', 1)->get();
        $data['categories'] = $categories;
        return view('backend.section.forms.addsubcategory', $data);
    }

    public function addsubcategory(Request $request)
    {
        $category = $request->integer('category_id') ? $request->integer('category_id') : null;
        $subcategoryname = $request->input('subcategoryname');
        $check = $request->input('subcategorycheck') === 'on' ? '1' : '0';

        $subcategory = Subcategory::create([
            'category_id' => $category,
            'name' => $subcategoryname,
            'slug' => Str::slug($subcategoryname),
            'status' => $check,
        ]);

        if ($subcategory) {
            return redirect()->route('panel');
        }
    }


    public function tables()
    {
        $showProduct = Product::with([
            'subcategory' => function ($query) {
                $query->select('id', 'name');

            },
            'colors' => function ($query) {
                $query->select('color_id', 'name');
            },
            'sizes' => function ($query) {
                $query->select('size_id', 'name');
            }
        ])
            ->get();

        $data['showProduct'] = $showProduct;


        return view('backend.section.tables.data', $data);
    }

    //chars

    public function chars()
    {
        return view('backend.section.charts.chartjs');
    }

    //message

    public function mailbox()
    {

        $categories = Category::whereStatus('1')->get();
        $data['categories'] = $categories;

        $shops = Shopping::sum('product_qty');

        $data['shops'] = $shops;

        return view('backend.section.mailbox.mailbox',$data);
    }

}
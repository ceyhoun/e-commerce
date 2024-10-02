<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\DiscountPercent;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Referance;
use App\Models\Shoe;
use App\Models\Shoes;
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
        $imagename = time() . '.' . $request->categoryimage->getClientOriginalExtension();
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

        $shoes = Shoe::all();
        $data['shoes'] = $shoes;


        $subcategories = Subcategory::where('status', '1')->get();
        $data['subcategories'] = $subcategories;

        return view('backend.section.forms.addproduct', $data);
    }

    public function addproducts(Request $request)
    {
        $name = $request->input('productname');
        $subcategory = $request->input('subcategoryid');
        $slug = Str::slug($name);
        $price = $request->input('productprice');
        $description = $request->input('productdesc');

        // Görsel yükleme
        $image = null;
        if ($request->hasFile('productimg')) {
            $file = $request->file('productimg');

            // Dosya türü ve boyutu kontrolü
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = $file->getClientOriginalExtension();
            $maxSize = 2097152; // 2MB

            if ($file->isValid() && in_array($extension, $allowedExtensions) && $file->getSize() <= $maxSize) {
                $imageName = time() . '.' . $extension;
                $file->move(public_path('product_images'), $imageName);
                $image = "product_images/" . $imageName;
            } else {
                return back()->withErrors(['error' => 'Geçersiz dosya formatı veya dosya boyutu çok büyük']);
            }
        }

        $check = $request->input('productcheck') === 'on' ? '1' : '0';

        // Ürün oluşturma
        $product = Product::create([
            'name' => $name,
            'subcategory_id' => $subcategory,
            'slug' => $slug,
            'price' => $price,
            'description' => $description,
            'images' => $image,
            'status' => $check,
        ]);

        if (!$product) {
            return back()->withErrors(['error' => 'Ürün eklenirken bir sorun oluştu.']);
        }

        // Ürün varyasyonları ekleme
        if ($request->has('productcolor') && $request->has('productqty')) {
            $colors = $request->input('productcolor');
            $qtys = $request->input('productqty');

            if ($request->has('productsize')) {
                $sizes = $request->input('productsize');

                foreach ($sizes as $size_id) {
                    foreach ($colors as $color_id) {
                        if (isset($qtys[$size_id][$color_id])) {
                            $quantity = $qtys[$size_id][$color_id];

                            DB::table('product_size_color')->updateOrInsert([
                                'product_id' => $product->id,
                                'size_id' => $size_id,
                                'color_id' => $color_id,
                            ], [
                                'qty' => $quantity,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            } elseif ($request->has('productshoe')) {
                $shoes = $request->input('productshoe');

                foreach ($shoes as $shoe_id) {
                    foreach ($colors as $color_id) {
                        if (isset($qtys[$shoe_id][$color_id])) {
                            $quantity = $qtys[$shoe_id][$color_id];

                            DB::table('product_shoe_color')->updateOrInsert([
                                'product_id' => $product->id,
                                'shoe_id' => $shoe_id,
                                'color_id' => $color_id,
                            ], [
                                'qty' => $quantity,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('products');
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

    public function pemployee()
    {
        return view('backend.section.forms.addemployee');
    }

    public function addpemployee(Request $request)
    {
        $name = $request->input('empname');
        $surname = $request->input('empsurname');
        $role = $request->input('empsurrole');
        $slug = Str::slug($name . $surname);
        $status = $request->input('empcheck') === 'on' ? '1' : '0';

        $image = null;
        if ($request->hasFile('empimg')) {
            $file = $request->file('empimg');

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extention = $file->getClientOriginalExtension();

            if ($file->isValid() && in_array($extention, $allowedExtensions)) {
                $image_name = time() . '.' . $extention;
                $file->move(public_path('employee_images'), $image_name);
                $image = "employee_images/" . $image_name;
            } else {
                return back()->withErrors(['error' => 'Geçersiz dosya formatı veya dosya boyutu çok büyük']);
            }

        }

        $employee = Employee::create(
            [
                'name' => $name,
                'surname' => $surname,
                'role' => $role,
                'slug' => $slug,
                'image' => $image,
                'status' => $status
            ]
        );

        if ($employee) {
            return redirect()->back()->with('success', 'True');
        }

        return redirect()->back()->with('danger', 'false');


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
        $chars =Subcategory::select('name',DB::raw('count(*) as totalcount'))
        ->groupBy('name')
        ->get();

        $data=[
            "chars" => $chars->pluck('name'),
            "totalcount" =>$chars->pluck('totalcount'),
        ];

        return view('backend.section.charts.chartjs',$data);
    }


    //message

    public function mailbox()
    {

        $categories = Category::whereStatus('1')->get();
        $data['categories'] = $categories;

        $shops = Shopping::sum('product_qty');

        $data['shops'] = $shops;

        return view('backend.section.mailbox.mailbox', $data);
    }

    public function referances()
    {
        return view('backend.section.forms.referance');
    }

    public function addreferances(Request $request)
    {
        $name = $request->refname;
        $status = $request->refstatus === 'on' ? '1' : '0';

        $image = null;
        if ($request->hasFile('reffile')) {
            $file = $request->file('reffile');

            // Dosya türü kontrolü
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = $file->getClientOriginalExtension();

            if ($file->isValid() && in_array($extension, $allowedExtensions)) {
                $imageName = time() . '.' . $extension;
                $file->move(public_path('referances_images'), $imageName);
                $image = "referances_images/" . $imageName;
            } else {
                // Dosya yükleme başarısız
                return back()->withErrors(['error' => 'Geçersiz dosya formatı veya dosya boyutu çok büyük']);
            }
        }


        $referance = Referance::create([
            'name' => $name,
            'image' => $image,
            'status' => $status,
        ]);

        if ($referance) {
            return redirect()->back()->with('success', 'Elave Edildi');
        }
        return redirect()->back()->with('error', 'Xeta...');
    }



    public function discountpercent()
    {
        $categories =Category::all();
        $data['categories']=$categories;
        return view('backend.section.forms.adddiscountpercent',$data);
    }

    public function adddiscountpercent(Request $request)
    {
        $discount_name =$request->input('discountname');
        $discount_percent =$request->input('discountpercent');
        $discount_status = $request->has('status')=='on' ? 1 : 0;

        $add_discount_percent =DiscountPercent::create([
            'name' =>$discount_name,
            'percent' =>$discount_percent,
            'is_active' =>$discount_status,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        if ($add_discount_percent) {
            return redirect()->back()->with('success',$discount_name. " ".'adlı endirim kampaniyası əlavə olundu');
        }
    }

    public function productdiscount()
    {
         $salecampaigns = DiscountPercent::where('is_active',1)->get();
         $data['salecampaigns']=$salecampaigns;
         $categories =Category::all();
        $data['categories']=$categories;
        return view('backend.section.forms.addproductdiscount',$data);
    }

    public function addproductdiscount()
    {
        return 'Ok';
    }

}

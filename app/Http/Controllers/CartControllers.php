<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class CartControllers extends Controller
{
    public function addToCart(Request $request, $product_id)
    {
        $user_id = Auth::id();
        $session_id = $request->session()->get('_token');

        $size_id = $request->input('size_id');
        $color_id = $request->input('color_id');
        $cartqty = $request->input('cartqty');

        //mehsulu tap ve stok idaresi et
        $product = Product::where('status', 1)->find($product_id);

        if (!$product) {
            return redirect()->back()->with('eroor', 'Məhsul Tapılmadı');
        }

        //stoku idare et

        $stockControl = DB::table('product_size_color')
            ->where('product_id', $product_id)
            ->where('size_id', $size_id)
            ->where('color_id', $color_id)
            ->first();

        if (!$stockControl) {
            return redirect()->back()->with('error', 'Stock information has been selected for this calendar');
        }

        if ($stockControl->qty < $cartqty) {
            return redirect()->back()->with('error', 'Stock not defined');
        }

        $cart = Shopping::where(function ($query) use ($user_id, $session_id) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->where('session_id', $session_id);
            }
        })
            ->where('product_id', $product_id)
            ->where('size_id', $size_id)
            ->where('color_id', $color_id)
            ->first();

        if ($cart) {

            $cart->save();
        } else {
            Shopping::create([
                'user_id' => $user_id,
                'session_id' => $session_id,
                'product_id' => $product_id,
                'product_qty' => $cartqty,
                'size_id' => $size_id,
                'color_id' => $color_id,
            ]);
        }

        //stoku güncelle
        DB::table('product_size_color')
            ->where('product_id', $product_id)
            ->where('size_id', $size_id)
            ->where('color_id', $color_id)
            ->decrement('qty', $cartqty);

        return redirect()->back()->with('success', 'Uğurla Elave Olundu!...');
    }

    public function itemDelete($id, $product_id)
    {
        // Sepetteki ürünü bul
        $order = Shopping::find($id);

        if ($order) {
            // İlgili ürünü bul

            $backqty = $order->product_qty;

            $product = Product::select('products.*', DB::raw('COALESCE(SUM(product_size_color.qty)) as total_qty'))
                ->join('product_size_color', 'products.id', '=', 'product_size_color.product_id')
                ->where('products.id', $product_id)
                ->groupBy('products.id')
                ->where('status', 1)->find($product_id);

            if ($product) {


                DB::table('product_size_color')
                    ->where('product_id', $product_id)
                    ->update(['qty' => DB::raw('qty + ' . $backqty)]);

                $order->delete();

                return redirect()->back()->with('success', 'Ürün sepetten silindi ve stok güncellendi.');
            }
        }

        return redirect()->back()->with('error', 'Sipariş silinirken veya ürün güncellenirken bir hata oluştu.');
    }

}

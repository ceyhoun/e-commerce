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
        $shoe_id = $request->input('shoe_id');
        $color_id = $request->input('color_id');
        $cartqty = $request->input('cartqty');

        //mehsulu tap ve stok idaresi et
        $product = Product::where('status', 1)->find($product_id);

        if (!$product) {
            return redirect()->back()->with('eroor', 'Məhsul Tapılmadı');
        }

        //stoku idare et
        if ($size_id) {
            $stockControl = DB::table('product_size_color')
                ->where('product_id', $product_id)
                ->where('size_id', $size_id)
                ->where('color_id', $color_id)
                ->first();
        } else {
            $stockControl = DB::table('product_shoe_color')
                ->where('product_id', $product_id)
                ->where('shoe_id', $shoe_id)
                ->where('color_id', $color_id)
                ->first();
        }

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
            ->where('shoe_id', $size_id)
            ->where('color_id', $color_id)
            ->first();

        if ($cart) {
            $cart->product_qty += $cartqty;
            $cart->save();
        } else {
            //sebeti yarad
            Shopping::create([
                'user_id' => $user_id,
                'session_id' => $session_id,
                'product_id' => $product_id,
                'product_qty' => $cartqty,
                'size_id' => $size_id,
                'shoe_id' => $shoe_id,
                'color_id' => $color_id,
            ]);
        }

        if ($size_id) {
            DB::table('product_size_color')
                ->where('product_id', $product_id)
                ->where('size_id', $size_id)
                ->where('color_id', $color_id)
                ->decrement('qty', $cartqty);
        }

        if ($shoe_id) {
            DB::table('product_shoe_color')
                ->where('product_id', $product_id)
                ->where('shoe_id', $shoe_id)
                ->where('color_id', $color_id)
                ->decrement('qty', $cartqty);
        }


        return redirect()->back()->with('success', 'Uğurla Elave Olundu!...');

    }

    public function itemDelete($id, $product_id)
    {
        $order = Shopping::find($id);

        if ($order) {

            $backqty = $order->product_qty;

            // Ürün ve stok bilgilerini kontrol et
            $productSizeColor = DB::table('product_size_color')
                ->where('product_id', $product_id)
                ->where('size_id', $order->size_id)
                ->where('color_id', $order->color_id)
                ->first();

            $productShoeColor = DB::table('product_shoe_color')
                ->where('product_id', $product_id)
                ->where('shoe_id', $order->shoe_id)
                ->where('color_id', $order->color_id)
                ->first();


            if ($productSizeColor) {
                DB::table('product_size_color')
                    ->where('product_id', $product_id)
                    ->where('size_id', $order->size_id)
                    ->where('color_id', $order->color_id)
                    ->increment('qty', $backqty);

            }

            if ($productShoeColor) {
                DB::table('product_shoe_color')
                    ->where('product_id', $product_id)
                    ->where('shoe_id', $order->shoe_id)
                    ->where('color_id', $order->color_id)
                    ->increment('qty', $backqty);
            }




            $order->delete();

            return redirect()->back()->with('success', 'Ürün sepetten silindi ve stok güncellendi.');
        }

        return redirect()->back()->with('error', 'Sipariş silinirken veya ürün güncellenirken bir hata oluştu.');
    }

    public function getproduct($productId)
    {
        $product = Product::find($productId);
        // ürün bulunamadıysa boş dönder
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ürün bulunamadı!'
            ], 404);
        }

        // Ürün bulunduysa JSON formatında ürünü döndür
        return response()->json([
            'status' => 'alindi',
            'data' => $product
        ], 200);
    }

}

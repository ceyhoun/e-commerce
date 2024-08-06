<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartControllers extends Controller
{
    public function addToCart(Request $request, $product_id)
    {
        $user_id =Auth::id();
        $session_id =$request->session()->get('_token');

        $size_id = $request->input('size_id');
        $color_id = $request->input('color_id');
        $product_qty = $request->input('product_qty');

        $cart =Shopping::where(function($query) use ($user_id,$session_id){
            if ($user_id) {
                $query->where('user_id',$user_id);
            } else {
                $query->where('session_id',$session_id);
            }
        })
        ->where('product_id',$product_id)
        ->where('size_id', $size_id)
        ->where('color_id', $color_id)
        ->first();

        if ($cart) {
            $cart->product_qty+=$product_qty;
            $cart->save();
        }else {
            Shopping::create([
                'user_id' =>$user_id,
                'session_id'=>$session_id,
                'product_id'=>$product_id,
                'product_qty'=>1,
                'size_id'=>$size_id,
                'color_id'=>$color_id,
            ]);
        }

        return redirect()->back()->with('success','Uğurla Elave Olundu!...');
    }
}

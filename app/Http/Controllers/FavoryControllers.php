<?php

namespace App\Http\Controllers;

use App\Models\Favory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class FavoryControllers extends Controller
{
    public function addFavory(Request $request, $product_id)
    {
        $user_id = Auth::id();
        $session_id = $request->session()->get('_token');

        $product = Product::where('status', 1)->find($product_id);

        if (!$product) {
            return redirect()->back()->with('error', 'Məhsul Tapılmadı');
        }

        $favory = Favory::where(function ($query) use ($user_id, $session_id) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->where('session_id', $session_id);
            }
        })
            ->where('product_id', $product_id)
            ->first();


        if ($favory) {
            return response()->json(['message' => 'Mehsul favlardadır'], 200);
        } else {
            Favory::create([
                'user_id' => $user_id,
                'session_id' => $session_id,
                'product_id' => $product_id,
                'favqty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Favorilere eklendi',
                'name' => $product->name,
            ], 200);
        }
    }

    public function deleteFavory(Request $request, $id, $product_id)
    {
        $favory = Favory::with([
            'products' => function ($q) {
                $q->select('id', 'name');
            }
        ])
        ->where('id',$id)
        ->where('product_id',$product_id)
        ->first();

        if ($favory) {
            $favory->delete();
        }


        return redirect()->back();
    }

}


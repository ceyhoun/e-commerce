<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class FavoryControllers extends Controller
{

    public function addFavory(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $favorites = session()->get('favorites', []);

            $favorites[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "images" => $product->images
            ];

            session()->put('favorites', $favorites);

            return response()->json(
                [
                    'success' => true,
                    'item_id' => $id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'images' => $product->images
                ]
            );
        }

        return response()->json(['success' => false, 'message' => 'Ürün bulunamadı.']);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class FavoryControllers extends Controller
{
    public function addFavory(Request $request,$productId)
    {
        $item_id =$productId;
        $favorites =$request->session()->get('favorites',[]);

        if (!is_array($favorites)) {
            $favorites = [];
        }

        if (!in_array($item_id,$favorites)) {
            $favorites=$item_id;
            session()->put('favorites',$favorites);
        }

        return response(['success'=>true,'item_id'=>$item_id]);

    }
}

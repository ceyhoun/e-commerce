<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function deletecomment(Request $request, $product_id)
    {
         $comment =Comments::find($product_id);

         if ($comment) {
            $comment->delete();
            return redirect()->back();
         }

    }
}

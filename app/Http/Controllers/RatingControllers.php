<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatingControllers extends Controller
{
    public function rating()
    {
        return view('frontend.pages.detail');
    }
}

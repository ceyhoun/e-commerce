<?php

use App\Models\Shopping;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getAuthController')) {
    function getAuthController()
    {
        $user_id = Auth::id();
        $session_id = request()->session()->get('_token');

        $get_control = Shopping::where(function ($query) use ($user_id, $session_id) {
            if ($user_id) {
                $query->where('user_id', $user_id);
            } else {
                $query->where('session_id', $session_id);
            }
        })->sum('product_qty');

        return $get_control;
    }
}

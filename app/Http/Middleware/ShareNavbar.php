<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShareNavbar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $navbarItems = [
            'Home' => route('home'),
            'About' => route('about'),
            'Contact' => route('contact'),
        ];

        view()->share('navbarItems', $navbarItems);
        return $next($request);
    }
}

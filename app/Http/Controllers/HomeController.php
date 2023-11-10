<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController
{
    /**
     * Returns home screen
     *
     * @return View
     */
    public function index(): View
    {
        return view('home');
    }
}
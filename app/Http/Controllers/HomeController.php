<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function landing()
    {
        $administrator = User::where('role_id', 1)->get();
        return view('welcome', compact('administrator'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

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

    /**
     * @return Application|Factory|View
     */
    public function landing()
    {
        $administrator = User::where('role_id', 1)->get();
        return view('welcome', compact('administrator'));
    }

    /**
     * @param Request $request
     * @return mixed|string
     */
    public function get_streets_where(Request $request)
    {
        if($request->ajax()){
            $helper = new Helper();
            return $helper->getAllStreetsWhere($request->city_id);
        }

        return 'Something went wrong';
    }

    /**
     * Returns all the streets
     */
    public function get_streets()
    {
        $helper = new Helper();
        return $helper->getAllContainers();
    }
}

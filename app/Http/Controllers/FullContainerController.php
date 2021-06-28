<?php

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Kreait\Firebase\Exception\DatabaseException;

class FullContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        // Retrieve all reports where 85 percent
        $helper = new Helper();
        $full_locations = $helper->almostAllFullContainers();

        return view('dashboard.fullcontainer.index', compact('full_locations'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws DatabaseException
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'street_id' => 'required',
            'city_id' => 'required'
        ]);

        $helper = new Helper($request->city_id, $request->street_id);
        $check = $helper->deleteFullContainer();

        $message = "There went something wrong!";

        if($check == true) $message = "Your container is cleaned!";

        return Redirect::back()->with('message', $message);
    }
}

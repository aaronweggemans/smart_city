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

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws DatabaseException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "city_id" => "required",
            "street_id" => "required",
            "street_name" => "required",
            "container_depth" => "required",
            "latitude" => "required",
            "longitude" => "required",
        ]);

        $helper = new Helper();
        $helper->addContainer($request);

        return Redirect::back()->with('message', 'Container is created!');
    }

    /**
     * Display the specified resource.
     *
     * @param $city_id
     * @param $street_id
     * @return Application|Factory|Response|View
     */
    public function show($city_id, $street_id)
    {
        $helper = new Helper();
        $container = $helper->getContainerWhere($city_id, $street_id);
        $city = $helper->getCityWhere($city_id);

        return view('dashboard.containers.show', compact('container', 'city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws DatabaseException
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            "city_id" => "required",
            "street_id" => "required",
            "street_name" => "required",
            "container_depth" => "required",
            "latitude" => "required",
            "longitude" => "required",
        ]);

        $helper = new Helper;
        $helper->editContainer($request);

        return Redirect::back()->with('message', 'Container is updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $city_id
     * @param $street_id
     * @return RedirectResponse
     * @throws DatabaseException
     */
    public function destroy($city_id, $street_id): RedirectResponse
    {
        $helper = new Helper;
        $helper->removeContainer($city_id, $street_id);

        return redirect('/dashboard/locations/')->with('message', 'Container is removed!');
    }
}

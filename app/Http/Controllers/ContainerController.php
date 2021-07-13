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
     * @throws DatabaseException
     */
    public function show($city_id, $street_id)
    {
        $helper = new Helper($city_id, $street_id);
        $container = $helper->getContainerWhere();
        $city = $helper->getCityWhere();

        return view('dashboard.containers.show', compact('container', 'city'));
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

        $request_data = [
            "container_depth" => $request->container_depth,
            "latitude" => $request->latitude,
            "longitude" => $request->longitude,
            "status" => true,
            "street_id" => $request->street_id,
            "street_name" => $request->street_name,
        ];

        $helper = new Helper;
        $helper->editContainer($request_data);

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
        $helper = new Helper($city_id, $street_id);
        $helper->removeContainer();

        return redirect('/dashboard/locations/')->with('message', 'Container is removed!');
    }
}

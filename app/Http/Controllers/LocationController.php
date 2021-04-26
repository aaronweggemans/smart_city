<?php

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationController extends Controller
{
    /**
     * @var Collection
     */
    public $locations;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $helper = new Helper();
        $locations = $this->paginate($helper->getAllLocations(), 5);
        $locations->setPath('locations');

        return view('dashboard.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('dashboard.locations.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "city_name" => "required",
            "street_name" => "required",
            "latitude" => "required|numeric",
            "longitude" => "required|numeric",
            "container_depth" => "required"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $city_id
     * @return Application|Factory|Response|View
     */
    public function show(int $city_id)
    {
        $helper = new Helper();
        $containers = $helper->getAllStreetsWhere($city_id);
        $city = $helper->getCityWhere($city_id);

        return view('dashboard.locations.details', compact('containers', 'city'));
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
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }
}

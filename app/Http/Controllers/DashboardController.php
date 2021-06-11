<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29-3-2021
 * Time: 12:43
 */

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Contracts\Support\Renderable;
use App\Charts\ContainerDistanceChart;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Exception\DatabaseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\User;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     * @throws DatabaseException
     */
    public function index(): Renderable
    {
        $helper = new Helper(Auth::user()->city_id, Auth::user()->street_id);
        $percentage = $helper->amountOfPercentTrashBinFull();

        $chart = new ContainerDistanceChart(
            $helper->firebaseDistanceLabels(),
            $helper->firebaseDistanceData()
        );

        $latlong = $helper->getContainerWhere(Auth::user()->city_id, Auth::user()->street_id);
        $latitude = $latlong['latitude'];
        $longitude = $latlong['longitude'];

        $container_recommendation = '';
        $recommended_remaining = '';
        $recommended_percentage = '';

        if($percentage >= 80) {
            $container_recommendation = $helper->returnTheClosestArrayValue($latitude, $longitude);
            $recommended_data_helper =  new Helper(Auth::user()->city_id, $container_recommendation[0]);
            $recommended_remaining = $recommended_data_helper->containers[count($recommended_data_helper->containers) - 1]['current_depth'];

            // dd($container_recommendation);
            if($container_recommendation[0] != 'error') {
                $amount_of_times = $container_recommendation[2] / $recommended_remaining;
                $recommended_percentage = floor(100 / $amount_of_times);
            }

            // Gets the distance and rounds
        }

        $today = Carbon::now()->format('d M Y');
        $all_users = User::where('role_id', '1')->count();
        $all_registered_containers = $helper->getAmountOfRegisteredContainer();
        $container_size = $helper->getContainerDepth();

        return view('dashboard.dashboard', compact(
            'chart',
            'percentage',
            'today',
            'all_users',
            'all_registered_containers',
            'container_size',
            'container_recommendation',
            'recommended_remaining',
            'recommended_percentage'
        ));
    }

    /**
     * Returns the data for as well as all city garbage locations, and the distance chart in a line
     *
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function realtime_chart(): JsonResponse
    {
        $helper = new Helper(Auth::user()->city_id, Auth::user()->street_id);

        $container_distance_chart_for_all_cities_labels = [];
        $container_distance_chart_for_all_cities_data = [];

        $container_distance_chart_labels = $helper->firebaseDistanceLabels();
        $container_distance_chart_data = $helper->firebaseDistanceData();

        $all_streets = $helper->getAllStreetsWhere(Auth::user()->city_id);

        // Percentage updates in dashboard
        $percentage = $helper->amountOfPercentTrashBinFull();

        foreach ($all_streets as $label) {
            array_push($container_distance_chart_for_all_cities_labels, $label['street_name']);
            array_push($container_distance_chart_for_all_cities_data, end($label['tracking_data'])['current_depth']);
        }

        return response()->json(compact(
            'container_distance_chart_for_all_cities_labels',
            'container_distance_chart_for_all_cities_data',
            'container_distance_chart_labels',
            'container_distance_chart_data',
            'percentage'
        ));
    }
}

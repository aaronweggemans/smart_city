<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29-3-2021
 * Time: 12:43
 */

namespace App\Http\Controllers;

use App\Helper;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Exception\DatabaseException;
use Illuminate\Support\Facades\Auth;
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
        $user_container = $helper->getContainerWhere(Auth::user()->city_id, Auth::user()->street_id);

        $recommended_remaining = 1;
        $recommended_percentage = 1.0;
        $link = '';
        $link_in_iframe = '';

        $container_recommendation = $helper->returnTheClosestArrayValue(
            $user_container['latitude'],
            $user_container['longitude']
        );

        if ($percentage >= 85 && is_int($container_recommendation[0])) {
            $recommended_data_helper = new Helper(Auth::user()->city_id, $container_recommendation[0]);
            $recommended_remaining = $recommended_data_helper->containers[count($recommended_data_helper->containers) - 1]['current_depth'];

            try {
                $amount_of_times = $container_recommendation[2] / $recommended_remaining;
                $recommended_percentage = floor(100 / $amount_of_times);
            } catch (Exception $e) {
                $recommended_percentage = 0;
            }

            $link = "https://www.google.nl/maps/dir/" .
                $user_container['latitude'] . "," .
                $user_container['longitude'] . "/" .
                $container_recommendation[3] . "," .
                $container_recommendation[4];

            $link_in_iframe = "https://www.google.com/maps/embed/v1/directions?key=AIzaSyA1s66kXMm6obk6K67NcL1zvTNwgAC7KTU&origin=" .
                $user_container['latitude'] . "," .
                $user_container['longitude'] . "&destination=$container_recommendation[3],$container_recommendation[4]&zoom=13";
        }

        $today = Carbon::now()->format('d M Y');
        $all_users = User::all()->count();
        $all_registered_containers = $helper->getAmountOfRegisteredContainer();
        $container_size = $helper->getContainerDepth();

        return view('dashboard.dashboard', compact(
            'percentage',
            'today',
            'all_users',
            'all_registered_containers',
            'container_size',
            'container_recommendation',
            'recommended_remaining',
            'recommended_percentage',
            'link',
            'link_in_iframe'
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

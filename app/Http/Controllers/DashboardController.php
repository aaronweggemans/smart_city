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
use Kreait\Firebase\Exception\DatabaseException;
use Illuminate\Support\Facades\Auth;

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
        $percentage = $helper->amount_of_percent_trash_bin_full();

        $chart = new ContainerDistanceChart(
            $helper->firebase_distance_labels(),
            $helper->firebase_distance_data()
        );

        $today = Carbon::now()->format('d M Y');
        $all_users = $helper->count_all_users();
        $all_registered_containers = $helper->getAmountOfRegisteredContainer();

        return view('dashboard.dashboard', compact(
            'chart',
            'percentage',
            'today',
            'all_users',
            'all_registered_containers'
        ));
    }

    /**
     * Updates your charts by an ajax call to this route
     */
    public function update_chart()
    {
        $labels = ['2021', '2022', '2023', '2024', '2025'];
        $data = $this->array_random_length(5, 0, 15);

        return response()->json(compact('labels', 'data'));
    }

    /**
     * This returns an array with random values with a length based on the parameter
     * @param $arrayLength
     * @param int $from
     * @param int $to
     * @return array
     */
    public function array_random_length($arrayLength, $from = 1, $to = 10): array
    {
        $array_with_random_integers = [];

        for ($i = 1; $i <= $arrayLength; $i++) {
            array_push($array_with_random_integers, rand($from, $to));
        }

        return $array_with_random_integers;
    }
}

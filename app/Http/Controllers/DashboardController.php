<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29-3-2021
 * Time: 12:43
 */

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;

use App\Charts\ContainerDistanceChart;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
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
     * @return Application|Factory|View
     */
    public function settings()
    {
        return view('dashboard.settings');
    }
}

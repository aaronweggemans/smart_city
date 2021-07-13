<?php

namespace App;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;

class Helper extends Model
{
    public $firebase;
    public $containers;
    public $initialize;
    public $city_id;
    public $street_id;

    /**
     * Makes the connection to your firebase database
     * FirebaseController constructor.
     * Helper constructor.
     * @param int $city_id
     * @param int $street_id
     * @throws DatabaseException
     */
    public function __construct(int $city_id = 0, int $street_id = 0)
    {
        // Geen idee waarom deze shit moet
        parent::__construct();

        $this->city_id = $city_id;
        $this->street_id = $street_id;

        $db = (new Factory)->withServiceAccount(__DIR__ . '/Http/Controllers/FirebaseKey.json')
            ->withDatabaseUri('https://smartcity-75e0e-default-rtdb.firebaseio.com/');
        $db_initialize = $db->createDatabase();
        $this->initialize = $db_initialize;

        $collection = collect($db_initialize->getReference('cities')->getValue());
        $this->firebase = $collection;

        $containers = collect($collection
            ->firstWhere('city_id', $city_id)['containers'])
            ->firstWhere('street_id', $street_id)['tracking_data'];

        $this->containers = $containers;
    }

    /**
     * Returns a array with the values in tracking data from the database
     * @return mixed
     */
    public function firebaseDistanceData(): array
    {
        $distance_in_array = [];

        foreach ($this->containers as $firebase_row) {
            array_push($distance_in_array, $firebase_row['current_depth']);
        }

        return $distance_in_array;
    }

    /**
     * Returns all the labels for the chart in format Y-m-d
     * @return array
     */
    public function firebaseDistanceLabels(): array
    {
        $dates_in_array = [];

        foreach ($this->containers as $firebase_row) {
            $push_date = date("Y-m-d", strtotime($firebase_row['day']));
            array_push($dates_in_array, $push_date);
        }

        return $dates_in_array;
    }

    /**
     * Returns the container depth in a integer
     * @return int
     */
    public function getContainerDepth(): int
    {
        return collect($this->firebase
            ->firstWhere('city_id', Auth::user()->city_id)['containers'])
            ->firstWhere('street_id', Auth::user()->street_id)['container_depth'];
    }

    /**
     * Returns the amount of registered containers
     * @return int
     */
    public function getAmountOfRegisteredContainer(): int
    {
        $amount_of_containers = 0;

        foreach ($this->firebase as $city) $amount_of_containers += count($city['containers']);

        return $amount_of_containers;
    }

    /**
     * Returns an array with all the values from the containers
     * @return array
     */
    public function getAllContainers(): array
    {
        $firebase = $this->firebase;

        $containers = [];

        foreach ($firebase as $location) {
            foreach ($location['containers'] as $container) {
                array_push($containers, $container);
            }
        }

        return $containers;
    }

    /**
     * Returns all the containers based on the city id
     * @return mixed
     */
    public function getAllStreetsWhere(): array
    {
        return $this->firebase->firstWhere('city_id', $this->city_id)['containers'];
    }

    /**
     * Returns the city based on the city id
     * @return mixed
     */
    public function getCityWhere(): array
    {
        return $this->firebase->firstWhere('city_id', $this->city_id);
    }

    /**
     * Retrieves the container based on the city id and street id
     * @return array
     */
    public function getContainerWhere(): array
    {
        return collect($this->firebase->firstWhere('city_id', $this->city_id)['containers'])
            ->firstWhere('street_id', $this->street_id);
    }

    /**
     * Edits a container
     * @param $request
     * @throws DatabaseException
     */
    public function editContainer($request)
    {
        $this->initialize
            ->getReference('cities')
            ->getChild($request->city_id)
            ->getChild('containers')
            ->getChild($request->street_id)
            ->update($request);
    }

    /**
     * Removes a container from firebase
     * @throws DatabaseException
     */
    public function removeContainer()
    {
        $this->initialize
            ->getReference('cities')
            ->getChild($this->city_id)
            ->getChild('containers')
            ->getChild($this->street_id)
            ->remove();
    }

    /**
     * @param $request
     * @throws DatabaseException
     */
    public function addContainer($request)
    {
        $request_data = [
            "container_depth" => $request->container_depth,
            "latitude" => $request->latitude,
            "longitude" => $request->longitude,
            "status" => true,
            "street_id" => $request->street_id,
            "street_name" => $request->street_name,
        ];

        $this->initialize
            ->getReference('cities')
            ->getChild($request->city_id)
            ->getChild('containers')
            ->getChild($request->street_id)
            ->push($request_data);
    }

    /**
     * Returns the amount value based on parameters
     * @param $current_depth
     * @param $container_depth
     * @return int
     */
    public function percentageOfBin($current_depth, $container_depth): int
    {
        try {
            // Devides the original size from the container through the distance
            $amount_of_times = $container_depth / $current_depth;

            // Gets the distance and rounds
            $test = floor(100 / $amount_of_times);
        } catch (Exception $e) {
            $test = 0;
        }

        // Returns an integer
        return (intval($test));
    }

    /**
     * Retrieves all the containers where more than 85 percent
     */
    public function almostAllFullContainers(): collection
    {
        $all_containers_with_percentage = [];

        foreach ($this->firebase as $city_container) {
            $city_id = $city_container['city_id'];

            foreach ($city_container['containers'] as $container) {
                $container_depth = $container['container_depth'];
                $current_depth_of_container = end($container['tracking_data'])['current_depth'];

                $percentage = $this->percentageOfBin($current_depth_of_container, $container_depth);

                if ($percentage >= 85) {
                    $container['percentage'] = $percentage;
                    $container['city_id'] = $city_id;

                    array_push($all_containers_with_percentage, $container);
                }
            }
        }

        return collect($all_containers_with_percentage);
    }

    /**
     * Cleans up a full container
     *
     * @return bool
     * @throws DatabaseException
     */
    public function deleteFullContainer(): bool
    {
        try {
            $this->initialize
                ->getReference('cities')
                ->getChild($this->city_id)
                ->getChild('containers')
                ->getChild($this->street_id)
                ->getChild("tracking_data")
                ->remove()
                ->set([
                    0 => [
                        "current_depth" => 0,
                        "day" => Carbon::now()->format('Y-m-d'),
                        "id" => 0,
                        "time" => Carbon::now()->toTimeString()
                    ]
                ]);

            $check = true;
        } catch (Exception $e) {
            $check = false;
        }

        return $check;
    }

    /**
     * Returns the closest array from the list items
     * @param $lat
     * @param $long
     * @return array
     */
    public function returnTheClosestArrayValue($lat, $long): array
    {
        $items_list = $this->firebase->firstWhere('city_id', $this->city_id)['containers'];
        $list_of_sub_locations = [];

        try {
            // Removes its own street
            unset($items_list[Auth::user()->street_id]);

            foreach ($items_list as $container_check) {
                $temp_container_depth = $container_check['container_depth'];
                $current_depth = end($container_check['tracking_data'])['current_depth'];

                if ($this->percentageOfBin($current_depth, $temp_container_depth) < 85) {
                    array_push($list_of_sub_locations, [
                        "street_id" => $container_check['street_id'],
                        "street_name" => $container_check['street_name'],
                        "container_depth" => $container_check['container_depth'],
                        "latitude" => $container_check['latitude'],
                        "longitude" => $container_check['longitude']
                    ]);
                }
            }
        } catch (Exception $exception) {
            $list_of_sub_locations = ["error" => $exception->getMessage()];
        }

        if (!empty($list_of_sub_locations)) {
            $distances = array_map(function ($item) use ($lat, $long) {
                $row_distance = array_slice($item, -2);
                $comparison = ["latitude" => $lat, "longitude" => $long];
                return $this->calculateDistance($row_distance, $comparison);
            }, $list_of_sub_locations);

            asort($distances);

            $list_of_sub_locations = $list_of_sub_locations[key($distances)];
        } else {
            $list_of_sub_locations = ["error" => "Er zijn geen sublocaties meer"];
        }

        return $list_of_sub_locations;
    }

    /**
     * Calculates the most nearby container based on the distance
     * @param $row_distance
     * @param $comparison
     * @return float
     */
    public function calculateDistance($row_distance, $comparison): float
    {
        $theta = $row_distance['longitude'] - $comparison['longitude'];

        $dist = sin(deg2rad($row_distance['latitude'])) *
            sin(deg2rad($comparison['latitude'])) +
            cos(deg2rad($row_distance['latitude'])) *
            cos(deg2rad($comparison['latitude'])) *
            cos(deg2rad($theta));

        $dist = acos($dist);

        $dist = rad2deg($dist);

        return $dist * 60 * 1.1515;
    }
}

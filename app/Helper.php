<?php

namespace App;

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
    public function __construct($city_id = 0, $street_id = 0)
    {
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
            array_push($distance_in_array, $firebase_row['remaining_distance']);
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
     * Counts how many percent the container is full
     */
    public function amountOfPercentTrashBinFull(): int
    {
        // Gets the distance from the last row in the database
        $distance = end($this->containers)['remaining_distance'];

        // Get the container depth
        $container_depth = collect($this->firebase
            ->firstWhere('city_id', Auth::user()->city_id)['containers'])
            ->firstWhere('street_id', Auth::user()->street_id)['container_depth'];

        // Devides the original size from the container through the distance
        $amount_of_times = $container_depth / $distance;

        // Gets the distance and rounds
        $test = floor(100 / $amount_of_times);

        // Returns an integer
        return (intval($test));
    }

    /**
     * Returns the container depth in a integer
     * @return int
     */
    public function getContainerDepth(): int
    {
        return collect($this->firebase
            ->firstWhere('city_id', Auth::user()->city_id)['containers'])
            ->firstWhere('street_id', Auth::user()->street_id)['container_depth'];;
    }

    /**
     * Returns the amount of registered containers
     * @return int
     */
    public function getAmountOfRegisteredContainer(): int
    {
        $amount_of_containers = 0;

        foreach ($this->firebase as $city) {
            $amount_of_containers += count($city['containers']);
        }

        return $amount_of_containers;
    }

    /**
     * @return Collection
     */
    public function getAllLocations(): Collection
    {
        return $this->firebase;
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
     * @param $city_id
     * @return mixed
     */
    public function getAllStreetsWhere(int $city_id)
    {
        return $this->firebase->firstWhere('city_id', $city_id)['containers'];
    }

    /**
     * Returns the city based on the city id
     * @param $city_id
     * @return mixed
     */
    public function getCityWhere(int $city_id): array
    {
        return $this->firebase->firstWhere('city_id', $city_id);
    }

    /**
     * Retrieves the container based on the city id and street id
     * @param int $city_id
     * @param int $street_id
     * @return array
     */
    public function getContainerWhere(int $city_id, int $street_id) : array
    {
        return collect($this->firebase->firstWhere('city_id', $city_id)['containers'])
            ->firstWhere('street_id', $street_id);
    }

    /**
     * Edits a container
     * @param $request
     * @throws DatabaseException
     */
    public function editContainer($request)
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
            ->update($request_data);
    }

    /**
     * Removes a container from firebase
     * @param $city_id
     * @param $street_id
     * @throws DatabaseException
     */
    public function removeContainer($city_id, $street_id)
    {
        $this->initialize
            ->getReference('cities')
            ->getChild($city_id)
            ->getChild('containers')
            ->getChild($street_id)
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
     * @param $remaining_distance
     * @param $container_depth
     * @return int
     */
    public function percentage_of_bin($remaining_distance, $container_depth): int
    {
        // Devides the original size from the container through the distance
        $amount_of_times = $container_depth / $remaining_distance;

        // Gets the distance and rounds
        $test = floor(100 / $amount_of_times);

        // Returns an integer
        return (intval($test));
    }

    /**
     * Returns the closest array from the list items
     * @param $lat
     * @param $long
     * @return array
     */
    public function returnTheClosestArrayValue($lat, $long): array
    {
        $ref = [$lat, $long];
        $list_of_sub_locations = [];
        $items_list = $this->firebase->firstWhere('city_id', $this->city_id)['containers'];

        try{
            // Removes its own street
            unset($items_list[Auth::user()->street_id]);
            foreach($items_list as $converter)
            {
                $temp_container_depth = $converter['container_depth'];
                $remaining_distance = end($converter['tracking_data'])['remaining_distance'];

                $percentage = $this->percentage_of_bin($remaining_distance, $temp_container_depth);

                if($percentage < 70){
                    $update = [
                        $converter['street_name'],
                        $converter['container_depth'],
                        $converter['latitude'],
                        $converter['longitude']
                    ];
                    array_push($list_of_sub_locations, $update);
                }
            }
        }
        catch(\Exception $exception) {
            dd($exception);
        }

        if(empty($list_of_sub_locations)) {
            $no_data = ["Alle prullebakken zijn vol!", 0, $lat, $long];
            array_push($list_of_sub_locations, $no_data);
        }

        $distances = array_map(function($item) use($ref) {
            $a = array_slice($item, -2);
            return $this->calculateDistance($a, $ref);
        }, $list_of_sub_locations);

        asort($distances);

        return $list_of_sub_locations[key($distances)];
    }

    /**
     * Calculates the most close by distance
     * @param $a
     * @param $b
     * @return float
     */
    public function calculateDistance($a, $b): float
    {
        list($lat1, $lon1) = $a;
        list($lat2, $lon2) = $b;

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        return $dist * 60 * 1.1515;
    }
}

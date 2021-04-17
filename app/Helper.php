<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Factory;

class Helper extends Model
{
    public $firebase;
    public $containers;
    public $container_size_in_height = 230;

    /**
     * Makes the connection to your firebase database
     * FirebaseController constructor.
     * Helper constructor.
     * @param int $city_id
     * @param int $street_id
     * @throws DatabaseException
     */
    public function __construct($city_id = 1, $street_id = 1)
    {
        $db = (new Factory)->withServiceAccount(__DIR__ . '/Http/Controllers/FirebaseKey.json')
            ->withDatabaseUri('https://smartcity-75e0e-default-rtdb.firebaseio.com/');

        $db_initialize = $db->createDatabase();
        $this->firebase = collect($db_initialize->getReference('cities')->getValue());

        $collection = collect($db_initialize->getReference('cities')->getValue());

        $containers = collect($collection
            ->firstWhere('city_id', $city_id)['containers'])
            ->firstWhere('street_id', $street_id)['tracking_data'];

        $this->containers = $containers;
    }

    /**
     * Returns a array with the values in tracking data from the database
     * @return mixed
     */
    public function firebase_distance_data(): array
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
     * @throws DatabaseException
     */
    public function firebase_distance_labels(): array
    {
        $dates_in_array = [];

        foreach ($this->containers as $firebase_row) {
            $push_date = date("Y-m-d", strtotime($firebase_row['day']));
            array_push($dates_in_array, $push_date);
        }

        return $dates_in_array;
    }

    /**
     * Returns the last row from tracking data
     */
    public function firebase_get_last_object_from_tracking_data(): array
    {
        return end($this->containers);
    }

    /**
     * Counts how many percent the container is full
     */
    public function amount_of_percent_trash_bin_full(): int
    {
        // Gets the distance from the last row in the database
        $distance = $this->firebase_get_last_object_from_tracking_data()['remaining_distance'];

        // Devides the original size from the container through the distance
        $amount_of_times = $this->container_size_in_height / $distance;

        // Gets the distance and rounds
        $test = floor(100 / $amount_of_times);

        // Returns an integer
        return (intval($test));
    }

    /**
     * Returns all the rows, (represents all the registered users)
     * @return mixed
     */
    public function count_all_users(): int
    {
        return User::where('role_id', 2)->count();
    }

    /**
     * @return int
     */
    public function count_all_administrators(): int
    {
        return User::where('role_id', 1)->count();
    }

    /**
     * Returns the amount of registered containers
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
     * Returns all the containers based on the city id
     * @param $city_id
     * @return mixed
     */
    public function getAllStreetsWhere($city_id)
    {
        return $this->firebase->firstWhere('city_id', $city_id)['containers'];
    }
}

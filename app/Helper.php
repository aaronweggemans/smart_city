<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Factory;

class Helper extends Model
{
    public $firebase;
    public $container_size_in_height = 230;

    /**
     * Makes the connection to your firebase database
     * FirebaseController constructor.
     * Helper constructor.
     */
    public function __construct()
    {
        $db = (new Factory)->withServiceAccount(__DIR__ . '/Http/Controllers/FirebaseKey.json')
            ->withDatabaseUri('https://smartcity-75e0e-default-rtdb.firebaseio.com/');

        $this->firebase = $db->createDatabase();
    }

    /**
     * Returns a array with the values in tracking data from the database
     * @return mixed
     * @throws DatabaseException
     */
    public function firebase_distance_data(): array
    {
        $reference = $this->firebase->getReference('tracking_data');
        $array_with_all_tracking_data = $reference->getValue();

        $distance_in_array = [];

        foreach ($array_with_all_tracking_data as $firebase_row) {
            array_push($distance_in_array, $firebase_row['distance']);
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
        $reference = $this->firebase->getReference('tracking_data');
        $array_with_all_tracking_data = $reference->getValue();

        $dates_in_array = [];

        foreach ($array_with_all_tracking_data as $firebase_row) {
            $push_date = date("Y-m-d", strtotime($firebase_row['day']));
            array_push($dates_in_array, $push_date);
        }

        return $dates_in_array;
    }

    /**
     * Returns the last row from tracking data
     * @throws DatabaseException
     */
    public function firebase_last_row_from_tracking_data(): array
    {
        $reference = $this->firebase->getReference('tracking_data');
        $array_with_all_tracking_data = $reference->getValue();
        return end($array_with_all_tracking_data);
    }

    /**
     * Counts how many percent the container is full
     * @throws DatabaseException
     */
    public function amount_of_percent_trash_bin_full(): int
    {
        // Gets the distance from the last row in the database
        $distance = $this->firebase_last_row_from_tracking_data()['distance'];

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
     * Returns all the locations from the firebase environment
     * TODO: GO FURTHER HERE MAKE LOCATION LIST
     */
    public function getAllLocations()
    {
        $reference = $this->firebase->getReference('locations');
        $locations = $reference->getValue();
        return $locations;
    }

    /**
     * Returns the amount of locations counted in the firebase store
     * @return int
     */
    public function getAmountOfLocations(): int
    {
        return count($this->getAllLocations());
    }
}

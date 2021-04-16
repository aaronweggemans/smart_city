<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Factory;

class FirebaseController extends Controller
{
    public $database;

    /**
     * Makes the connection to your firebase database
     * FirebaseController constructor.
     */
    public function __construct()
    {
        $db = (new Factory)->withServiceAccount(__DIR__ . '/FirebaseKey.json')
            ->withDatabaseUri('https://smartcity-75e0e-default-rtdb.firebaseio.com/');

        $this->database = $db->createDatabase();
    }

    /**
     * Returns a json with the values in tracking data from the database
     * @return mixed
     * @throws DatabaseException
     */
    public function index()
    {
        $reference = $this->database->getReference('tracking_data');

        $value = $reference->getValue();

        return $value;
    }
}

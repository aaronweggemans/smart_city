<?php

namespace App;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kreait\Firebase\Factory;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;
    use Timestamp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'role_id', 'email', 'city_id', 'street_id', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns the users role name
     */
    public function getRoleName(): string
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->first()->name;
    }

    /**
     * TODO: PAGE LOAD IS GETTING HIGH BECAUSE OF CONSTANT HELPER CALLS
     * TODO: FIX THIS LATER ON
     */
    public function make_firebase_connection(): Collection
    {
        $db = (new Factory)->withServiceAccount(__DIR__ . '/Http/Controllers/FirebaseKey.json')
            ->withDatabaseUri('https://smartcity-75e0e-default-rtdb.firebaseio.com/');
        $db_initialize = $db->createDatabase();

        return collect($db_initialize->getReference('cities')->getValue());
    }

    /**
     * Returns the user's city name
     * @return mixed
     */
    public function getCityName(): string
    {
        return $this->make_firebase_connection()
            ->firstWhere('city_id', $this->city_id)['city_name'];
    }

    /**
     * Returns the user's street name
     * @return mixed
     */
    public function getStreetName() : string
    {
        return collect($this->make_firebase_connection()
            ->firstWhere('city_id', $this->city_id)['containers'])
            ->firstWhere('street_id', $this->street_id)['street_name'];
    }

    /**
     * Returns the user image
     * @return string
     */
    public function getAvatarImage() : string
    {
        $imagePlaceholder = asset('storage/images/profiles') . '/' . $this->avatar;

        if(empty($this->avatar)) $imagePlaceholder = asset('img/user-image-placeholder.png');

        return $imagePlaceholder;
    }
}

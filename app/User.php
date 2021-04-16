<?php

namespace App;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'name', 'role_id', 'email', 'password',
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
     * Retuns the users role name
     * TODO: Relation call is still wrong, please notice the use of ->first()
     * WTF :( https://stackoverflow.com/questions/59781859/does-a-one-to-one-relationship-in-laravel-always-need-first
     *
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getRoleName()
    {
        $item = $this->belongsTo(Role::class, 'role_id', 'id');
        return $item->first()->name;
    }
}

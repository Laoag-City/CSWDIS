<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $hidden = [
        'password',
    ];

    public function confidential_viewers()
    {
    	return $this->hasMany('App\ConfidentialViewer', 'user_id', 'user_id');
    }

    public function client_record_histories()
    {
    	return $this->hasMany('App\ClientRecordHistory', 'user_id', 'user_id');
    }
}

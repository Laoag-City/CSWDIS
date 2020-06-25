<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'client_id';

    public function records()
    {
    	return $this->hasMany('App\Record', 'client_id', 'client_id');
    }

    public function client_record_histories()
    {
    	return $this->hasMany('App\ClientRecordHistory', 'client_id', 'client_id');
    }

    public function toNiceBirthday()
    {
    	return date('M d, Y', strtotime($this->date_of_birth));
    }
}

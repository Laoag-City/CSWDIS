<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $primaryKey = 'record_id';

    public function client()
    {
    	return $this->belongsTo('App\Client', 'client_id', 'client_id');
    }

    public function service()
    {
    	return $this->belongsTo('App\Service', 'service_id', 'service_id');
    }

    public function confidential_viewers()
    {
    	return $this->hasMany('App\ConfidentialViewer', 'record_id', 'record_id');
    }

    public function client_record_histories()
    {
    	return $this->hasMany('App\ClientRecordHistory', 'record_id', 'record_id');
    }
}

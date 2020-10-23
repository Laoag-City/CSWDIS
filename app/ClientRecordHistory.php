<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientRecordHistory extends Model
{
    protected $primaryKey = 'client_record_id';

    public function client()
    {
    	return $this->belongsTo('App\Client', 'client_id', 'client_id');
    }

    public function beneficiary()
    {
        return $this->belongsTo('App\Beneficiary', 'beneficiary_id', 'beneficiary_id');
    }

    public function record()
    {
    	return $this->belongsTo('App\Record', 'record_id', 'record_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}

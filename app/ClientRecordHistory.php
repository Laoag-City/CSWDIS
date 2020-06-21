<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientRecordHistory extends Model
{
    protected $primaryKey = 'client_record_id';

    public function client()
    {
    	$this->belongsTo('App\Client', 'client_id', 'client_id');
    }

    public function record()
    {
    	$this->belongsTo('App\Record', 'record_id', 'record_id');
    }

    public function user()
    {
    	$this->belongsTo('App\User', 'user_id', 'user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfidentialViewer extends Model
{
    protected $primaryKey = 'confidential_viewer_id';

    public function record()
    {
    	$this->belongsTo('App\Record', 'record_id', 'record_id');
    }

    public function user()
    {
    	$this->belongsTo('App\User', 'user_id', 'user_id');
    }
}

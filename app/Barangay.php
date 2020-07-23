<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $primaryKey = 'barangay_id';

    public function clients()
    {
    	return $this->hasMany('App\Client', 'barangay_id', 'barangay_id');
    }
}

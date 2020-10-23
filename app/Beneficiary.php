<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $primaryKey = 'beneficiary_id';

    public function records()
    {
    	return $this->hasMany('App\Record', 'beneficiary_id', 'beneficiary_id');
    }

    public function client_record_histories()
    {
    	return $this->hasMany('App\ClientRecordHistory', 'beneficiary_id', 'beneficiary_id');
    }

    public function barangay()
    {
        return $this->belongsTo('App\Barangay', 'barangay_id', 'barangay_id');
    }

    public function toNiceBirthday()
    {
    	return date('M d, Y', strtotime($this->date_of_birth));
    }
}

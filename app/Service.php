<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'service_id';

    public function records()
    {
    	return $this->hasMany('App\Record', 'service_id', 'service_id');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id', 'category_id');
    }
}

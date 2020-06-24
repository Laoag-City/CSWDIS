<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey ='category_id';

    public function services()
    {
    	return $this->hasMany('App\Service', 'category_id', 'category_id');
    }
}

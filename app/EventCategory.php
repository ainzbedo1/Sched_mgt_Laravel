<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    //
    public function event()
    	{
    		return $this->hasMany('App\event', 'evcat_id');
    	}
    	
    protected $fillable = [
        'ev_category_name',
    ];

    public $timestamps = false;
}

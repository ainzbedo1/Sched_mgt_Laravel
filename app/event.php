<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    //
    public function eventCategory()
    	{
    		return $this->belongsTo('App\EventCategory', 'evcat_id');
        }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    protected $fillable = [
        'event_name', 'event_desc', 'event_status', 'event_start', 'event_finish', 'evcat_id', 'user_id',
    ];

    public $timestamps = false;
}

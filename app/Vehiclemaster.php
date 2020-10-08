<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiclemaster extends Model
{
    protected $table = 'vehicle_master';

    public function trips()
	{
		return $this->hasMany('App\Trips','vehicle_id');
	}
	
}

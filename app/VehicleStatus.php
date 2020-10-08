<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    protected $table = 'vehicle_status';

    public function trip(){
    	return $this->belongsTo('App\Trips','trip_id');
    }
    public function beatplan(){
    	return $this->belongsTo('App\Beatplan','beatplan_id');
    }
    public function vehicle(){
    	return $this->belongsTo('App\Vehiclemaster','vehicle_id');
    }
    public function verified(){
    	return $this->belongsTo('App\Vehiclemaster','vehicle_id');
    }
    public function client(){
    	return $this->belongsTo('App\User','client_id');
    }
}
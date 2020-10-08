<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Trips;
use App\TripData;


class Beatplan extends Model
{
	protected $table = 'beatplans';

	protected $fillable = [
		'client_id',
		'site_id',
		'mp_zone',
		'added_date',
		'effective_date',
		'mode',
		'quantity',
		'added_by'
	];

	public function beatplan_data()
	{
		return $this->hasMany('App\BeatPlanData', 'beatplan_id', 'id');
	}
	
	public function beatplan_data1()
	{
		return $this->hasOne('App\BeatPlanData', 'beatplan_id', 'id');
	}

	public function client()
	{
		return $this->belongsTo('App\Vendor', 'client_id');
	}

	public function site()
	{
		return $this->belongsTo('App\Sitemaster', 'site_id');
	}

	public function trip()
	{
		return $this->hasMany('App\Trips', 'id', 'beatplan_id');
	}

	public function trip_data()
	{
		return $this->belongsTo('App\TripData', 'id', 'beatplan_id');
	}

	public function verified_load()
	{
		return $this->belongsTo('App\Verifiedloads', 'id', 'beatplan_id');
	}

	public function check_loaded(){

		//return dd($this->verified_load);
		if(!$this->verified_load && $this->trip){
			return true;
		}else{
			return false;
		}

	}

	public function is_loaded(){
		return $this->trip_data;
	}

	public function is_trip(){
		// return dd($this->trip);
		return $this->trip;
	}
	
	public function loaded_count(){
		return $tripData = TripData::where(['beatplan_id'=>$this->id, 'status'=>'loaded'])->count();
	}
	
	public function filled_count(){
		return $tripData = TripData::where(['beatplan_id'=>$this->id, 'status'=>'filled'])->count();
	}
	
	public function uniqueTrip($planId='', $siteId='')
	{
        $tripData = TripData::where(['beatplan_id'=>$planId, 'data_id'=>$siteId])->first();
        $Trips = Trips::find($tripData->trip_id);
		return $Trips['trip_id'];
	}
	
	public function single_trip_data($planId='', $siteId='')
	{
        $tripData = TripData::where(['beatplan_id'=>$planId, 'data_id'=>$siteId])->first();
        //$Trips = Trips::find($tripData->trip_id);
		return $tripData;
	}
}
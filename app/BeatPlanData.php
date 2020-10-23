<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeatPlanData extends Model
{
	protected $table = 'beatplan_data';
	protected $fillable = [
		'beatplan_id',
		'site_id',
		'quantity',
	];

	public function beatplan()
	{
		return $this->belongsTo('App\Beatplan','beatplan_id');
	}

	public function site()
	{
		return $this->hasOne('App\Sitemaster', 'id', 'site_id');
	}
	
	public function divert_data($type)
	{
		if($type == 'from'){
			$trip = Divert::select('site_master.site_name','diverts.*')->where('from_tripdata_id',$this->trip_data()->divert_from_tripdata_id)->join('site_master', function($q){
				$q->on('site_master.id','=','diverts.from_site_id');
			})->first();
			return $trip;			
		}else{
			$trip = Divert::select('site_master.site_name','diverts.*')->where('to_tripdata_id',$this->trip_data()->divert_to_tripdata_id)->join('site_master', function($q){
				$q->on('site_master.id','=','diverts.to_site_id');
			})->first();
			return $trip;	
		}
	}

	public function trip()
	{
		return $this->hasOne('App\Trips', 'id', 'beatplan_id');
	}
	
	public function trip_data()
	{
		return TripData::where(['beatplan_id'=>$this->beatplan_id,'data_id'=>$this->site_id])->first();
	}
	
	public function site_data($type)
	{
		if($type == 'from'){
			$trip = TripData::find($this->trip_data()->divert_from_tripdata_id);
			if($trip){
				return Sitemaster::where(['id'=>$trip->data_id])->first();			
			}
		}else{
			$trip = TripData::find($this->trip_data()->divert_to_tripdata_id);
			if($trip){
				return Sitemaster::where(['id'=>$trip->data_id])->first();	
			}
		}
		return false;
	}

	public function check_divert($id){
		return $trip = TripData::find($id);
	}
	
	public function check_status()
	{
		return $this->status == 'allocated' || $this->status == 'diverted';
	}
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripData extends Model
{
	protected $table = 'trip_data';
	protected $fillable = [
		'id',
		'data_id',
		'beatplan_id',
		'type',
	];


	public function site()
	{
		return $this->hasOne('App\Sitemaster','id','data_id');
	}

	public function trip()
	{
		return $this->hasOne('App\Trips','id','trip_id');
	}
	
	public function verified_load()
	{
		return Verifiedloads::where(['trip_data_id' => $this->id, 'beatplan_id' => $this->beatplan_id, 'beatplan_id' => $this->beatplan_id])->first();
		return $this->hasOne('App\Verifiedloads','trip_data_id','id');
	}

	public function is_assigned()
	{
		return TripData::where(['trip_data_id' => $this->id, 'beatplan_id' => $this->beatplan_id])->first();
	}

	public function quantity()
	{
		return BeatPlanData::where(['site_id' => $this->data_id, 'beatplan_id' => $this->beatplan_id])->first();
	}

	public function beat_plan_data(){
		return BeatPlanData::where(['site_id' => $this->data_id, 'beatplan_id' => $this->beatplan_id])->first();
		//dd($data);
	}
	
	public function site_data($site_id){
		return Sitemaster::where(['id' => $site_id])->first();
	}

	public function plan()
	{
		return $this->hasOne('App\Beatplan','id','beatplan_id');
	}
}

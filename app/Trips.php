<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Beatplan;

class Trips extends Model
{
	// protected $with = ['trip_qty_sum'];
    public function site()
	{
		return $this->belongsTo('App\Sitemaster','sites');
	}
	
	public function beat_plan()
	{
		return $this->belongsTo('App\Beatplan','beatplan_id');
	}

	public function trip_data()
	{
		return $this->hasMany('App\TripData','trip_id')->where('type', 'site');
	}
	
	public function trip_qty_sum()
	{
		return $this->hasMany('App\TripData','trip_id')->where('type', 'site')->join('beatplan_data', function($q){
				$q->on('beatplan_data.beatplan_id','=','trip_data.beatplan_id');
				$q->on('beatplan_data.site_id','=','trip_data.data_id');
			});
	}

	public function driver()
	{
		return $this->hasOne('App\User','id','driver_id');
	}

	public function filler()
	{
		return $this->hasOne('App\User','id', 'filler_id');
	}

	public function vechile()
	{
		return $this->hasOne('App\Vehiclemaster','id', 'vehicle_id');
	}
	
	public function officer()
	{
		return $this->hasOne('App\User','id', 'field_officer_id');
	}
	
	public function route()
	{
		return $this->hasOne('App\Routes','id', 'route_id');
	}

	public function getQuantity($effectiveDate,$siteId)
	{
		return Beatplan::join('beatplan_data','beatplan_data.beatplan_id', 'beatplans.id')->where(['effective_date'=>$effectiveDate, 'beatplan_data.site_id'=>$siteId])->select('beatplan_data.quantity')->first();
	}
	
	public function beat_plan_data()
	{
		return TripData::leftjoin('beatplan_data', function($q){
				$q->on('beatplan_data.beatplan_id','=','trip_data.beatplan_id');
				$q->on('beatplan_data.site_id','=','trip_data.data_id');
			})->where(['trip_data.trip_id' => $this->id])
			->selectRaw('sum(beatplan_data.quantity) as qty,count(beatplan_data.id) as sites_count')->get('qty','sites_count');
	}
	
	public function vendor()
	{
		return $this->hasOne('App\Vendor','id','loading_point_id');
	}

	public function isloaded(){
		return TripData::where(['trip_id' => $this->id, 'status' => 'loaded'])->first();
	}
}
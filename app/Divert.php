<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divert extends Model
{
	protected $table = 'diverts';

	protected $fillable = [
		'from_site_id',
		'to_site_id',
		'qty',
		'verified_id',
	];

	public function beatplan_data()
	{
		return $this->hasMany('App\BeatPlanData', 'beatplan_id', 'id');
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
		return $this->belongsTo('App\Trips', 'id', 'beatplan_id');
	}

	public function verified_load()
	{
		return $this->belongsTo('App\Verifiedloads', 'id', 'beatplan_id');
	}

	public function check_loaded(){

		if( $this->trip && !$this->verified_load ){
			return true;
		}else{
			return false;
		}

	}
}
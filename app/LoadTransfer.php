<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoadTransfer extends Model
{
	protected $table = 'load_transfers';
	protected $fillable = [
		'verified_id',
		'beatplan_id',
		'site_id',
		'trip_id',
		'trip_data_id',
		'driver_id',
		'filler_id',
		'vehicle_id',
	];

	public function beatplan()
	{
		return $this->hasOne('App\Beatplan','beatplan_id');
	}
	public function site()
	{
		return $this->hasOne('App\Sitemaster','site_id');
	}

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Trips;

class Verifiedloads extends Model
{
    protected $table = 'verified_loads';
    protected $fillable = ['beatplan_id','trip_id','auto_trip_id','trip_data_id'];

    public function site()
	{
		return $this->belongsTo('App\Sitemaster','sites');
	}
    public function trip()
    {
        return $this->belongsTo('App\Trips','auto_trip_id');
    }
	public function trip_data()
    {
        return $this->belongsTo('App\TripData','trip_data_id');
    }
    public function beatplan()
    {
        return $this->belongsTo('App\Beatplan','beatplan_id');
    }
    public function collection()
    {
        return $this->hasOne('App\Collection','verified_load_id');
    }

}

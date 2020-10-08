<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeatPlans extends Model
{
	protected $table = 'beat_plans';
    protected $fillable = [
        'alloted_user_id','site_id', 'plan_date', 'site_name', 'site_type', 'maintenance_point', 'beat_plan_ltr', 'technician_name', 'technician_mobile', 'route_plan', 'ro_name','vehicle_no','latitude','longitude','driver_name','driver_mobile','filler_name','filler_mobile','handbook_img'
    ];

}

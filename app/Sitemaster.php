<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitemaster extends Model
{
	protected $table = 'site_master';
	
	protected $fillable = [
		'site_id',
		'unique_site_id' ,
		'site_name',
		'cluster_jc' ,
		'district' ,
		'mp_zone',
		'site_address' ,
		'latitude' ,
		'longitude' ,
		'site_type' ,
		'bts' ,
		'site_category',
		'battery_bank_ah' ,
		'cph' ,
		'indoor_bts' ,
		'outdoor_bts' ,
		'dg1_make' ,
		'dg2_make' ,
		'dg1_rating_in_kva' ,
		'dg2_rating_in_kva' ,
		'eb_status' ,
		'eb_type' ,
		'eb_load_kw' ,
		'technician_id' ,
		'technician_name' ,
		'technician_contact2' ,
		'technician_contact1' ,
		'cluster_incharge_name' ,
		'cluster_incharge_contact1',
		'cluster_incharge_contact2',
		'cluster_incharge_email',
		'zom_name' ,
		'zom_contact' ,
		'zom_email' ,
		'energy_man_name' ,
		'energy_man_contact' ,
		'energy_man_email' ,
		'circle_facility_head_name' ,
		'circle_facility_head_contact' ,
		'circle_facility_head_email',
		'client_name' ,
		'created_by_id' ,
		'client_id'  
	];
	public function client()
	{
		return $this->belongsTo('App\Vendor','client_id','id');
	}
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
    
    protected $fillable = [
		'user_id',
		'vendor_code',
		'type',
		'name',
		'billing_address',
		'state',
		'gst_no',
		'created_by_id',
		'latitute',
		'longitude',
		'vendor_category'
	];

	public function user()
	{
		return $this->belongsTo('App\User','user_id');
	}
	public function states()
	{
		return $this->hasOne('App\States', 'id', 'state');
	}
}

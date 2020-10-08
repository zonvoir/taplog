<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Misallottedzones extends Model
{
    protected $table = 'mis_allotted_zones';

   public function client()
    {
        return $this->belongsTo('App\Vendor','allotted_client_id');
    }
}

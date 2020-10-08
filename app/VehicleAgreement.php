<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleAgreement extends Model
{
    protected $table = 'vehicle_agreement';

    protected $fillable = ['vehicle_id', 'average', 'rental', 'salary_by'];
}

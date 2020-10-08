<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Verifiedloads;

class FillerLiveMaps extends Model
{
    protected $table = 'filler_live_map';
    protected $fillable = ['verified_loads_id','user_id','latitude','longitude','accuracy','timestamp'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    protected $table = 'children';
    protected $fillable = ['user_id','child_name','child_age'];
    
}

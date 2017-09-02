<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
    	'first_name',
    	'last_name',
    	'age',
    	'sex',
    	'active',
    	'bio',
    	'instagram',
    	'spotify',
    	'school_id',
    	'work_id',
    	'locality_id',
    	'city_id',
    	'state_id',
    	'country_id',
    ];
}

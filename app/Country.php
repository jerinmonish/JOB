<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table 	= 'country';
    protected $guarded 	= [];
    protected $fillable = ['country_name','short_name','phone_code','country_status','created_at','updated_at'];
}

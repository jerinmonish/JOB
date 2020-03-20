<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table 	= 'state';
    protected $guarded 	= [];
    protected $fillable = ['country_id','state_name','state_name','created_at','updated_at'];
}

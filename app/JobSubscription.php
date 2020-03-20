<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSubscription extends Model
{
    protected $table 	= 'job_subscribe';
    protected $guarded 	= [];
    protected $fillable = ['employee_id', 'employer_id', 'status','created_at','updated_at'];
}

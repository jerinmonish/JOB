<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobView extends Model
{
    protected $table 	= 'job_views';
    protected $guarded 	= [];
    protected $fillable = ['viewer_id', 'viewer_ip','job_id','created_at','updated_at'];
}

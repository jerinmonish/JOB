<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTags extends Model
{
    protected $table 	= 'job_tag';
    protected $guarded 	= [];
    protected $fillable = ['tag_name', 'user_status','created_at','updated_at'];
}

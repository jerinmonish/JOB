<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Job;

class JobApplied extends Model
{
    protected $table 	= 'job_applied';
    protected $guarded 	= [];
    protected $fillable = ['job_id', 'employee_id', 'job_posted_id', 'status','created_at','updated_at'];

    public function belongsUser()
    {
        return $this->belongsTo('App\User','job_posted_id');
    }

    public function belongsJob()
    {
        return $this->belongsTo('App\Job','job_id');
    }
}

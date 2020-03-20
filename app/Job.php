<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Job extends Model
{
    protected $table 	= 'job';
    protected $guarded 	= [];
    protected $fillable = ['req_id', 'job_title', 'organisation_name', 'job_type','min_exp','max_exp','req_qualification','req_travel','min_sal','max_sal','freshers','description','no_of_pos','req_email','phone_no','jd_desc','joining_time','job_keywords','location','location_start','location_end','status','created_at','updated_at'];


    public function manyJobs()
    {
        return $this->hasMany('App\User','req_id');
    }
}

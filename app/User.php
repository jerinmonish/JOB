<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Job;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password', 'organisation_name', 'profile_pic', 'dob', 'mobile_no', 'resume_doc', 'specialised_in', 'schoolmark', 'collegemark', 'highest_qualification', 'year_passed_out', 'percentage', 'yoe', 'cur_sal', 'exp_sal', 'state', 'country', 'address', 'job_type', 'role', 'user_status', 'last_logged_in',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function format(){
        return [
                'user_id'=>$this->id,
                'first_name'=>$this->first_name,
                'last_name'=>$this->last_name,
                'user_email'=>$this->email,
                'role'=>$this->role,
                'organisation_name'=>$this->organisation_name,
                'profile_pic'=>$this->profile_pic,
                'dob'=>$this->dob,
                'mobile_no'=>$this->mobile_no,
                'resume_doc'=>$this->resume_doc,
                'specialised_in'=>$this->specialised_in,
                'schoolmark'=>$this->schoolmark,
                'collegemark'=>$this->collegemark,
                'highest_qualification'=>$this->highest_qualification,
                'year_passed_out'=>$this->year_passed_out,
                'percentage'=>$this->percentage,
                'yoe'=>$this->yoe,
                'cur_sal'=>$this->cur_sal,
                'exp_sal'=>$this->exp_sal,
                'state'=>$this->state,
                'country'=>$this->country,
                'address'=>$this->address,
                'job_type'=>$this->job_type,
                'user_status'=>$this->user_status,
                'last_logged_in'=>$this->last_logged_in,
                'created_at'=>$this->created_at,
                'last_updated'=>$this->updated_at->diffForHumans(),
            ];
    }

    public function getFullNameAttribute()       
    {        
        return ucfirst($this->first_name) . " " . $this->last_name;       
    }

    /**
     * One - Many relationship Demo
     * Get the employees data for the jobs posted.
     */
    public function employerPostedJob()
    {
        return $this->hasMany('App\Job','req_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table 	= 'subject';
    protected $guarded 	= [];
    protected $fillable = ['subject_id', 'subject','created_at','updated_at'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table 	= 'notifications';
    protected $guarded 	= [];
    protected $fillable = ['from_id', 'to_id','id_redirect','subject','notification_type','read_status','read_at','created_at','updated_at'];
}

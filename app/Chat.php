<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table 	= 'messages';
    protected $guarded 	= [];
    protected $fillable = ['message_id', 'subject_id', 'msgdata', 'from_id','to_id','from_status','to_status','status','seen','created_at','updated_at'];
}

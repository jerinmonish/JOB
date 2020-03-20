<?php

namespace App\Repositories;
use App\User;
use Auth;

class UserRepository
{
	public function all(){
		return User::orderBy('first_name')
    					->where('user_status','Active')
    					->get()
    					->map->format();
    					/*->map(function($user){
    						return $user->format($user);
    					});*/
	}

	public function onlyActiveUser(){
		return User::orderBy('id','desc')
    					->where('user_status','Active')
    					->where('role','!=','admin')
    					->where('id','!=',@Auth::user()->id)
    					->get();
    					/*->map(function($user){
    						return $user->format($user);
    					});*/
	}

    public function onlyActiveEmployee(){
        return User::orderBy('id','desc')
                        ->where('user_status','Active')
                        ->where('role','employee')
                        ->get();
    }

	public function findById($c_id){
		return User::where('id',$c_id)
					->where('user_status','Active')
					->firstOrFail()
					->format();
	}
}

?>
<?php

namespace App\Http\Controllers;
use App\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
	private $userrep;

	public function __construct(UserRepository $userrep){
		$this->userrep = $userrep;
	}

    public function index(){
    	$customers = $this->userrep->all();
    	return $customers;
    }

    public function show($user_id){
    	$customer = $this->userrep->findById($user_id);
    	return $customer;
    }
}

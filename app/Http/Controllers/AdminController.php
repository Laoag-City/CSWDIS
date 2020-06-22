<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function userDashboard()
    {
    	return view('user_dashboard', [
    		'title' => 'User Dashboard',
    		'users' => User::all()
    	]);
    }

    public function newUser()
    {
    	
    }

    public function editUser()
    {
    	
    }

    public function removeUser()
    {
    	
    }

    public function serviceDashboard()
    {
    	
    }

    public function newService()
    {
    	
    }

    public function editService()
    {
    	
    }

    public function removeService()
    {
    	
    }
}

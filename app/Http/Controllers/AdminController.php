<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Service;
use App\Category;
use App\ConfidentialViewer;

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
        $validator = Validator::make($this->request->all(), [
            'name' => 'bail|required|string|name|max:100',
            'username' => 'bail|required|string|alpha_dash|max:30|unique:users,username',
            'password' => 'bail|required|string|min:5|confirmed',
            'is_admin' => 'bail|required|boolean'
        ])->validate();

        $user = new User;
        $user->name = $this->request->name;
        $user->username = $this->request->username;
        $user->password = bcrypt($this->request->password);
        $user->is_admin = $this->request->is_admin;
        $user->save();

        return back()->with('success', "Added a new user.");
    }

    public function editUser(User $user)
    {
    	if($this->request->isMethod('get'))
        {
            return view('edit_user', [
                'title' => 'Edit User',
                'user' => $user
            ]);
        }

        elseif($this->request->isMethod('put'))
        {
            $validator = Validator::make($this->request->all(), [
                'name' => 'bail|required|string|name|max:100',
                'username' => 'bail|required|string|alpha_dash|max:30|unique:users,username,' . $user->user_id . ',user_id',
                'password' => 'bail|nullable|string|min:5|confirmed',
                'is_admin' => 'bail|required|boolean'
            ])->validate();

            $user = new User;
            $user->name = $this->request->name;
            $user->username = $this->request->username;
            $user->password = $this->request->password ? bcrypt($this->request->password) : $user->password;

            if($user->is_admin && !$this->request->is_admin)
                ConfidentialViewer::where('user_id', '=', $user->user_id)->delete();

            $user->is_admin = $this->request->is_admin;
            $user->save();

            return back()->with('success', "User info updated.");
        }

        return response()->json([], 403);
    }

    public function removeUser(User $user)
    {
    	$user->delete();
        return back();
    }

    public function serviceDashboard()
    {
    	return view('service_dashboard', [
            'title' => 'Service Dashboard',
            'services' => Service::with(['category'])->get(),
            'categories' => Category::all()
        ]);
    }

    public function newService()
    {
        $category_rule = 'bail|required';

        if(gettype($this->request->new_category) == 'boolean')
        {
            if($this->request->new_category)
                $category_rule .= '|string|max:255';

            else
                $category_rule .= '|exists:categories,category_id';
        }

    	$validator = Validator::make($this->request->all(), [
            'service' => 'bail|required|string|max:255|unique:services,service',
            'category'  => $category_rule,
            'new_category' => 'bail|required|boolean',
            'is_confidential' => 'bail|required|boolean'
        ])->validate();

        if($this->request->new_category)
        {
            $category = new Category;
            $category->category = $this->request->category;
            $category->save();
        }

        else
            $category = Category::find($this->request->category);

        $service = new Service;
        $service->category = $category->category_id;
        $service->service = $this->request->service;
        $service->is_confidential = $this->request->is_confidential;
        $service->save();

        return back()->with('success', "Added a new service.");
    }

    public function editService(Service $service)
    {
    	if($this->request->isMethod('get'))
        {
            return view('edit_service', [
                'title' => 'Edit Service',
                'user' => 
            ]);
        }

        elseif($this->request->isMethod('put'))
        {
            $category_rule = 'bail|required';

            if(gettype($this->request->new_category) == 'boolean')
            {
                if($this->request->new_category)
                    $category_rule .= '|string|max:255';

                else
                    $category_rule .= '|exists:categories,category_id';
            }

            $validator = Validator::make($this->request->all(), [
                'service' => 'bail|required|string|max:255|unique:services,service,' . $service->service_id . ',service_id',
                'category'  => $category_rule,
                'new_category' => 'bail|required|boolean',
                'is_confidential' => 'bail|required|boolean'
            ])->validate();

            if($this->request->new_category)
            {
                $category = new Category;
                $category->category = $this->request->category;
                $category->save();
            }

            else
                $category = Category::find($this->request->category);

            $service->category = $category->category_id;
            $service->service = $this->request->service;
            $service->is_confidential = $this->request->is_confidential;
            $service->save();

            return back()->with('success', "Service info updated.");
        }

        return response()->json([], 403);
    }

    public function removeService(Service $service)
    {
    	$service->delete();
        return back();
    }

    public function removeCategory(Category $category)
    {
        $category->delete();
        return back();
    }
}

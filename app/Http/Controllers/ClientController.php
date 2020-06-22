<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Service;
use App\Record;
use App\ConfidentialViewer;
use App\User;
use App\ClientRecordHistory;

class ClientController extends Controller
{
	public function addNewRecord()
	{
		if(Auth::user()->is_admin)
		{
			$services = Service::all();
			$admins = User::where([
						['is_admin', '=', true],
						['user_id', '!=', Auth::user()->user_id]
					])->get();
		}

		else
		{
			$services = Service::where('is_confidential', '=', false)->get();
			$admins = collect();
		}

		if($this->request->isMethod('get'))
		{
			return view('add_new_record', [
				'title' => 'Add New Record',
				'service' => $services,
				'admins' => $admins
			]);
		}

		else if($this->request->isMethod('post'))
		{
			$validator = Validator::make($this->request->all(), [
				'client_id' => 'bail|nullable|exists:clients,client_id',
				'name' => 'bail|required|string|name|max:100',
				'phone_no' => 'bail|required|string|max:40',
				'address' => 'bail|required|string:max:255',
				'sex' => 'bail|required|in:M,F',
				'age' => 'bail|required|integer|min:1|max:110',
				'date_of_birth' => 'bail|required|date|before:now',

				'service' => 'bail|required|in:' . implode(',', $services->pluck('service_id')->toArray()),
				'users' => 'bail|sometimes|array',
				'users.*' => 'bail|sometimes|distinct|in:' . implode(',', $admins->pluck('admin_id')->toArray()),

				'date_requested' => 'bail|required|date|before_or_equal:now',
				'problem_presented' => 'bail|required|string|max:255',
				'initial_assessment' => 'bail|nullable|string|max:255',
				'recommendation' => 'bail|nullable|string|max:255',
				'action_taken' => 'bail|nullable|string|max:255',
				'action_taken_date' => 'bail|nullable|date|before_or_equal:now'
			]);

			$validator->validate();

			$service = Service::find($this->request->service);

			if($this->request->client_id != null)
				$client = Client::find($this->request->client_id);
			else
				$client = new Client;

			$client->name = $this->request->name;
			$client->phone_no = $this->request->phone_no;
			$client->address = $this->request->address;
			$client->sex = $this->request->sex;
			$client->age = $this->request->age;
			$client->date_of_birth = $this->request->date_of_birth;
			$client->save();

			$record = new Record;
			$record->client_id = $client->client_id;
			$record->service_id = $this->request->service;
			$record->date_requested = $this->request->date_requested;
			$record->problem_presented = $this->request->problem_presented;
			$record->initial_assessment = $this->request->initial_assessment;
			$record->recommendation = $this->request->recommendation;
			$record->action_taken = $this->request->action_taken;
			$record->action_taken_date = $this->request->action_taken_date;
			$record->save();

			if($service->is_confidential)
			{
				$confidential_viewer = new ConfidentialViewer;
				$confidential_viewer->record_id = $record->record_id;
				$confidential_viewer->user_id = Auth::user()->user_id;
				$confidential_viewer->save();

				foreach($this->request->users as $user_id)
				{
					$confidential_viewer = new ConfidentialViewer;
					$confidential_viewer->record_id = $record->record_id;
					$confidential_viewer->user_id = $user_id;
					$confidential_viewer->save();
				}
			}

			$client_record_history = new ClientRecordHistory;
			$client_record_history->client_id = $client->client_id;
			$client_record_history->record_id = $record->record_id;
			$client_record_history->user_id = Auth::user()->user_id;
			$client_record_history->action = 'Added new record';
			$client_record_history->save();

			return back()->with('success', "A new record has been added successfully.");
		}

		return response()->json([], 403);
	}

	public function searchClients($search = null)
	{
		return Client::where('name', 'like', $search ? "%$search%" : "%{$this->request->name}%")->get();
	}

	public function clientList()
	{
		$search = null;

		if($this->request->client)
			$search = $this->searchClients($this->request->client);

		return view('client_list', [
			'title' => 'Client List',
			'clients' => Client::latest()->paginate(100),
			'search' => $search
		]);
	}

	public function clientInfo(Client $client)
	{
		if(Auth::user()->is_admin)
		{
			$confidential_views_of_others = ConfidentialViewer::where('user_id', '!=', Auth::user()->user_id)
													->get()
													->pluck('record_id')
													->toArray();

			$records = Record::whereNotIn('record_id', $confidential_views_of_others)->get();
		}

		else
		{
			$non_confidential_services = Service::where('is_confidential', '=', false)
											->get()
											->pluck('service_id')
											->toArray();

			$records = Record::whereIn('service_id', $non_confidential_services)->get();
		}

		return view('client_info', [
				'title' => 'Client Info',
				'client' => $client,
				'records' => $records,
			]);
	}

	public function editClient(Client $client)
	{
		if($this->request->isMethod('get'))
		{
			return view('edit_client', [
				'title' => 'Edit Client Info',
				'client' => $client
			]);
		}

		elseif($this->request->isMethod('put'))
		{
			$validator = Validator::make($this->request->all(), [
				'name' => 'bail|required|string|name|max:100',
				'phone_no' => 'bail|required|string|max:40',
				'address' => 'bail|required|string:max:255',
				'sex' => 'bail|required|in:M,F',
				'age' => 'bail|required|integer|min:1|max:110',
				'date_of_birth' => 'bail|required|date|before:now',
			]);

			$validator->validate();

			$client->name = $this->request->name;
			$client->phone_no = $this->request->phone_no;
			$client->address = $this->request->address;
			$client->sex = $this->request->sex;
			$client->age = $this->request->age;
			$client->date_of_birth = $this->request->date_of_birth;
			$client->save();

			$client_record_history = new ClientRecordHistory;
			$client_record_history->client_id = $client->client_id;
			$client_record_history->user_id = Auth::user()->user_id;
			$client_record_history->action = 'Updated client info';
			$client_record_history->save();

			return back()->with('success', "Client's info are updated successfully.");
		}

		return response()->json([], 403);
	}

	public function removeClient(Client $client)
	{
		$client_record_history = new ClientRecordHistory;
		$client_record_history->user_id = Auth::user()->user_id;
		$client_record_history->action = "Removed client {$client->name}";
		$client_record_history->save();

		$client->delete();

		return redirect()->route('client_list');
	}
}

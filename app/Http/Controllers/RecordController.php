<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\ConfidentialViewer;
use App\ClientRecordHistory;
use App\Record;
use App\Service;
use App\User;

class RecordController extends Controller
{
    public function editRecord(Record $record)
    {
    	if(Auth::user()->is_admin)
		{
			$services = Service::with(['category'])->get()->groupBy(function($item, $key){
				return $item->category->category;
			});
			$admins = User::where([
						['is_admin', '=', true],
						['user_id', '!=', Auth::user()->user_id]
					])->get();

			$confidential_viewers = ConfidentialViewer::where([
				['record_id', '=', $record->record_id],
				['user_id', '!=', Auth::user()->user_id]
			])->get()->pluck('user_id');
		}

		else
		{
			$services = Service::where('is_confidential', '=', false)->with(['category'])->get()->groupBy(function($item, $key){
				return $item->category->category;
			});
			$admins = collect();

			$confidential_viewers = [];
		}

    	if($this->request->isMethod('get'))
    	{
    		return view('edit_record', [
				'title' => 'Edit Record Info',
				'record' => $record,
				'confidential_viewers' => $confidential_viewers,
				'services' => $services,
				'admins' => $admins
			]);
    	}

    	elseif($this->request->isMethod('put'))
    	{
    		$validator = Validator::make($this->request->all(), [
				'service' => 'bail|required|in:' . implode(',', $services->flatten()->pluck('service_id')->toArray()),
				'users' => 'bail|sometimes|array',
				'users.*' => 'bail|sometimes|distinct|in:' . implode(',', $admins->pluck('user_id')->toArray()),

				'date_requested' => 'bail|required|date|before_or_equal:now',
				'problem_presented' => 'bail|required|string|max:255',
				'initial_assessment' => 'bail|nullable|string|max:255',
				'recommendation' => 'bail|nullable|string|max:255',
				'action_taken' => 'bail|nullable|string|max:255',
				'action_taken_date' => 'bail|nullable|date|before_or_equal:now'
			]);

			$validator->validate();

			$service = Service::find($this->request->service);

			$record->service_id = $this->request->service;
			$record->date_requested = $this->request->date_requested;
			$record->problem_presented = $this->request->problem_presented;
			$record->initial_assessment = $this->request->initial_assessment;
			$record->recommendation = $this->request->recommendation;
			$record->action_taken = $this->request->action_taken;
			$record->action_taken_date = $this->request->action_taken_date;
			$record->save();

			ConfidentialViewer::where('record_id', $record->record_id)->delete();

			if($service->is_confidential)
			{
				$confidential_viewer = new ConfidentialViewer;
				$confidential_viewer->record_id = $record->record_id;
				$confidential_viewer->user_id = Auth::user()->user_id;
				$confidential_viewer->save();

				if($this->request->users)
					foreach($this->request->users as $user_id)
					{
						$confidential_viewer = new ConfidentialViewer;
						$confidential_viewer->record_id = $record->record_id;
						$confidential_viewer->user_id = $user_id;
						$confidential_viewer->save();
					}
			}

			$client_record_history = new ClientRecordHistory;
			$client_record_history->client_id = $record->client->client_id;
			$client_record_history->record_id = $record->record_id;
			$client_record_history->user_id = Auth::user()->user_id;
			$client_record_history->action = 'Updated record info';
			$client_record_history->save();

			return back()->with('success', "Record has been updated successfully.");
    	}

    	return response()->json([], 403);
    }

    public function removeRecord(Record $record)
	{
		$client_record_history = new ClientRecordHistory;
		$client_record_history->user_id = Auth::user()->user_id;
		$client_record_history->action = "Removed client {$record->client->name}'s record of {$record->service->name}";
		$client_record_history->save();

		$client_id = $record->client->client_id;

		$record->delete();
		return redirect()->route('client', ['client' => $client_id]);
	}
}

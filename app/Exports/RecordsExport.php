<?php

namespace App\Exports;

use App\Record;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class RecordsExport implements FromQuery
{
	use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Record::query()
        		->select([
        			'clients.name', 'clients.phone_no', 'clients.address', 'clients.sex', 'clients.date_of_birth',
        			'records.date_requested', 'records.problem_presented', 'records.initial_assessment', 'records.recommendation', 'records.action_taken', 
        			'records.action_taken_date', 'services.service', 'services.is_confidential'
        	])->join('clients', 'records.client_id', '=', 'clients.client_id')
        		->leftJoin('services', 'records.service_id', '=', 'services.service_id');
    }
}

<?php

namespace App\Exports;

use App\Record;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RecordsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
	use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Record::query()
        		->select([
        			'clients.name', 'clients.phone_no', 'clients.sex', 'clients.date_of_birth',
        			'records.date_requested', 'records.problem_presented', 'records.initial_assessment', 'records.recommendation', 'records.action_taken', 
        			'records.action_taken_date', 'services.service', 'services.is_confidential'
        	])->addSelect('barangays.name as barangay')
                ->join('clients', 'records.client_id', '=', 'clients.client_id')
        		->leftJoin('services', 'records.service_id', '=', 'services.service_id')
                ->leftJoin('barangays', 'clients.barangay_id', '=', 'barangays.barangay_id');
    }

    public function map($record): array
    {
        return [
            $record->name, $record->phone_no, $record->barangay . ', Laoag City', $record->sex, date('F d, Y', strtotime($record->date_of_birth)), date('F d, Y', strtotime($record->date_requested)), 
            $record->problem_presented, $record->initial_assessment, $record->recommendation, $record->action_taken, date('F d, Y', strtotime($record->action_taken_date)), 
            $record->service,  $this->getBooleanValue($record->is_confidential)
        ];
    }

    public function headings(): array
    {
        return ['NAME', 'PHONE NUMBER', 'ADDRESS', 'SEX', 'DATE OF BIRTH', 'DATE REQUESTED', 'PROBLEM PRESENTED', 'INITIAL ASSESSMENT', 'RECOMMENDATION', 'ACTION TAKEN', 'ACTION TAKEN DATE', 'SERVICE',
                'CONFIDENTIAL'
            ];
    }

    private function getBooleanValue($val)
    {
        if($val === 1)
            return 'Yes';
        elseif($val === 0)
            return 'No';
        else
            return '';
    }
}

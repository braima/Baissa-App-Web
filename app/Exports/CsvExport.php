<?php

namespace App\Exports;

use App\Courses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class CsvExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('reservations')->get();
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Location',
            'Destination',
            'Passengers',
            'Prix',
            'Date',
            'Time',
            'Nom',
            'Prenom',
            'Pays',
            'Telephone',
            'Email',
            'Comment',
            'Payement',
            'TypeTrip',
        ];
    }
}

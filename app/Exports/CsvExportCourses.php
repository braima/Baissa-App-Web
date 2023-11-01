<?php

namespace App\Exports;

use App\Courses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CsvExportCourses implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Courses::all();
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Chauffeur',
            'Status',
            'ID Reservation',
        ];
    }
}

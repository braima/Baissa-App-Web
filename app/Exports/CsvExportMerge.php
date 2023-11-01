<?php

namespace App\Exports;

use App\Courses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class CsvExportMerge implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $reservations = DB::table('reservations AS a')
        ->join('courses_chauffeur AS c', 'a.ID', '=', 'c.id_course')
        ->select('a.ID', 'a.Location', 'a.Destination', 'a.Passengers', 'a.price', 'a.Date', 'a.time', 'a.First_Name', 'a.Family_Name', 'a.Countr', 'a.Phone', 'a.Email', 'a.Comments', 'a.paymethode', 'c.id_chauffeur', 'c.statutCourses')
        ->get();
        return $reservations;
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
            'Chauffeur',
            'Status',
        ];
    }
}

<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class CsvExportUser implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'role_id',
            'Nom',
            'Username',
            'Email',
            'Mot de pass',
            'Date Naissance',
            'Telephone',
            'Nationalite',
            'Immatriculation',
            'Marque V',
            'Model V',
            'Permis',
            'VtcCard',
            'Description',
            'Image',
        ];
    }
}

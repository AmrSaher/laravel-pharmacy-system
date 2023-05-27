<?php

namespace App\Exports;

use App\Models\Pharmacy;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PharmaciesExport implements FromArray, WithHeadings
{
    protected $pharmacies;

    public function __construct(array $pharmacies)
    {
        $this->pharmacies = $pharmacies;
    }

    public function array() : array
    {
        return $this->pharmacies;
    }

    public function headings() : array
    {
        return [
            'ID',
            'Name',
            'Priority',
            'Owner',
            'Governorate',
            'Created at',
            'Updated at'
        ];
    }
}
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromArray, WithHeadings
{
    protected $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function array() : array
    {
        return $this->users;
    }

    public function headings() : array
    {
        return [
            'ID',
            'Name',
            'Email',
            'National ID',
            'Gender',
            'Date of birth',
            'Mobile number',
            'Created at'
        ];
    }
}
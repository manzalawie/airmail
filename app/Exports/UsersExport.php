<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UsersExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users->map(function ($user) {
            return [
                'ID' => $user->id,
                'National Id' => $user->national_id,
                'Name' => $user->name,
                'Arabic Name' => $user->name_ar,
                'Phone' => $user->phone,
                'Username' => $user->username,
                'Email' => $user->email,
                'Role' => $user->getRoleNames()->first(),
                'Status' => $user->deleted_at ? 'Inactive' : 'Active',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'National Id',
            'Name',
            'Arabic Name',
            'Phone',
            'Username',
            'Email',
            'Role',
            'Status',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER, // National Id column (B is the 2nd column)
        ];
    }
}
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AdminOverviewExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        return [
            'Users' => new UsersExport(),
            'Enrollments' => new EnrollmentsExport(),
            'Keuzedelen' => new KeuzedelenExport(),
            'Keuzedeel Details' => new KeuzedelDetailsExport(),
            'Waitlists' => new WaitlistsExport(),
        ];
    }
}

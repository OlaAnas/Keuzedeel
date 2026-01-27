<?php

namespace App\Exports;

use App\Models\Enrollment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class EnrollmentsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function title(): string
    {
        return 'Inschrijvingen';
    }

    public function collection()
    {
        return Enrollment::with(['user', 'keuzedeel', 'period'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Student Name',
            'Email',
            'Keuzedeel',
            'Period',
            'Status',
            'Enrolled At',
        ];
    }

    public function map($enrollment): array
    {
        return [
            $enrollment->id,
            $enrollment->user->name,
            $enrollment->user->email,
            $enrollment->keuzedeel->name,
            $enrollment->period->name,
            $enrollment->status,
            $enrollment->created_at,
        ];
    }
}

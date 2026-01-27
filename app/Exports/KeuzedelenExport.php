<?php

namespace App\Exports;

use App\Models\Keuzedeel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class KeuzedelenExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function title(): string
    {
        return 'Keuzedelen Overzicht';
    }

    public function collection()
    {
        return Keuzedeel::with(['study', 'teacher', 'period', 'enrollments'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Code',
            'Name',
            'Study',
            'Teacher',
            'Period',
            'Min Students',
            'Max Students',
            'Current Enrollments',
            'Available Spots',
            'Active',
            'Repeatable',
            'Created At',
        ];
    }

    public function map($keuzedeel): array
    {
        $enrollmentCount = $keuzedeel->enrollments()->where('status', 'active')->count();
        $availableSpots = $keuzedeel->max_students - $enrollmentCount;
        
        return [
            $keuzedeel->id,
            $keuzedeel->code,
            $keuzedeel->name,
            $keuzedeel->study->name,
            $keuzedeel->teacher->name,
            $keuzedeel->period->name,
            $keuzedeel->min_students,
            $keuzedeel->max_students,
            $enrollmentCount,
            max(0, $availableSpots),
            $keuzedeel->active ? 'Yes' : 'No',
            $keuzedeel->repeatable ? 'Yes' : 'No',
            $keuzedeel->created_at,
        ];
    }
}

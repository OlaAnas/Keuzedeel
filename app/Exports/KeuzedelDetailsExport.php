<?php

namespace App\Exports;

use App\Models\Keuzedeel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class KeuzedelDetailsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function title(): string
    {
        return 'Studenten per Keuzedeel';
    }

    public function collection()
    {
        $enrollments = \App\Models\Enrollment::with(['keuzedeel', 'user', 'period'])
            ->where('status', 'active')
            ->orderBy('keuzedeel_id')
            ->get();
        
        return $enrollments;
    }

    public function headings(): array
    {
        return [
            'Keuzedeel Code',
            'Keuzedeel Name',
            'Period',
            'Student Name',
            'Student Email',
            'Student Number',
            'Study',
            'Class',
            'Enrolled At',
        ];
    }

    public function map($enrollment): array
    {
        return [
            $enrollment->keuzedeel->code,
            $enrollment->keuzedeel->name,
            $enrollment->period->name,
            $enrollment->user->name,
            $enrollment->user->email,
            $enrollment->user->student_number,
            $enrollment->user->study_id ? $enrollment->user->study?->name : '',
            $enrollment->user->class_name,
            $enrollment->created_at,
        ];
    }
}

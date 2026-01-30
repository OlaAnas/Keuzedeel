<?php

namespace App\Exports;

use App\Models\Waitlist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class WaitlistsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function title(): string
    {
        return 'Wachtlijsten';
    }

    public function collection()
    {
        return Waitlist::with(['user', 'keuzedeel', 'period'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Student Name',
            'Email',
            'Keuzedeel',
            'Period',
            'Preference Order',
            'Status',
            'Approved At',
            'Added At',
        ];
    }

    public function map($waitlist): array
    {
        return [
            $waitlist->id,
            $waitlist->user->name,
            $waitlist->user->email,
            $waitlist->keuzedeel->name,
            $waitlist->period->name,
            $waitlist->preference_order,
            $waitlist->status,
            $waitlist->approved_at,
            $waitlist->created_at,
        ];
    }
}

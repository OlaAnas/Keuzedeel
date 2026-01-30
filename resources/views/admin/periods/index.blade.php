@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <h1 style="margin: 0 0 2rem 0; font-size: 2rem; color: #333;">Inschrijvingsperiodes</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Periods Table -->
    @if($periods->count() > 0)
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Periode</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Start Datum</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">End Datum</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Status</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periods as $period)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem; font-weight: 500;">{{ $period->name }}</td>
                            <td style="padding: 1rem;">{{ $period->start_date->format('d-m-Y') }}</td>
                            <td style="padding: 1rem;">{{ $period->end_date->format('d-m-Y') }}</td>
                            <td style="padding: 1rem; text-align: center;">
                                @if($period->enrollment_open)
                                    <span style="background: #d4edda; color: #155724; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">
                                        Geopend
                                    </span>
                                @else
                                    <span style="background: #f8d7da; color: #721c24; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">
                                        Gesloten
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                                    <a href="{{ route('periods.edit', $period->id) }}" style="background: #1976d2; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">
                                        Bewerk
                                    </a>
                                    <form method="POST" action="{{ route('periods.toggle-enrollment', $period->id) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="background: {{ $period->enrollment_open ? '#dc3545' : '#4caf50' }}; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem;">
                                            {{ $period->enrollment_open ? 'Sluit Inschrijving' : 'Open Inschrijving' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $periods->links() }}
        </div>
    @else
        <div style="background: #f5f5f5; padding: 2rem; text-align: center; border-radius: 8px; color: #999;">
            <p style="margin: 0; font-size: 1rem;">Geen inschrijvingsperiodes gevonden</p>
        </div>
    @endif
</div>
@endsection

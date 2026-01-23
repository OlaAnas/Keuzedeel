@extends('layouts.app')

@section('title', 'Inschrijvingen overzicht')

@section('content')
<div class="container">
    <div class="content">
        <h2>Inschrijvingen overzicht</h2>
        
        <!-- Filters -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <form method="GET" action="{{ route('admin.enrollments') }}" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Keuzedeel</label>
                    <select name="keuzedeel_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">-- Alle keuzedelen --</option>
                        @foreach($keuzedelen as $keuzedeel)
                            <option value="{{ $keuzedeel->id }}" {{ request('keuzedeel_id') == $keuzedeel->id ? 'selected' : '' }}>
                                {{ $keuzedeel->code }} - {{ $keuzedeel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Periode</label>
                    <select name="period_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">-- Alle periodes --</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ request('period_id') == $period->id ? 'selected' : '' }}>
                                {{ $period->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status</label>
                    <select name="status" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">-- Alle statussen --</option>
                        <option value="enrolled" {{ request('status') == 'enrolled' ? 'selected' : '' }}>Ingeschreven</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                    </select>
                </div>

                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" style="background: #1976d2; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: #e3f2fd; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #1976d2;">
                <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Totaal inschrijvingen</div>
                <div style="font-size: 2rem; font-weight: 700; color: #1976d2;">{{ $totalEnrollments }}</div>
            </div>
            <div style="background: #f3e5f5; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #9c27b0;">
                <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Actieve inschrijvingen</div>
                <div style="font-size: 2rem; font-weight: 700; color: #9c27b0;">{{ $activeEnrollments }}</div>
            </div>
            <div style="background: #fce4ec; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #e91e63;">
                <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Geannuleerde inschrijvingen</div>
                <div style="font-size: 2rem; font-weight: 700; color: #e91e63;">{{ $cancelledEnrollments }}</div>
            </div>
        </div>

        <!-- Enrollments Table -->
        @if($enrollments->count() > 0)
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Student</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Keuzedeel</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Periode</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Status</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Inschrijfdatum</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                            <tr style="border-bottom: 1px solid #eee; hover: background: #f9f9f9;">
                                <td style="padding: 1rem;">
                                    <strong>{{ $enrollment->user->first_name }} {{ $enrollment->user->last_name }}</strong><br>
                                    <span style="color: #999; font-size: 0.9rem;">{{ $enrollment->user->email }}</span>
                                </td>
                                <td style="padding: 1rem;">
                                    <strong>{{ $enrollment->keuzedeel->code }}</strong><br>
                                    <span style="color: #999; font-size: 0.9rem;">{{ $enrollment->keuzedeel->name }}</span>
                                </td>
                                <td style="padding: 1rem;">
                                    {{ $enrollment->period->name }}<br>
                                    <span style="color: #999; font-size: 0.9rem;">{{ $enrollment->period->start_date->format('d-m-Y') }} - {{ $enrollment->period->end_date->format('d-m-Y') }}</span>
                                </td>
                                <td style="padding: 1rem;">
                                    @if($enrollment->status === 'enrolled')
                                        <span style="background: #d4edda; color: #155724; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">
                                            Ingeschreven
                                        </span>
                                    @elseif($enrollment->status === 'cancelled')
                                        <span style="background: #f8d7da; color: #721c24; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">
                                            Geannuleerd
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 1rem;">
                                    {{ $enrollment->created_at->format('d-m-Y H:i') }}
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                                        @if($enrollment->status === 'enrolled')
                                            <form method="POST" action="{{ route('admin.enrollments.cancel', $enrollment->id) }}" style="display: inline;" onsubmit="return confirm('Weet je zeker dat je deze inschrijving wilt annuleren?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" style="background: #dc3545; color: white; padding: 0.4rem 0.8rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">
                                                    Annuleren
                                                </button>
                                            </form>
                                        @elseif($enrollment->status === 'cancelled')
                                            <form method="POST" action="{{ route('admin.enrollments.restore', $enrollment->id) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" style="background: #4caf50; color: white; padding: 0.4rem 0.8rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">
                                                    Herstellen
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2rem;">
                {{ $enrollments->links() }}
            </div>
        @else
            <div style="background: white; padding: 3rem; border-radius: 8px; text-align: center; color: #999;">
                <p style="font-size: 1.1rem;">Geen inschrijvingen gevonden</p>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.dashboard') }}" style="color: #1976d2; text-decoration: none; font-size: 2rem; cursor: pointer;">←</a>
        <h1 style="margin: 0; font-size: 2rem; color: #333;">Wachtlijst Beheren</h1>
    </div>

    <!-- Period Info -->
    @if($openPeriod)
        <div style="background: #e3f2fd; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #1976d2;">
            <p style="margin: 0; color: #1976d2; font-weight: 600;">
                📅 Actieve Periode: <strong>{{ $openPeriod->name }}</strong>
            </p>
        </div>
    @else
        <div style="background: #fff3cd; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #ffc107;">
            <p style="margin: 0; color: #856404;">
                ⚠️ Geen actieve inschrijvingsperiode
            </p>
        </div>
    @endif

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #dc3545;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Waitlist Table -->
    @if($waitlistEntries->count() > 0)
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Student</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Student Nr.</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Keuzedeel</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Status</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Wachtlijst Sinds</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($waitlistEntries as $entry)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem;">{{ $entry->user->first_name }} {{ $entry->user->last_name }}</td>
                            <td style="padding: 1rem;">{{ $entry->user->student_number }}</td>
                            <td style="padding: 1rem;">{{ $entry->keuzedeel->name }}</td>
                            <td style="padding: 1rem;">
                                <span style="background: #fff3cd; color: #856404; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                    Wachtend
                                </span>
                            </td>
                            <td style="padding: 1rem;">{{ $entry->created_at->format('d-m-Y H:i') }}</td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <form method="POST" action="{{ route('admin.waitlists.approve', $entry->id) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="background: #4caf50; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem;" onclick="return confirm('Goedkeuren?')">
                                            Goedkeuren
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.waitlists.reject', $entry->id) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="background: #dc3545; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem;" onclick="return confirm('Afwijzen?')">
                                            Afwijzen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center; color: #666;">
            <p style="margin: 0;">✓ Geen studenten op de wachtlijst</p>
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <h1 style="margin: 0 0 2rem 0; font-size: 2rem; color: #333;">Mijn Inschrijving</h1>

    <!-- Error/Info Messages -->
    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #dc3545;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    @if(!$openPeriod)
        <div style="background: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #ffc107;">
            <strong>ℹ️ Opmerking:</strong> Er is momenteel geen actieve inschrijvingsperiode.
        </div>
    @endif

    <!-- Current Enrollment -->
    @if($enrollment)
        <div style="background: white; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <h2 style="margin: 0 0 1rem 0; color: #333;">Huidige Inschrijving - {{ $openPeriod->name }}</h2>

            <div style="border: 2px solid #4caf50; border-radius: 8px; padding: 1.5rem; background: #f1f8f4; margin-bottom: 1.5rem;">
                <div style="margin-bottom: 1rem;">
                    <strong style="color: #333; font-size: 1.2rem;">{{ $enrollment->keuzedeel->name }}</strong>
                    <div style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">
                        Code: {{ $enrollment->keuzedeel->code }}
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <div style="color: #666;">
                        <strong>Docent:</strong> {{ $enrollment->keuzedeel->teacher->first_name }} {{ $enrollment->keuzedeel->teacher->last_name }}
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <div style="color: #666;">
                        <strong>Beschrijving:</strong> {{ $enrollment->keuzedeel->description }}
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    @if($enrollment->status !== 'cancelled')
                        <form method="POST" action="{{ route('student.unenroll', $enrollment->id) }}" onsubmit="return confirm('Weet je zeker dat je je wilt uitschrijven?');" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #dc3545; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                Uitschrijven
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @else
        @if($openPeriod)
            <div style="background: #e3f2fd; border: 2px dashed #1976d2; border-radius: 8px; padding: 2rem; text-align: center;">
                <p style="margin: 0 0 1rem 0; color: #333; font-size: 1.1rem;">Je bent nog niet ingeschreven.</p>
                <a href="{{ route('student.keuzedelen') }}" style="background: #1976d2; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: 600; display: inline-block;">
                    Bekijk beschikbare keuzedeelen
                </a>
            </div>
        @else
            <div style="background: #f5f5f5; border-radius: 8px; padding: 2rem; text-align: center; color: #999;">
                <p style="margin: 0; font-size: 1rem;">Geen actieve inschrijvingsperiode</p>
            </div>
        @endif
    @endif
</div>
@endsection

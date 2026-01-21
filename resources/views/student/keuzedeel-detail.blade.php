@extends('layouts.app')

@section('title', $keuzedeel->name)

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 2rem;">
    <!-- Messages -->
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

    <!-- Back Link -->
    <a href="{{ route('student.keuzedelen') }}" style="color: #1976d2; text-decoration: none; margin-bottom: 1rem; display: inline-block;">← Terug naar keuzedeelen</a>

    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem;">
        <div>
            <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; color: #333;">{{ $keuzedeel->name }}</h1>
            <div style="color: #666;">Code: {{ $keuzedeel->code }}</div>
        </div>
        @if($keuzedeel->active)
            <span style="background: #d4edda; color: #155724; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 500;">
                Actief
            </span>
        @else
            <span style="background: #f8d7da; color: #721c24; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 500;">
                Inactief
            </span>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Main Content -->
        <div>
            <!-- Teacher & Study Info -->
            <div style="background: white; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 1rem 0; color: #333;">Informatie</h3>
                
                @if($keuzedeel->teacher)
                    <div style="margin-bottom: 1rem;">
                        <p style="color: #999; font-size: 0.9rem; margin: 0; margin-bottom: 0.3rem;">Docent</p>
                        <p style="margin: 0; font-size: 1rem; font-weight: 500;">{{ $keuzedeel->teacher->first_name }} {{ $keuzedeel->teacher->last_name }}</p>
                    </div>
                @endif

                @if($keuzedeel->study)
                    <div style="margin-bottom: 1rem;">
                        <p style="color: #999; font-size: 0.9rem; margin: 0; margin-bottom: 0.3rem;">Studierichting</p>
                        <p style="margin: 0; font-size: 1rem; font-weight: 500;">{{ $keuzedeel->study->name }}</p>
                    </div>
                @endif

                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.9rem; margin: 0; margin-bottom: 0.3rem;">Capaciteit</p>
                    <p style="margin: 0; font-size: 1rem; font-weight: 500;">Min: {{ $keuzedeel->min_students }} / Max: {{ $keuzedeel->max_students }}</p>
                </div>

                <div>
                    <p style="color: #999; font-size: 0.9rem; margin: 0; margin-bottom: 0.3rem;">Herhaalbaar</p>
                    <p style="margin: 0; font-size: 1rem; font-weight: 500;">{{ $keuzedeel->repeatable ? 'Ja' : 'Nee' }}</p>
                </div>
            </div>

            <!-- Description -->
            @if($keuzedeel->description)
                <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 1rem 0; color: #333;">Beschrijving</h3>
                    <p style="line-height: 1.8; color: #555;">{{ $keuzedeel->description }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar: Enrollment Status & Action -->
        <div>
            @php
                $openPeriod = \App\Models\Period::where('enrollment_open', true)->first();
                $studentEnrollment = $openPeriod ? \App\Models\Enrollment::where('user_id', auth()->id())
                    ->where('period_id', $openPeriod->id)
                    ->where('status', '!=', 'cancelled')
                    ->first() : null;
                $enrolledCount = $openPeriod ? \App\Models\Enrollment::where('keuzedeel_id', $keuzedeel->id)
                    ->where('period_id', $openPeriod->id)
                    ->where('status', '!=', 'cancelled')
                    ->count() : 0;
                $isFull = $enrolledCount >= 30;
                $isEnrolled = $studentEnrollment && $studentEnrollment->keuzedeel_id == $keuzedeel->id;
            @endphp

            <!-- Enrollment Card -->
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                @if($openPeriod)
                    <h3 style="margin: 0 0 1rem 0; color: #333;">Inschrijving</h3>

                    <!-- Capacity Info -->
                    <div style="background: #f5f5f5; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; text-align: center;">
                        <div style="font-size: 2rem; font-weight: bold; color: #1976d2;">
                            {{ 30 - $enrolledCount }}
                        </div>
                        <div style="color: #666; font-size: 0.9rem;">
                            Plekken vrij ({{ $enrolledCount }}/30)
                        </div>
                    </div>

                    <!-- Status Messages -->
                    @if($isEnrolled)
                        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; text-align: center; font-weight: 500;">
                            ✓ Je bent ingeschreven
                        </div>
                        <a href="{{ route('student.my-enrollments') }}" style="display: block; background: #1976d2; color: white; padding: 0.75rem; border-radius: 4px; text-decoration: none; text-align: center; font-weight: 600;">
                            Bekijk mijn inschrijving
                        </a>
                    @elseif($studentEnrollment)
                        <div style="background: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; text-align: center; font-size: 0.9rem;">
                            Je bent al ingeschreven voor een ander keuzedeel in deze periode.
                        </div>
                        <a href="{{ route('student.my-enrollments') }}" style="display: block; background: #1976d2; color: white; padding: 0.75rem; border-radius: 4px; text-decoration: none; text-align: center; font-weight: 600;">
                            Mijn inschrijving
                        </a>
                    @elseif($isFull)
                        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; text-align: center; font-weight: 500;">
                            ✗ Keuzedeel is vol
                        </div>
                        <button disabled style="display: block; width: 100%; background: #ccc; color: white; padding: 0.75rem; border: none; border-radius: 4px; cursor: not-allowed; font-weight: 600;">
                            Niet beschikbaar
                        </button>
                    @else
                        <form method="POST" action="{{ route('student.enroll', $keuzedeel->id) }}">
                            @csrf
                            <button type="submit" style="display: block; width: 100%; background: #4caf50; color: white; padding: 0.75rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 1rem;">
                                Inschrijven
                            </button>
                        </form>
                    @endif
                @else
                    <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; text-align: center;">
                        <strong>Inschrijving gesloten</strong>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Er is momenteel geen actieve inschrijvingsperiode.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

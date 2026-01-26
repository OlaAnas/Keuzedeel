@extends('layouts.app')

@section('content')
<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; flex-direction: column; overflow: hidden;">
    <!-- Presentation Mode Header -->
    <div style="background: rgba(0, 0, 0, 0.3); padding: 1rem; color: white; text-align: center; flex-shrink: 0;">
        <h1 style="margin: 0; font-size: 1.5rem;">Keuzedeel Presentatie {{ $study ? '- ' . $study->name : '' }}</h1>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.8;">Slide {{ $slideIndex + 1 }} van {{ count($keuzedelen) }}</p>
    </div>

    <!-- Presentation Content -->
    <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem; overflow: hidden;">
        @if(count($keuzedelen) > 0)
            @php
                $currentKeuzedeel = $keuzedelen[$slideIndex] ?? null;
            @endphp

            @if($currentKeuzedeel)
                <div style="background: white; border-radius: 12px; padding: 3rem; max-width: 900px; width: 100%; height: 100%; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3); overflow-y: auto;">
                    <!-- Study Name -->
                    <div style="color: #667eea; font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 1px;">
                        {{ $currentKeuzedeel->study->name }}
                    </div>

                    <!-- Course Code -->
                    <div style="color: #999; font-size: 1rem; margin-bottom: 1.5rem;">
                        Code: {{ $currentKeuzedeel->code }}
                    </div>

                    <!-- Course Name (Large) -->
                    <h1 style="font-size: 3.5rem; color: #333; margin: 0 0 1rem 0; line-height: 1.2;">
                        {{ $currentKeuzedeel->name }}
                    </h1>

                    <!-- Teacher Name -->
                    <div style="font-size: 1.2rem; color: #764ba2; margin-bottom: 2rem; font-weight: 500;">
                        Docent: {{ $currentKeuzedeel->teacher->first_name }} {{ $currentKeuzedeel->teacher->last_name }}
                    </div>

                    <!-- Description -->
                    <div style="font-size: 1.3rem; line-height: 1.8; color: #555; margin-bottom: 2rem; border-left: 4px solid #667eea; padding-left: 1.5rem;">
                        {{ $currentKeuzedeel->description }}
                    </div>

                    <!-- Course Details -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2.5rem; padding-top: 2rem; border-top: 2px solid #eee;">
                        <div>
                            <div style="color: #999; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Min. Deelnemers</div>
                            <div style="font-size: 2rem; font-weight: bold; color: #667eea;">{{ $currentKeuzedeel->min_students }}</div>
                        </div>
                        <div>
                            <div style="color: #999; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Max. Deelnemers</div>
                            <div style="font-size: 2rem; font-weight: bold; color: #667eea;">{{ $currentKeuzedeel->max_students }}</div>
                        </div>
                        <div>
                            <div style="color: #999; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Herhaalbaar</div>
                            <div style="font-size: 2rem; font-weight: bold; color: #667eea;">
                                {{ $currentKeuzedeel->repeatable ? 'Ja' : 'Nee' }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div style="background: white; border-radius: 12px; padding: 3rem; text-align: center; color: #666;">
                    <p style="font-size: 1.3rem;">Einde presentatie bereikt</p>
                </div>
            @endif
        @else
            <div style="background: white; border-radius: 12px; padding: 3rem; text-align: center; color: #666;">
                <p style="font-size: 1.3rem;">Geen actieve keuzedeelen beschikbaar</p>
            </div>
        @endif
    </div>

    <!-- Controls Footer -->
    <div style="background: rgba(0, 0, 0, 0.3); padding: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; flex-shrink: 0;">
        <!-- Previous Button -->
        <button onclick="goToPrevious()" style="background: #f44336; color: white; padding: 1rem 2rem; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; font-weight: 600; transition: background 0.3s;">
            ← Vorige
        </button>

        <!-- Reset Button -->
        <button onclick="goToReset()" style="background: #ff9800; color: white; padding: 1rem 2rem; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; font-weight: 600; transition: background 0.3s;">
            ⟲ Stop
        </button>

        <!-- Next Button -->
        <button onclick="goToNext()" style="background: #4caf50; color: white; padding: 1rem 2rem; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; font-weight: 600; transition: background 0.3s;">
            Volgende →
        </button>
    </div>
</div>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        overflow: hidden;
    }

    button:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>

<script>
    const studyId = '{{ $studyId ?? "" }}';
    const currentSlide = {{ $slideIndex }};

    function goToNext() {
        let url = '{{ route("slb.presentation") }}?slide=' + (currentSlide + 1);
        if (studyId) url += '&study_id=' + studyId;
        window.location.href = url;
    }

    function goToPrevious() {
        let url = '{{ route("slb.presentation") }}?slide=' + Math.max(0, currentSlide - 1);
        if (studyId) url += '&study_id=' + studyId;
        window.location.href = url;
    }

    function goToReset() {
        window.location.href = '{{ route("slb.dashboard") }}';
    }

    // Keyboard controls
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') {
            goToNext();
        } else if (e.key === 'ArrowLeft') {
            goToPrevious();
        }
    });
</script>
@endsection

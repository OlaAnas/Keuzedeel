@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div style="background: white; border-radius: 12px; padding: 3rem; max-width: 600px; width: 100%; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="color: #333; margin: 0 0 0.5rem 0; font-size: 2.5rem;">Presentatie Beheer</h1>
            <p style="color: #999; margin: 0; font-size: 1rem;">Kies een studierichting om de keuzedeelen te presenteren</p>
        </div>

        <!-- Study Selection -->
        <div style="margin-bottom: 2rem;">
            <label style="display: block; color: #333; font-weight: 600; margin-bottom: 1rem; font-size: 1.1rem;">Selecteer studierichting:</label>
            
            @if($studies->count() > 0)
                <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                    @foreach($studies as $study)
                        <a href="{{ route('slb.presentation', ['study_id' => $study->id]) }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer; border: none;">
                            <div>
                                <div style="font-size: 1.3rem; font-weight: 600;">{{ $study->name }}</div>
                                <div style="font-size: 0.9rem; opacity: 0.9; margin-top: 0.5rem;">
                                    {{ $study->keuzedelen()->where('active', true)->count() }} actieve keuzedeelen
                                </div>
                            </div>
                            <div style="font-size: 2rem;">→</div>
                        </a>
                    @endforeach
                </div>
            @else
                <div style="background: #f5f5f5; padding: 2rem; text-align: center; border-radius: 8px; color: #999;">
                    <p>Geen studierichtingen beschikbaar</p>
                </div>
            @endif
        </div>

        <!-- All Studies Option -->
        <div style="border-top: 2px solid #eee; padding-top: 2rem;">
            <a href="{{ route('slb.presentation') }}" 
               style="display: flex; align-items: center; justify-content: space-between; padding: 1.5rem; background: #ff9800; color: white; border-radius: 8px; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer; border: none; text-align: left;">
                <div>
                    <div style="font-size: 1.3rem; font-weight: 600;">Alle Keuzedeelen</div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-top: 0.5rem;">
                        {{ $totalKeuzedelen }} actieve keuzedeelen
                    </div>
                </div>
                <div style="font-size: 2rem;">→</div>
            </a>
        </div>

        <!-- Info Section -->
        <div style="margin-top: 2rem; padding: 1.5rem; background: #f0f4ff; border-left: 4px solid #667eea; border-radius: 4px;">
            <p style="color: #555; margin: 0; line-height: 1.6; font-size: 0.95rem;">
                💡 <strong>Tip:</strong> Selecteer een studierichting om alleen de keuzedeelen voor die richting te tonen, 
                of kies "Alle Keuzedeelen" om alles te presenteren.
            </p>
        </div>
    </div>
</div>

<style>
    a[style*="display: flex"]:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2) !important;
    }
</style>
@endsection

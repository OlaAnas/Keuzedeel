@extends('layouts.app')

@section('title', 'Keuzedelen')

@section('content')
<div class="container">
    <div class="content">
        <h2>Beschikbare Keuzedelen</h2>
        
        <!-- Filter by Study -->
        <div style="margin-bottom: 2rem; background: #f9f9f9; padding: 1rem; border-radius: 4px;">
            <form method="GET" action="{{ route('student.keuzedelen') }}" style="display: flex; gap: 1rem; align-items: flex-end;">
                <div style="flex: 1;">
                    <label for="study_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Filter by Study:</label>
                    <select id="study_id" name="study_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                        <option value="">-- All Studies --</option>
                        @foreach($studies as $study)
                            <option value="{{ $study->id }}" {{ $selectedStudy == $study->id ? 'selected' : '' }}>
                                {{ $study->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" style="background-color: #1976d2; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
                @if($selectedStudy)
                    <a href="{{ route('student.keuzedelen') }}" style="background-color: #666; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; text-decoration: none; display: inline-block;">Clear</a>
                @endif
            </form>
        </div>

        @if($keuzedelen->count() > 0)
            <div style="display: grid; gap: 1rem;">
                @foreach($keuzedelen as $keuzedeel)
                    <div style="border: 1px solid #ddd; border-radius: 8px; padding: 1.5rem; hover: background-color: #f9f9f9; transition: background-color 0.2s;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                            <h3 style="color: #1976d2; margin: 0;">{{ $keuzedeel->name }}</h3>
                            <span style="background-color: #e3f2fd; color: #1976d2; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">{{ $keuzedeel->code }}</span>
                        </div>
                        
                        @if($keuzedeel->description)
                            <p style="color: #666; margin: 0.75rem 0;">{{ $keuzedeel->description }}</p>
                        @endif

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin: 1rem 0; font-size: 0.9rem;">
                            @if($keuzedeel->teacher)
                                <div>
                                    <span style="color: #999; font-size: 0.85rem;">Teacher</span><br>
                                    <strong>{{ $keuzedeel->teacher->first_name }} {{ $keuzedeel->teacher->last_name }}</strong>
                                </div>
                            @endif
                            @if($keuzedeel->study)
                                <div>
                                    <span style="color: #999; font-size: 0.85rem;">Study</span><br>
                                    <strong>{{ $keuzedeel->study->name }}</strong>
                                </div>
                            @endif
                            <div>
                                <span style="color: #999; font-size: 0.85rem;">Capacity</span><br>
                                <strong>{{ $keuzedeel->min_students }}-{{ $keuzedeel->max_students }}</strong>
                            </div>
                            @if($keuzedeel->repeatable)
                                <div>
                                    <span style="color: #999; font-size: 0.85rem;">Repeatable</span><br>
                                    <strong>✓ Yes</strong>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('student.keuzedeel-detail', $keuzedeel->id) }}" style="background-color: #1976d2; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; text-decoration: none; display: inline-block;">View Details</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>No keuzedelen available</p>
            </div>
        @endif
    </div>
</div>
@endsection

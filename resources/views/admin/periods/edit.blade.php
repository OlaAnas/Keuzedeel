@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <h1 style="margin: 0 0 2rem 0; font-size: 2rem; color: #333;">Periode Bewerken</h1>

    <!-- Form -->
    <form method="POST" action="{{ route('periods.update', $period->id) }}" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Naam <span style="color: #dc3545;">*</span></label>
            <input type="text" name="name" value="{{ old('name', $period->name) }}" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('name') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
            @error('name')
                <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Start Date -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Start Datum <span style="color: #dc3545;">*</span></label>
            <input type="date" name="start_date" value="{{ old('start_date', $period->start_date->format('Y-m-d')) }}" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('start_date') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
            @error('start_date')
                <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
            @enderror
        </div>

        <!-- End Date -->
        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">End Datum <span style="color: #dc3545;">*</span></label>
            <input type="date" name="end_date" value="{{ old('end_date', $period->end_date->format('Y-m-d')) }}" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('end_date') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
            @error('end_date')
                <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="flex: 1; background: #4caf50; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; font-weight: 600;">
                Bijwerken
            </button>
            <a href="{{ route('periods.index') }}" style="flex: 1; background: #999; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; text-align: center; font-size: 1rem; font-weight: 600;">
                Annuleren
            </a>
        </div>
    </form>
</div>
@endsection

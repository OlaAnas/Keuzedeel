@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <h1 style="margin: 0 0 2rem 0; font-size: 2rem; color: #333;">
        {{ isset($teacher) ? 'Docent Bewerken' : 'Docent Toevoegen' }}
    </h1>

    <!-- Form -->
    <form method="POST" action="{{ isset($teacher) ? route('teachers.update', $teacher->id) : route('teachers.store') }}" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        @csrf
        @if(isset($teacher))
            @method('PUT')
        @endif

        <!-- First Name -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Voornaam <span style="color: #dc3545;">*</span></label>
            <input type="text" name="first_name" value="{{ old('first_name', $teacher->first_name ?? '') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('first_name') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
            @error('first_name')
                <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Last Name -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Achternaam <span style="color: #dc3545;">*</span></label>
            <input type="text" name="last_name" value="{{ old('last_name', $teacher->last_name ?? '') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('last_name') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
            @error('last_name')
                <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Email <span style="color: #dc3545;">*</span></label>
            <input type="email" name="email" value="{{ old('email', $teacher->email ?? '') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('email') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
            @error('email')
                <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password (only for create) -->
        @if(!isset($teacher))
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Wachtwoord <span style="color: #dc3545;">*</span></label>
                <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('password') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                @error('password')
                    <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Wachtwoord Bevestigen <span style="color: #dc3545;">*</span></label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('password_confirmation') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                @error('password_confirmation')
                    <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
            </div>
        @endif

        <!-- Buttons -->
        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="flex: 1; background: #4caf50; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; font-weight: 600;">
                {{ isset($teacher) ? 'Bijwerken' : 'Toevoegen' }}
            </button>
            <a href="{{ route('teachers.index') }}" style="flex: 1; background: #999; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; text-align: center; font-size: 1rem; font-weight: 600;">
                Annuleren
            </a>
        </div>
    </form>
</div>
@endsection

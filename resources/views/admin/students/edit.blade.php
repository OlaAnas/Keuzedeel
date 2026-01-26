@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('students.index') }}" style="color: #1976d2; text-decoration: none; font-size: 2rem; cursor: pointer;">←</a>
        <h1 style="margin: 0; font-size: 2rem; color: #333;">Student Bewerken</h1>
    </div>

    <div style="background: white; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('students.update', $student->id) }}">
            @csrf
            @method('PUT')

            <!-- First Name -->
            <div style="margin-bottom: 1.5rem;">
                <label for="first_name" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                    Voornaam *
                </label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                @error('first_name')
                    <div style="color: #dc3545; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Last Name -->
            <div style="margin-bottom: 1.5rem;">
                <label for="last_name" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                    Achternaam *
                </label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                @error('last_name')
                    <div style="color: #dc3545; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Student Number (Read-only) -->
            <div style="margin-bottom: 1.5rem;">
                <label for="student_number" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                    Student Nummer
                </label>
                <input type="text" id="student_number" value="{{ $student->student_number }}" disabled 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box; background-color: #f5f5f5; color: #666;">
            </div>

            <!-- Email (Read-only) -->
            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                    Email
                </label>
                <input type="email" id="email" value="{{ $student->email }}" disabled 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box; background-color: #f5f5f5; color: #666;">
            </div>

            <!-- Study -->
            <div style="margin-bottom: 1.5rem;">
                <label for="study_id" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                    Studie *
                </label>
                <select name="study_id" id="study_id" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                    @foreach($studies as $study)
                        <option value="{{ $study->id }}" {{ old('study_id', $student->study_id) == $study->id ? 'selected' : '' }}>
                            {{ $study->name }}
                        </option>
                    @endforeach
                </select>
                @error('study_id')
                    <div style="color: #dc3545; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Class Name -->
            <div style="margin-bottom: 2rem;">
                <label for="class_name" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                    Klasnaam
                </label>
                <input type="text" name="class_name" id="class_name" value="{{ old('class_name', $student->class_name) }}" 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;">
                @error('class_name')
                    <div style="color: #dc3545; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('students.index') }}" style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: 600; cursor: pointer;">
                    Annuleren
                </a>
                <button type="submit" style="background: #1976d2; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; border: none; font-weight: 600; cursor: pointer; font-size: 1rem;">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

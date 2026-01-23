@extends('layouts.app')

@section('title', 'Create Keuzedeel')

@section('content')
<div class="container">
    <div class="content">
        <h2>Keuzedeel toevoegen</h2>

        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #f5c6cb;">
                <strong>Validation errors:</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('keuzedelen.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label for="code" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Code <span style="color: red;">*</span></label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('code') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem;">
                    @error('code')
                        <span style="color: #dc3545; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Name <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('name') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem;">
                    @error('name')
                        <span style="color: #dc3545; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="description" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Description <span style="color: red;">*</span></label>
                <textarea id="description" name="description" rows="4" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('description') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem; font-family: inherit;">{{ old('description') }}</textarea>
                @error('description')
                    <span style="color: #dc3545; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label for="min_students" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Min Students <span style="color: red;">*</span></label>
                    <input type="number" id="min_students" name="min_students" value="{{ old('min_students', 15) }}" min="1" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('min_students') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem;">
                    @error('min_students')
                        <span style="color: #dc3545; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="max_students" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Max Students <span style="color: red;">*</span></label>
                    <input type="number" id="max_students" name="max_students" value="{{ old('max_students', 30) }}" min="1" required style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('max_students') ? '#dc3545' : '#ddd' }}; border-radius: 4px; font-size: 1rem;">
                    @error('max_students')
                        <span style="color: #dc3545; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label for="teacher_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Teacher (optional)</label>
                    <select id="teacher_id" name="teacher_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="study_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Study (optional)</label>
                    <select id="study_id" name="study_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                        <option value="">-- Select Study --</option>
                        @foreach($studies as $study)
                            <option value="{{ $study->id }}" {{ old('study_id') == $study->id ? 'selected' : '' }}>
                                {{ $study->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="period_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Period (optional)</label>
                    <select id="period_id" name="period_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                        <option value="">-- Select Period --</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>
                                {{ $period->name }} ({{ $period->start_date->format('d-m-Y') }} - {{ $period->end_date->format('d-m-Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 500;">
                    <input type="checkbox" id="repeatable" name="repeatable" value="1" {{ old('repeatable') ? 'checked' : '' }} style="width: auto;">
                    Repeatable
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="background-color: #4caf50; color: white; padding: 0.75rem 2rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; font-size: 1rem;">Opslaan</button>
                <a href="{{ route('keuzedelen.index') }}" style="background-color: #999; color: white; padding: 0.75rem 2rem; border: none; border-radius: 4px; text-decoration: none; font-weight: 500; font-size: 1rem; display: inline-block;">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection

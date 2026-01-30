@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('students.index') }}" style="color: #1976d2; text-decoration: none; font-size: 2rem; cursor: pointer;">←</a>
        <h1 style="margin: 0; font-size: 2rem; color: #333;">Studenten Importeren</h1>
    </div>

    <div style="background: white; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('students.store-import') }}">
            @csrf

            <!-- Study Selection -->
            <div style="margin-bottom: 2rem;">
                <label for="study_id" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                    Selecteer Studie *
                </label>
                <select name="study_id" id="study_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">-- Kies een studie --</option>
                    @foreach($studies as $study)
                        <option value="{{ $study->id }}">{{ $study->name }}</option>
                    @endforeach
                </select>
                @error('study_id')
                    <div style="color: #dc3545; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Student Data Input -->
            <div style="margin-bottom: 2rem;">
                <label for="student_data" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                    Studentgegevens *
                </label>
                <p style="color: #666; font-size: 0.9rem; margin: 0.5rem 0 1rem 0;">
                    Plak hier de studentennummers en namen. Ondersteunde formaten:
                </p>
                <ul style="color: #666; font-size: 0.9rem; margin: 0.5rem 0 1rem 1.5rem; padding-left: 1rem;">
                    <li><code>1234567</code> (alleen nummer)</li>
                    <li><code>1234567 Jan de Vries</code> (nummer en volledige naam)</li>
                    <li><code>1234567 Jan</code> (nummer en voornaam)</li>
                </ul>
                <p style="color: #666; font-size: 0.9rem; margin: 0.5rem 0 1rem 0;">
                    <strong>Een student per regel.</strong> Email wordt automatisch gegenereerd als <code>nummer@student.tcr.nl</code>
                </p>
                <textarea name="student_data" id="student_data" required rows="15" 
                    style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; font-family: monospace; font-size: 0.95rem; resize: vertical;">{{ old('student_data') }}</textarea>
                @error('student_data')
                    <div style="color: #dc3545; font-size: 0.9rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Example -->
            <div style="background: #f5f5f5; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #1976d2;">
                <strong style="display: block; margin-bottom: 0.5rem; color: #333;">Voorbeeld van het invoerformat:</strong>
                <pre style="margin: 0; color: #666; font-size: 0.85rem; white-space: pre-wrap; word-wrap: break-word;">1234567 Alivia Williamson
1234568 Austin Padilla
1234569 Cole Leon
1234570 Dale Govan</pre>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('students.index') }}" style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: 600; cursor: pointer;">
                    Annuleren
                </a>
                <button type="submit" style="background: #4caf50; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; border: none; font-weight: 600; cursor: pointer; font-size: 1rem;">
                    Studenten Importeren
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

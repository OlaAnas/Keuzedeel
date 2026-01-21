@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0; font-size: 2rem; color: #333;">Docenten Beheren</h1>
        <a href="{{ route('teachers.create') }}" style="background: #4caf50; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: 600;">
            + Docent Toevoegen
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Teachers Table -->
    @if($teachers->count() > 0)
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Voornaam</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Achternaam</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Email</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                        <tr style="border-bottom: 1px solid #eee; hover: background #f9f9f9;">
                            <td style="padding: 1rem;">{{ $teacher->first_name }}</td>
                            <td style="padding: 1rem;">{{ $teacher->last_name }}</td>
                            <td style="padding: 1rem;">{{ $teacher->email }}</td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('teachers.edit', $teacher->id) }}" style="background: #1976d2; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">
                                        Bewerk
                                    </a>
                                    <form method="POST" action="{{ route('teachers.destroy', $teacher->id) }}" style="display: inline;" onsubmit="return confirm('Weet je zeker dat je deze docent wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #dc3545; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem;">
                                            Verwijder
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $teachers->links() }}
        </div>
    @else
        <div style="background: #f5f5f5; padding: 2rem; text-align: center; border-radius: 8px; color: #999;">
            <p style="margin: 0; font-size: 1rem;">Geen docenten gevonden</p>
            <a href="{{ route('admin.teachers.create') }}" style="color: #1976d2; text-decoration: none; font-weight: 600;">Voeg hier een docent toe</a>
        </div>
    @endif
</div>
@endsection

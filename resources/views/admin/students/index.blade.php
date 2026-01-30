@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0; font-size: 2rem; color: #333;">Studenten Beheren</h1>
        <a href="{{ route('students.import') }}" style="background: #4caf50; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: 600;">
            + Studenten Importeren
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Errors -->
    @if(session('errors') && is_array(session('errors')) && count(session('errors')) > 0)
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border-left: 4px solid #f5c6cb;">
            <strong>Fouten bij importeren:</strong>
            <ul style="margin: 0.5rem 0 0 1.5rem;">
                @foreach(session('errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Students Table -->
    @if($students->count() > 0)
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;" id="studentsTable">
                <thead>
                    <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Student Nummer</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Voornaam</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Achternaam</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Email</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333;">Studie</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333;">Acties</th>
                    </tr>
                </thead>
                <tbody id="studentsList">
                    @foreach($students as $student)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem;">{{ $student->student_number }}</td>
                            <td style="padding: 1rem;">{{ $student->first_name }}</td>
                            <td style="padding: 1rem;">{{ $student->last_name }}</td>
                            <td style="padding: 1rem;">{{ $student->email }}</td>
                            <td style="padding: 1rem;">{{ $student->study ? $student->study->name : 'N/A' }}</td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('students.edit', $student->id) }}" style="background: #1976d2; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">
                                        Bewerk
                                    </a>
                                    <form method="POST" action="{{ route('students.destroy', $student->id) }}" style="display: inline;" onsubmit="return confirm('Weet je zeker dat je deze student wilt verwijderen?');">
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

        <!-- Load More Button -->
        @if($students->hasMorePages())
            <div style="margin-top: 2rem; text-align: center;">
                <button id="loadMoreBtn" onclick="loadMoreStudents(2)" style="background: #1976d2; color: white; padding: 0.75rem 2rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 1rem;">
                    Laad meer studenten
                </button>
            </div>
        @endif
    @else
        <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center; color: #666;">
            <p style="margin: 0;">Geen studenten gevonden.</p>
        </div>
    @endif
</div>

<script>
let currentPage = 1;

function loadMoreStudents(page) {
    const btn = document.getElementById('loadMoreBtn');
    btn.disabled = true;
    btn.textContent = 'Laden...';

    fetch(`{{ route('students.index') }}?page=${page}&ajax=1`)
        .then(response => response.text())
        .then(html => {
            // Parse the HTML response to extract table rows
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newRows = doc.querySelectorAll('#studentsList tr');
            const tbody = document.getElementById('studentsList');

            // Add new rows to table
            newRows.forEach(row => {
                tbody.appendChild(row.cloneNode(true));
            });

            // Update current page
            currentPage = page;

            // Check if there are more pages
            if (doc.getElementById('loadMoreBtn')) {
                btn.disabled = false;
                btn.textContent = 'Laad meer studenten';
                btn.onclick = () => loadMoreStudents(page + 1);
            } else {
                btn.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.textContent = 'Laad meer studenten';
            alert('Er is een fout opgetreden bij het laden van meer studenten.');
        });
}
</script>
@endsection

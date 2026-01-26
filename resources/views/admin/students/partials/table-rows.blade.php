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

@if($students->hasMorePages())
    <div id="loadMoreBtn" style="display: none;"></div>
@endif

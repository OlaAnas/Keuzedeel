@extends('layouts.app')

@section('title', 'Keuzedelen beheren')

@section('content')
<div class="container">
    <div class="content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="margin: 0;">Keuzedelen beheren</h2>
            <a href="{{ route('keuzedelen.create') }}" style="background-color: #4caf50; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; text-decoration: none; font-weight: 500;">+ Keuzedeel toevoegen</a>
        </div>

        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @if($keuzedelen->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f5f5f5;">
                        <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Code</th>
                        <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Name</th>
                        <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Teacher</th>
                        <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Study</th>
                        <th style="padding: 0.75rem; text-align: center; border-bottom: 2px solid #ddd; font-weight: 600;">Students</th>
                        <th style="padding: 0.75rem; text-align: center; border-bottom: 2px solid #ddd; font-weight: 600;">Status</th>
                        <th style="padding: 0.75rem; text-align: center; border-bottom: 2px solid #ddd; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keuzedelen as $keuzedeel)
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 0.75rem;"><strong>{{ $keuzedeel->code }}</strong></td>
                            <td style="padding: 0.75rem;">{{ $keuzedeel->name }}</td>
                            <td style="padding: 0.75rem;">
                                @if($keuzedeel->teacher)
                                    {{ $keuzedeel->teacher->first_name }} {{ $keuzedeel->teacher->last_name }}
                                @else
                                    <span style="color: #999;">—</span>
                                @endif
                            </td>
                            <td style="padding: 0.75rem;">
                                @if($keuzedeel->study)
                                    {{ $keuzedeel->study->name }}
                                @else
                                    <span style="color: #999;">—</span>
                                @endif
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">{{ $keuzedeel->min_students }}-{{ $keuzedeel->max_students }}</td>
                            <td style="padding: 0.75rem; text-align: center;">
                                @if($keuzedeel->active)
                                    <span style="background-color: #c8e6c9; color: #1b5e20; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">Active</span>
                                @else
                                    <span style="background-color: #ffcccc; color: #c62828; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">Inactive</span>
                                @endif
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                                    <a href="{{ route('keuzedelen.edit', $keuzedeel->id) }}" style="background-color: #1976d2; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">Edit</a>
                                    <form method="POST" action="{{ route('admin.keuzedelen.toggle-active', $keuzedeel->id) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="background-color: {{ $keuzedeel->active ? '#ff9800' : '#4caf50' }}; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem;">
                                            {{ $keuzedeel->active ? 'Zet uit' : 'Zet aan' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('keuzedelen.destroy', $keuzedeel->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this keuzedeel?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background-color: #dc3545; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 2rem;">
                {{ $keuzedelen->links() }}
            </div>
        @else
            <div class="empty-state">
                <p>No keuzedelen configured yet</p>
                <a href="{{ route('keuzedelen.create') }}" style="background-color: #4caf50; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; text-decoration: none; font-weight: 500; display: inline-block; margin-top: 1rem;">+ Create First Keuzedeel</a>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <div class="content">
        <h2>Admin Dashboard</h2>
        <p>Welcome terug, Admin!</p>

        <div style="margin-top: 2rem;">
            <h3 style="color: #1976d2; margin-bottom: 1rem;">Quick Actions</h3>
            <style>
                .emoji { display: inline-block; width: 1.6rem; text-align: center; vertical-align: middle; margin: 0 0 0.4rem 0; font-size: 1.2rem; }
                .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
                .card-link { padding: 1.5rem; background: #e3f2fd; border-radius: 8px; text-decoration: none; color: #1976d2; font-weight: 500; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.25rem; text-align: center; }
                .card-warning { padding: 1.5rem; background: #fff3cd; border-radius: 8px; text-decoration: none; color: #856404; font-weight: 500; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.25rem; text-align: center; }
            </style>
            <div class="grid">
                <a href="{{ route('students.index') }}" class="card-link">
                    <span class="emoji">👥</span>
                    <span>Studenten beheren</span>
                </a>
                <a href="{{ route('teachers.index') }}" class="card-link">
                    <span class="emoji">🎓</span>
                    <span>Docenten beheren</span>
                </a>
                <a href="{{ route('keuzedelen.index') }}" class="card-link">
                    <span class="emoji">📚</span>
                    <span>Keuzedelen beheren</span>
                </a>
                <a href="{{ route('periods.index') }}" class="card-link">
                    <span class="emoji">📅</span>
                    <span>Periodes</span>
                </a>
                <a href="{{ route('admin.enrollments') }}" class="card-link">
                    <span class="emoji">📝</span>
                    <span>Inschrijvingen</span>
                </a>
                <a href="{{ route('admin.waitlists') }}" class="card-warning">
                    <span class="emoji">⏳</span>
                    <span>Wachtlijst</span>
                </a>
                <a href="/admin/export/users" class="card-warning">
                    <span class="emoji">📊</span>
                    <span>Download Overview</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

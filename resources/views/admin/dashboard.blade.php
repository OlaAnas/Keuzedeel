@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <div class="content">
        <h2>Admin Dashboard</h2>
        <p>Welcome back, Admin!</p>
        
        <div style="margin-top: 2rem;">
            <h3 style="color: #1976d2; margin-bottom: 1rem;">Quick Actions</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="{{ route('students.index') }}" style="padding: 1.5rem; background: #e3f2fd; border-radius: 8px; text-decoration: none; color: #1976d2; text-align: center; font-weight: 500;">
                    👥 Studenten beheren
                </a>
                <a href="{{ route('teachers.index') }}" style="padding: 1.5rem; background: #e3f2fd; border-radius: 8px; text-decoration: none; color: #1976d2; text-align: center; font-weight: 500;">
                    🎓 Docenten beheren
                </a>
                <a href="{{ route('keuzedelen.index') }}" style="padding: 1.5rem; background: #e3f2fd; border-radius: 8px; text-decoration: none; color: #1976d2; text-align: center; font-weight: 500;">
                    📚 Keuzedelen beheren
                </a>
                <a href="{{ route('periods.index') }}" style="padding: 1.5rem; background: #e3f2fd; border-radius: 8px; text-decoration: none; color: #1976d2; text-align: center; font-weight: 500;">
                    📅 Periodes
                </a>
                <a href="{{ route('admin.enrollments') }}" style="padding: 1.5rem; background: #e3f2fd; border-radius: 8px; text-decoration: none; color: #1976d2; text-align: center; font-weight: 500;">
                    📝 Inschrijvingen
                </a>
                <a href="{{ route('admin.waitlists') }}" style="padding: 1.5rem; background: #fff3cd; border-radius: 8px; text-decoration: none; color: #856404; text-align: center; font-weight: 500;">
                    ⏳ Wachtlijst
                </a>
                <a href="/admin/export/users" style="padding: 1.5rem; background: #fff3cd; border-radius: 8px; text-decoration: none; color: #856404; text-align: center; font-weight: 500;">
                    📊 Download Overview
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

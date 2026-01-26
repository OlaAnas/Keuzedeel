<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Keuzedeel') - Keuzedeel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .navbar {
            background-color: #1976d2;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 0.95rem;
        }
        .nav-links a:hover {
            opacity: 0.8;
        }
        .logout-btn {
            background-color: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 0.95rem;
        }
        .logout-btn:hover {
            background-color: rgba(255,255,255,0.3);
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 1rem;
            color: #1976d2;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        button[type="submit"] {
            background-color: #1976d2;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        button[type="submit"]:hover {
            background-color: #1565c0;
        }
        .login-container {
            max-width: 400px;
            margin: 4rem auto;
        }
        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .login-card h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #1976d2;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: 600;
        }
        .role-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .role-admin {
            background-color: #c8e6c9;
            color: #1b5e20;
        }
        .role-student {
            background-color: #bbdefb;
            color: #0d47a1;
        }
        .role-slb {
            background-color: #ffe0b2;
            color: #e65100;
        }
        .role-teacher {
            background-color: #f0f4c3;
            color: #33691e;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #999;
        }
    </style>
</head>
<body>
    @if(auth()->check())
    <nav class="navbar">
        <div class="navbar-container">
            <h1>Keuzedeel</h1>
            <div class="nav-links">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('keuzedelen.index') }}">Keuzedelen beheren</a>
                    <a href="{{ route('teachers.index') }}">Docenten beheren</a>
                    <a href="{{ route('periods.index') }}">Periodes</a>
                    <a href="{{ route('admin.enrollments') }}">Inschrijvingen overzicht</a>
                @elseif(auth()->user()->role === 'student')
                    <a href="{{ route('student.keuzedelen') }}">Keuzedelen</a>
                    <a href="{{ route('student.my-enrollments') }}">Mijn inschrijving</a>
                @elseif(auth()->user()->role === 'slb')
                    <a href="{{ route('slb.dashboard') }}">Presentatiemodus</a>
                @elseif(auth()->user()->role === 'teacher')
                    <a href="{{ route('teacher.dashboard') }}">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    @endif

    @yield('content')
</body>
</html>

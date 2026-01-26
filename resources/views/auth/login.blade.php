@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="login-container">
    <div class="login-card">
        <h1>Keuzedeel Login</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #ddd;">
            <p style="font-size: 0.85rem; color: #666; text-align: center;">
                <strong>Demo Accounts:</strong><br>
                Admin: admin@example.com<br>
                Student: student@example.com<br>
                Teacher: teacher@example.com<br>
                Password: password
            </p>
        </div>
    </div>
</div>
@endsection

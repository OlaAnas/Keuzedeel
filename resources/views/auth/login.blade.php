@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="max-width: 500px; margin: 3rem auto;">
    <div class="card" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: none;">
        <div class="card-body" style="padding: 2rem;">
            <h2 style="margin-bottom: 2rem; text-align: center; color: #1976d2;">Login</h2>

            @if ($errors->any())
                <div style="background-color: #ffebee; color: #c62828; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                </div>

                <button 
                    type="submit"
                    style="width: 100%; padding: 0.75rem; background-color: #1976d2; color: white; border: none; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer;">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        background-color: white;
        border-radius: 4px;
    }
    
    .card-body {
        padding: 2rem;
    }
</style>
@endsection

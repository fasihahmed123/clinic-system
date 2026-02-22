@extends('layouts.guest')

@section('content')
<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Nunito', sans-serif;
    }

    /* Background image from public/images */
    .bg-image {
        background-image: linear-gradient(
            rgba(0,0,0,0.4),
            rgba(0,0,0,0.4)
        ),
        url('{{ asset("images/hospital-bed.jpg") }}');
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        filter: brightness(0.75);
        position: fixed;
        width: 100%;
        z-index: -1;
    }

    .login-card {
        background-color: rgba(255,255,255,0.9);
        border-radius: 1rem;
        box-shadow: 0 12px 40px rgba(0,0,0,0.3);
        padding: 2rem;
        max-width: 420px;
        width: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 50px rgba(0,0,0,0.4);
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-header h3 {
        font-weight: 700;
        color: #0d6efd;
    }

    .login-header p {
        color: #6c757d;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
</style>

<div class="bg-image"></div>

<div class="login-container">
    <div class="login-card">
        <div class="text-center login-header mb-4">
            <h3>Kahut Clinic</h3>
            <p>Secure Login to Continue</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" required>
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection
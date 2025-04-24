@extends('layouts.app')

@section('title', 'Login page')

@section('content-nonAuthorized')
<div class="login-container">
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2>{{ __('Welcome Back') }}</h2>
                <p>{{ __('Sign in to your account') }}</p>
            </div>

            <div class="login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="Enter your email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password"
                               placeholder="Enter your password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>

                    {{-- <div class="login-footer">
                        <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #3490dc;
        --primary-hover: #2779bd;
        --text-color: #2d3748;
        --light-gray: #f7fafc;
        --border-color: #e2e8f0;
        --error-color: #e3342f;
    }

    .login-container {
        min-height: 100vh;
        background-color: var(--light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-wrapper {
        width: 100%;
        max-width: 420px;
    }

    .login-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .login-header {
        padding: 30px 30px 20px;
        text-align: center;
        background: linear-gradient(135deg, var(--primary-color), #4f6af0);
        color: white;
    }

    .login-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .login-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .login-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text-color);
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--error-color);
    }

    .invalid-feedback {
        color: var(--error-color);
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        margin-left: 20px
    }

    .remember-me input {
        margin-right: 8px;
    }

    .forgot-password {
        color: var(--primary-color);
        text-decoration: none;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .form-submit {
        margin-bottom: 15px;
    }

    .btn-primary {
        width: 100%;
        padding: 12px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
    }

    .login-footer {
        text-align: center;
        font-size: 14px;
        color: #718096;
        margin-top: 20px;
    }

    .login-footer a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }
</style>
@endsection
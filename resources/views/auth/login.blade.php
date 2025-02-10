@extends('layouts.app')

@section('content')
<style>
body {
    background-color: #f4f6f9;
    font-family: 'avenir';
    margin: 0;
    padding: 0;
    height: 100vh;
    overflow: hidden; 
}

.container {
    height: 60vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
}

.card {
    width: 100%;
    max-width: 450px;
    max-height: 90vh;
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    background-color: white;
    overflow: auto;
}

.card-header {
    background-color: #4195be;
    color: white;
    font-size: 1.8rem;
    text-align: center;
    padding: 20px;
    border-radius: 8px 8px 0 0;
}

.card-body {
    padding: 30px;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #4195be;
    padding: 10px;
    font-size: 1rem;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4195be;
    box-shadow: 0 0 10px rgba(25, 115, 230, 0.25);
}

.btn-primary {
    color: white;
    background-color: #4195be;
    border: none;
    padding: 12px;
    font-size: 1.1rem;
    border-radius: 8px;
    width: 100%;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #155bb8;
}

a {
    color: #4195be;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

@media (max-width: 600px) {
    .card {
        width: 100%;
        max-height: 95vh;
    }
}
</style>

<div class="container">

    <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

                <div class="text-center">
                    <small>Don't have an account? <a href="{{ route('register') }}">Register here</a></small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

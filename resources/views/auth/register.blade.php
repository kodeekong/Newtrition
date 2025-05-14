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

.form-label {
    display: inline-block;
    width: 140px;
    margin-right: 10px;
    vertical-align: middle;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #4195be;
    padding: 10px;
    font-size: 1rem;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    width: calc(100% - 150px);
    display: inline-block;
    vertical-align: middle;
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

.text-danger {
    display: block;
    margin-left: 150px;
    margin-top: -15px;
    margin-bottom: 15px;
    color: #dc3545;
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
        <div class="card-header">Register</div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required minlength="3">
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
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
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                
                <div class="text-center">
                    <small>Already have an account?<a href="{{ route('login') }}">Login here</a></small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

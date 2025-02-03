@extends('layouts.app') <!-- Extending the layout -->

@section('content')
<style>/* public/css/style.css */
/* General Styles */
body {
    background-color: #f4f6f9; /* Light gray background */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Elegant font */
    margin: 0;
    padding: 0;
}

/* Container styling to center the form */
.container {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Card Styling */
.card {
    width: 100%;
    max-width: 450px;
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    background-color: white;
}

/* Card Header Styling */
.card-header {
    background-color: #2F6F76; /* Muted gray background */
    color: white;
    font-size: 1.8rem;
    text-align: center;
    padding: 20px;
    border-radius: 8px 8px 0 0; /* Rounded top corners */
}

/* Card Body Styling */
.card-body {
    padding: 30px;
    border-radius: 0 0 8px 8px;
}

/* Form Input Fields */
.form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 10px;
    font-size: 1rem;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
}

/* Label Styling */
.form-label {
    font-weight: 600;
    color: #495057;
}

/* Error messages */
.text-danger {
    font-size: 0.9rem;
    color: #dc3545;
    margin-top: 5px;
}

/* Button Styling */
.btn-primary {
    color: white;
    background-color: #2F6F76; /* Blue theme */
    border-color:rgb(39, 80, 84);
    width: 100%;
    padding: 12px;
    font-size: 1.1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: bold;
}

.btn-primary:hover {
    background-color:rgb(22, 83, 89);
    border-color:rgb(32, 72, 77);
}

/* Button Focus */
.btn-primary:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Center the submit button text */
.mb-3.text-center {
    text-align: center;
}

/* Responsive Design */
@media (max-width: 600px) {
    .card {
        width: 90%;
    }

    .card-header {
        font-size: 1.5rem;
    }

    .btn-primary {
        font-size: 1rem;
    }
}

</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Register</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf <!-- CSRF token for security -->

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
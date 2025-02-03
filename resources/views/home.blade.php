@extends('layouts.app') <!-- Extending the layout you already have -->

@section('content')
    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <h1>Welcome to Newtrition</h1>
            <p>Your ultimate tool for nutrition tracking and goal setting!</p>
            <p>Sign up to track your meals, set goals, and get personalized nutrition insights.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
            </div>
        </div>
    </section>
@endsection

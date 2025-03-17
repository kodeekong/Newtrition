@extends('layouts.app')

@section('content')
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

    <style>
        /* Button Styles */
        .cta-buttons {
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #4195be; /* Turquoise */
            color: white;
        }

        .btn-primary:hover {
            background-color:rgb(139, 197, 227); /* Darker turquoise */
        }

        .btn-secondary {
            background-color: #4195be;
            color: white;
        }

        .btn-secondary:hover {
            background-color: rgb(139, 197, 227);
        }

        /* General Section Styling */
        .welcome-section {
            text-align: center;
            padding: 60px 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }

        .welcome-section h1 {
            color: #4195be; /* Turquoise */
            font-size: 48px;
            margin-bottom: 20px;
        }

        .welcome-section p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
    </style>
@endsection

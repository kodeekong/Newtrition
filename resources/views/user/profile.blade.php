@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #eef3f8;
        margin: 0;
        padding: 0;
    }

    <div class="dashboard">
        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>

    .dashboard {
        width: 90%;
        max-width: 1000px;
        margin: 60px auto;
        padding: 40px;
        background-color: #f8fbff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
        text-align: center;
    }

    .dashboard h1 {
        font-size: 2.2rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .dashboard p {
        color: #555;
        font-size: 1.1rem;
    }

    .profile-info {
        margin-top: 35px;
        background-color: #ffffff;
        padding: 30px 35px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        text-align: left;
    }

    .profile-info h3 {
        color: #4195be;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .profile-info p {
        font-size: 1.1rem;
        margin: 10px 0;
        color: #34495e;
    }

    .profile-info strong {
        color: #2c3e50;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
        .profile-info {
    position: relative; /* Ensure the button is positioned relative to this box */
}

    .dashboard-button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #4195be;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none; /* Remove underline from the link */
    font-size: 1rem;
    font-weight: bold;
    transition: background-color 0.3s ease; /* Smooth hover effect */
    }

    .dashboard-button:hover {
    background-color: #317a9e; /* Darker shade on hover */
    }
}
</style>

<!-- kodee -->
<div class="dashboard">
        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>

        <div class="profile-info">
    <h3>Profile Information</h3>
    <p><strong>Age:</strong> {{ ucwords($profile->age) }}</p>
    <p><strong>Weight:</strong> {{ ucwords($profile->weight) }} lb</p>
    <p><strong>Height:</strong> {{ ucwords(intdiv($profile->height_inch, 12) . "' " . $profile->height_inch % 12 . '"') }}</p>
    <p><strong>Gender:</strong> {{ ucwords($profile->gender) }}</p>
    <p><strong>Activity Level:</strong> {{ ucwords($profile->activity_level) }}</p>
    <p><strong>Goal:</strong> {{ ucwords(str_replace('_', ' ', $profile->goal)) }}</p>

    <a href="{{ route('dashboard') }}" class="dashboard-button">See Your Dashboard</a>
</div>

<!-- someone else -->
<style>
    .dashboard {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .profile-info {
        background-color: #f5f5f5;  /* Lighter gray background */
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-info h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .profile-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .profile-stat {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-label {
        font-weight: bold;
        color: #555;
    }

    .stat-value {
        color: #333;
        margin-left: 10px;
    }

    .daily-calories {
        margin-bottom: 20px;
    }

    .calorie-chart {
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .profile-stats {
            grid-template-columns: 1fr;  /* Stacks stats vertically on smaller screens */
        }
    }
</style>

<div class="dashboard">
    <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
    <p>Here you can see your profile information, daily calorie needs, and more.</p>

    <!-- Profile Information Section -->
    <div class="profile-info">
        <h3>Profile Information</h3>
        <div class="profile-stats">
            <div class="profile-stat">
                <span class="stat-label">Age:</span>
                <span class="stat-value">{{ $profile->age }}</span>
            </div>
            <div class="profile-stat">
                <span class="stat-label">Weight:</span>
                <span class="stat-value">{{ $profile->weight }} lb</span>
            </div>
            <div class="profile-stat">
                <span class="stat-label">Height:</span>
                <span class="stat-value">{{ intdiv($profile->height_inch, 12) }}' {{ $profile->height_inch % 12 }}"</span>
            </div>
            <div class="profile-stat">
                <span class="stat-label">Gender:</span>
                <span class="stat-value">{{ $profile->gender }}</span>
            </div>
            <div class="profile-stat">
                <span class="stat-label">Activity Level:</span>
                <span class="stat-value">{{ $profile->activity_level }}</span>
            </div>
            <div class="profile-stat">
                <span class="stat-label">Goal:</span>
                <span class="stat-value">{{ $profile->goal }}</span>
            </div>
        </div>
    </div>

    <!-- Daily Calorie Calculation Section -->
    <div class="daily-calories">
        <h3>Calculate Your Daily Calorie Needs</h3>
        <p>Your total daily energy expenditure (TDEE) is calculated based on your profile. This can help you manage your nutrition and fitness goals.</p>
    </div>

    <!-- Calorie Chart Section -->
    <div class="calorie-chart">
        <canvas id="calorieGraph"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('calorieGraph').getContext('2d');
        const calorieGraph = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Protein', 'Carbs', 'Fats'],
                datasets: [{
                    label: 'Daily Calorie Needs',
                    data: [0, 0, 0],  // Use dynamic data passed from the controller
                    backgroundColor: ['#4caf50', '#ff9800', '#2196f3'],
                    borderColor: ['#388e3c', '#f57c00', '#1976d2'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 300  // Adjust based on the data
                    }
                }
            }
        });
    });
</script>

@endsection

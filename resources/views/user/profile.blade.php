@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

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

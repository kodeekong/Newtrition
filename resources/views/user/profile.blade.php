@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard">
        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>

        <div class="profile-info">
            <h3>Profile Information</h3>
            <p><strong>Age:</strong> {{ $profile->age }}</p>
            <p><strong>Weight:</strong> {{ $profile->weight }} lb</p>
            <p><strong>Height:</strong> {{ intdiv($profile->height_inch, 12) }}' {{ $profile->height_inch % 12 }}"</p>
            <p><strong>Gender:</strong> {{ $profile->gender }}</p>
            <p><strong>Goal:</strong> {{ $profile->goal }}</p>
            <p><strong>Activity Level:</strong> {{ $profile->activity_level }}</p>
        </div>

        <div class="daily-calories">
            <h3>Calculate Your Daily Calorie Needs</h3>
            <p>Your total daily energy expenditure (TDEE) is calculated based on your profile. This can help you manage your nutrition and fitness goals.</p>
        </div>

        <div class="calorie-chart">
            <canvas id="calorieGraph"></canvas>
        </div>
    </div>
    <form>

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
                        data: [
                            
                        ],  // Use dynamic data passed from the controller
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

<style>
.chart-container {
    width: 400px;  /* Adjust size */
    height: 400px; 
    margin: auto;
    position: relative;
}

.chart-container canvas {
    display: block;
}
</style>

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- kodee -->
<div class="dashboard">
        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>

        <!-- Profile Information Section -->
        <div class="profile-info">
            <h3>Profile Information</h3>
            <p><strong>Age:</strong> {{ $profile->age }}</p>
            <p><strong>Weight:</strong> {{ $profile->weight }} lb</p>
            <p><strong>Height:</strong> {{ intdiv($profile->height_inch, 12) }}' {{ $profile->height_inch % 12 }}"</p>
            <p><strong>Gender:</strong> {{ $profile->gender }}</p>
            <p><strong>Activity Level:</strong> {{ $profile->activity_level }}</p>
            <p><strong>Goal:</strong> {{ $profile->goal }}</p>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="chart-container">
    <canvas id="nutritionChart"></canvas>
    <div id="caloriesText" 
        style="
        position: absolute; 
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        font-size: 18px;
        font-weight: bold;
        color: #4195be;">
        0 kcal left
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('nutritionChart').getContext('2d');

    var caloriesConsumed = {{ $nutrition->calories_consumed ?? 0 }};
    var caloriesGoal = {{ $nutrition->calories_goal ?? 2310 }};
    var caloriesLeft = caloriesGoal - caloriesConsumed;

    document.getElementById('caloriesText').innerText = caloriesLeft + " kcal left"; // Update text dynamically

    var calorieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Consumed', 'Remaining'],
            datasets: [{
                data: [caloriesConsumed, caloriesLeft],
                backgroundColor: ['#4195be', '#1a1a1a'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%', // Ensures the center is visible
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>


    <!-- Progress Bars -->
    <div>
        <p>Carbs: <span id="carbs">{{ $nutrition->carbs_consumed ?? 0 }}</span> / {{ $nutrition->carbs_goal ?? 346 }} g</p>
        <progress value="{{ $nutrition->carbs_consumed ?? 0 }}" max="{{ $nutrition->carbs_goal ?? 346 }}"></progress>

        <p>Fat: <span id="fat">{{ $nutrition->fat_consumed ?? 0 }}</span> / {{ $nutrition->fat_goal ?? 64 }} g</p>
        <progress value="{{ $nutrition->fat_consumed ?? 0 }}" max="{{ $nutrition->fat_goal ?? 64 }}"></progress>

        <p>Protein: <span id="protein">{{ $nutrition->protein_consumed ?? 0 }}</span> / {{ $nutrition->protein_goal ?? 86 }} g</p>
        <progress value="{{ $nutrition->protein_consumed ?? 0 }}" max="{{ $nutrition->protein_goal ?? 86 }}"></progress>
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

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

@endsection

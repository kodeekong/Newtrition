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
    <div class="welcome-section">

        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>
        
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
        color: black;">
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
                backgroundColor: ['#4195be', 'rgba(65, 149, 190, 0.3)'],
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
<div style="display: flex; justify-content: center; gap: 40px; margin-top: 20px;">
    <div style="display: flex; flex-direction: column; align-items: center;">
        <p>Carbs: <span id="carbs">{{ $nutrition->carbs_consumed ?? 0 }}</span> / {{ $nutrition->carbs_goal ?? 346 }} g</p>
        <progress value="{{ $nutrition->carbs_consumed ?? 0 }}" max="{{ $nutrition->carbs_goal ?? 346 }}"></progress>
    </div>

    <div style="display: flex; flex-direction: column; align-items: center;">
        <p>Fat: <span id="fat">{{ $nutrition->fat_consumed ?? 0 }}</span> / {{ $nutrition->fat_goal ?? 64 }} g</p>
        <progress value="{{ $nutrition->fat_consumed ?? 0 }}" max="{{ $nutrition->fat_goal ?? 64 }}"></progress>
    </div>

    <div style="display: flex; flex-direction: column; align-items: center;">
        <p>Protein: <span id="protein">{{ $nutrition->protein_consumed ?? 0 }}</span> / {{ $nutrition->protein_goal ?? 86 }} g</p>
        <progress value="{{ $nutrition->protein_consumed ?? 0 }}" max="{{ $nutrition->protein_goal ?? 86 }}"></progress>
    </div>
</div>



@endsection

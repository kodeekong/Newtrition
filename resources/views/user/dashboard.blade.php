@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="welcome-section">

        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <canvas id="calorieChart"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById('calorieChart').getContext('2d');

            var calorieData = {
                labels: ['Consumed', 'Remaining'],
                datasets: [{
                    data: [0, 2310], // Change these values dynamically from your Laravel backend
                    backgroundColor: ['#3e8e41', '#1a1a1a'], // Green and dark background
                    borderWidth: 0
                }]
            };

            var calorieChart = new Chart(ctx, {
                type: 'doughnut',
                data: calorieData,
                options: {
                    rotation: Math.PI, // Half-doughnut (start at the bottom)
                    circumference: Math.PI, // Show only the top half
                    cutout: '70%', // Makes it a thinner progress ring
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>

<script>
    var caloriesConsumed = {{ $nutrition->calories_consumed ?? 0 }};
    var caloriesGoal = {{ $nutrition->calories_goal ?? 2310 }};

    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('calorieChart').getContext('2d');

        var calorieData = {
            labels: ['Consumed', 'Remaining'],
            datasets: [{
                data: [caloriesConsumed, caloriesGoal - caloriesConsumed],
                backgroundColor: ['#3e8e41', '#1a1a1a'],
                borderWidth: 0
            }]
        };

        var calorieChart = new Chart(ctx, {
            type: 'doughnut',
            data: calorieData,
            options: {
                rotation: Math.PI,
                circumference: Math.PI,
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
<div>
    <p>Carbs: <span id="carbs">{{ $nutrition->carbs_consumed ?? 0 }}</span> / {{ $nutrition->carbs_goal ?? 346 }} g</p>
    <progress value="{{ $nutrition->carbs_consumed ?? 0 }}" max="{{ $nutrition->carbs_goal ?? 346 }}"></progress>

    <p>Fat: <span id="fat">{{ $nutrition->fat_consumed ?? 0 }}</span> / {{ $nutrition->fat_goal ?? 64 }} g</p>
    <progress value="{{ $nutrition->fat_consumed ?? 0 }}" max="{{ $nutrition->fat_goal ?? 64 }}"></progress>

    <p>Protein: <span id="protein">{{ $nutrition->protein_consumed ?? 0 }}</span> / {{ $nutrition->protein_goal ?? 86 }} g</p>
    <progress value="{{ $nutrition->protein_consumed ?? 0 }}" max="{{ $nutrition->protein_goal ?? 86 }}"></progress>
</div>


@endsection

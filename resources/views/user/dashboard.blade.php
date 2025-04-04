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

@endsection

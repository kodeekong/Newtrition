@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="welcome-section">
        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>

        <!-- Here, you can add additional content, like a calorie chart or any user-specific data -->
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
                        data: [200, 250, 100], // Example data, can be dynamic based on the profile
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
                            max: 300
                        }
                    }
                }
            });
        });
    </script>
@endsection

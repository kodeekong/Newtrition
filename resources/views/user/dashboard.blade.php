@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="welcome-section">

        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>
        
    <p><strong>TDEE (Calories for daily maintenance):</strong> {{ number_format($profile->trackingNutrition->calories_goal, 2) }} kcal</p>
    <p><strong>Calories Goal:</strong> {{ number_format($profile->trackingNutrition->calories_goal, 2) }} kcal</p>
    <p><strong>Protein Goal:</strong> {{ number_format($profile->trackingNutrition->protein_goal, 2) }} g</p>
    <p><strong>Carbs Goal:</strong> {{ number_format($profile->trackingNutrition->carbs_goal, 2) }} g</p>
    <p><strong>Fat Goal:</strong> {{ number_format($profile->trackingNutrition->fat_goal, 2) }} g</p>

        <!-- Button to Toggle the Calorie Graph -->
        <button id="toggleGraphBtn" class="btn btn-primary">View Calorie Graph</button>

        <!-- Collapsible Graph Section (Initially off-screen or minimized) -->
        <div id="graphContainer" style="display:none; position: fixed; bottom: 20px; right: 20px; width: 320px; height: 240px; transition: transform 0.3s ease-in-out;">
            <div class="calorie-chart">
                <canvas id="calorieGraph" width="300" height="200"></canvas>
            </div>
        </div>

        <!-- Personalized Content (e.g., Nutrition Articles) -->
        <div class="personalized-content">
            <h2>Nutrition!</h2>
            <p>Based on your profile, we’ve tailored this  just for you...</p>
            <!-- Add personalized articles here -->
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

            // Toggle the graph container on button click
            const toggleBtn = document.getElementById('toggleGraphBtn');
            const graphContainer = document.getElementById('graphContainer');

            toggleBtn.addEventListener('click', function() {
                if (graphContainer.style.display === 'none') {
                    graphContainer.style.display = 'block';
                    graphContainer.style.transform = 'translateX(0)'; // Slide it into view
                    toggleBtn.textContent = 'Hide Calorie Graph';
                } else {
                    graphContainer.style.transform = 'translateX(200%)'; // Slide it out of view
                    setTimeout(function() {
                        graphContainer.style.display = 'none';
                    }, 300); // Hide it after the transition
                    toggleBtn.textContent = 'View Calorie Graph';
                }
            });
        });
    </script>
@endsection

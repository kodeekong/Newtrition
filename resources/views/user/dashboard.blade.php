<style>
    main {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .welcome-section {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .chart-container {
        width: 400px;
        height: 400px;
        margin: auto;
        position: relative;
    }

    .chart-container canvas {
        display: block;
        width: 100%; 
        height: 100%; 
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
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 18px; color: black;">
                0 kcal left
            </div>
        </div>

        <button id="addFoodBtn" style="margin-top: 20px; padding: 10px 20px; background-color: #4195be; color: white; border: none; border-radius: 5px;">
            + Add Food
        </button>

        <div id="addFoodModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); align-items: center; justify-content: center;">
            <div style="background-color: white; padding: 20px; border-radius: 5px; width: 300px;">
                <h2>Add Food</h2>
                <form id="addFoodForm">
                    <label for="foodName">Food Name</label><br>
                    <input type="text" id="foodName" required><br><br>
                    <label for="calories">Calories</label><br>
                    <input type="number" id="calories" required><br><br>
                    <label for="carbs">Carbs (g)</label><br>
                    <input type="number" id="carbs" required><br><br>
                    <label for="fat">Fat (g)</label><br>
                    <input type="number" id="fat" required><br><br>
                    <label for="protein">Protein (g)</label><br>
                    <input type="number" id="protein" required><br><br>
                    <button type="submit" style="background-color: #4195be; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Add Food</button>
                    <button type="button" id="closeModal" style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-left: 10px;">Cancel</button>
                </form>
            </div>
        </div>

        <script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('nutritionChart').getContext('2d');
        
        var caloriesConsumed = {{ $nutrition->calories_consumed ?? 0 }};
        var caloriesGoal = {{ $nutrition->calories_goal ?? 2310 }};
        var caloriesLeft = caloriesGoal - caloriesConsumed;

        document.getElementById('caloriesText').innerText = caloriesLeft + " kcal left"; 

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
                cutout: '70%',
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Handle Add Food Button
        var addFoodBtn = document.getElementById('addFoodBtn');
        var addFoodModal = document.getElementById('addFoodModal');
        var closeModalBtn = document.getElementById('closeModal');
        var addFoodForm = document.getElementById('addFoodForm');

        addFoodBtn.addEventListener('click', function () {
            addFoodModal.style.display = 'flex';
        });

        closeModalBtn.addEventListener('click', function () {
            addFoodModal.style.display = 'none';
        });

        addFoodForm.addEventListener('submit', function (e) {
            e.preventDefault();

            var foodName = document.getElementById('foodName').value;
            var calories = parseInt(document.getElementById('calories').value);
            var carbs = parseInt(document.getElementById('carbs').value);
            var fat = parseInt(document.getElementById('fat').value);
            var protein = parseInt(document.getElementById('protein').value);
            var quantity = parseInt(document.getElementById('quantity').value);  // Add the quantity field
            var date = document.getElementById('date').value;  // Add the date field

            // Make the AJAX request
            var formData = new FormData();
            formData.append('food_name', foodName);
            formData.append('calories', calories);
            formData.append('carbs', carbs);
            formData.append('fat', fat);
            formData.append('protein', protein);
            formData.append('quantity', quantity);
            formData.append('date', date);

            fetch('{{ route('add.food') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the consumed values
                    caloriesConsumed += calories;
                    caloriesLeft = caloriesGoal - caloriesConsumed;

                    // Update the chart and text
                    calorieChart.data.datasets[0].data = [caloriesConsumed, caloriesLeft];
                    calorieChart.update();

                    document.getElementById('caloriesText').innerText = caloriesLeft + " kcal left";

                    // Close the modal
                    addFoodModal.style.display = 'none';

                    // Clear the form
                    addFoodForm.reset();
                } else {
                    alert('Failed to add food entry.');
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
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
        </div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #eef3f8;
        margin: 0;
        padding: 0;
        height: 100vh; /* Full viewport height */
        overflow: hidden; /* Prevent scrolling */
    }

    .welcome-section {
        margin: 0; /* Remove extra margin */
        padding: 10px 0; /* Reduce padding between header and content */
        background-color: transparent;
        text-align: center;
    }

    .welcome-section h1 {
        font-size: 2rem; /* Keep font size */
        color: #2c3e50;
        margin-bottom: 5px; /* Reduce spacing below the header */
    }

    .welcome-section p {
        font-size: 1.1rem; /* Keep font size */
        color: #555;
        margin-bottom: 10px; /* Reduce spacing below the paragraph */
    }

    .chart-container {
        width: 300px; /* Adjust chart size to fit the page */
        height: 300px;
        margin: auto;
        position: relative;
    }

    .chart-container canvas {
        display: block;
        width: 100%;
        height: 100%;
    }

    #caloriesText {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.1rem;
        color: black;
    }

    #addFoodBtn {
        margin-top: 10px; /* Reduce spacing above the button */
        padding: 10px 20px;
        background-color: #4195be;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #addFoodBtn:hover {
        background-color: rgb(45, 86, 107);
    }

    #addFoodModal {
        display: none; /* Hidden by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
        z-index: 1000; /* Ensure it appears above other elements */
    }

    #addFoodModal > div {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        width: 300px;
    }

    .progress-bars {
        display: flex;
        justify-content: center;
        gap: 20px; /* Reduce spacing between progress bars */
        margin-top: 10px; /* Reduce spacing above progress bars */
    }

    .progress-bars div {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    progress {
        width: 100px; /* Adjust progress bar width */
        height: 10px;
    }
</style>

<div class="welcome-section">
    <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
    <p>Here you can see your profile information, daily calorie needs, and more.</p>

    <div class="chart-container">
        <canvas id="nutritionChart"></canvas>
        <div id="caloriesText">0 kcal left</div>
    </div>

    <button id="addFoodBtn">+ Add Food</button>

    <div id="addFoodModal">
        <div>
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
                <button type="submit">Add Food</button>
                <button type="button" id="closeModal">Cancel</button>
            </form>
        </div>
    </div>

    <div class="progress-bars">
        <div>
            <p>Carbs: <span id="carbs">{{ $nutrition->carbs_consumed ?? 0 }}</span> / {{ $nutrition->carbs_goal ?? 346 }} g</p>
            <progress value="{{ $nutrition->carbs_consumed ?? 0 }}" max="{{ $nutrition->carbs_goal ?? 346 }}"></progress>
        </div>
        <div>
            <p>Fat: <span id="fat">{{ $nutrition->fat_consumed ?? 0 }}</span> / {{ $nutrition->fat_goal ?? 64 }} g</p>
            <progress value="{{ $nutrition->fat_consumed ?? 0 }}" max="{{ $nutrition->fat_goal ?? 64 }}"></progress>
        </div>
        <div>
            <p>Protein: <span id="protein">{{ $nutrition->protein_consumed ?? 0 }}</span> / {{ $nutrition->protein_goal ?? 86 }} g</p>
            <progress value="{{ $nutrition->protein_consumed ?? 0 }}" max="{{ $nutrition->protein_goal ?? 86 }}"></progress>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    // Modal functionality
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

        // Send data to the backend
        fetch('{{ route('add.food') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                food_name: foodName,
                calories: calories,
                carbs: carbs,
                fat: fat,
                protein: protein,
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update chart data
                caloriesConsumed = data.calories_consumed;
                caloriesLeft = caloriesGoal - caloriesConsumed;

                calorieChart.data.datasets[0].data = [caloriesConsumed, caloriesLeft];
                calorieChart.update();

                document.getElementById('caloriesText').innerText = caloriesLeft + " kcal left";

                // Update progress bars
                document.getElementById('carbs').innerText = data.carbs_consumed;
                document.getElementById('fat').innerText = data.fat_consumed;
                document.getElementById('protein').innerText = data.protein_consumed;

                document.querySelector('progress[value="{{ $nutrition->carbs_consumed ?? 0 }}"]').value = data.carbs_consumed;
                document.querySelector('progress[value="{{ $nutrition->fat_consumed ?? 0 }}"]').value = data.fat_consumed;
                document.querySelector('progress[value="{{ $nutrition->protein_consumed ?? 0 }}"]').value = data.protein_consumed;

                // Close the modal
                addFoodModal.style.display = 'none';

                // Reset the form
                addFoodForm.reset();
            } else {
                alert('Failed to add food entry.');
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });
});
</script>

@endsection
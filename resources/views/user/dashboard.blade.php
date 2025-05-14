@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    :root {
        --primary-color: #2563eb;
        --primary-hover: #1d4ed8;
        --secondary-color: #64748b;
        --accent-color: #f59e0b;
        --background-color: #f8fafc;
        --card-background: #ffffff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
    }

    [data-theme="dark"] {
        --primary-color: #3b82f6;
        --primary-hover: #60a5fa;
        --secondary-color: #94a3b8;
        --accent-color: #fbbf24;
        --background-color: #0f172a;
        --card-background: #1e293b;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --border-color: #334155;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--background-color);
        color: var(--text-primary);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .theme-toggle {
        background: none;
        border: none;
        color: var(--text-primary);
        cursor: pointer;
        font-size: 1.5rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background-color: var(--card-background);
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .stat-card h3 {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .stat-card .value {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .chart-container {
        background-color: var(--card-background);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .meal-section {
        background-color: var(--card-background);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .meal-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .meal-tab {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        background-color: var(--background-color);
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .meal-tab.active {
        background-color: var(--primary-color);
        color: white;
    }

    .history-section {
        background-color: var(--card-background);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .date-picker {
        margin-bottom: 1rem;
    }

    .date-picker input {
        padding: 0.5rem;
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        background-color: var(--background-color);
        color: var(--text-primary);
    }

    .btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        background-color: var(--primary-color);
        color: white;
    }

    .btn:hover {
        background-color: var(--primary-hover);
        transform: translateY(-1px);
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: var(--card-background);
        padding: 2rem;
        border-radius: 0.75rem;
        width: 90%;
        max-width: 500px;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .form-group input, .form-group select {
        width: 100%;
        padding: 0.75rem;
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        background-color: var(--background-color);
        color: var(--text-primary);
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <button class="theme-toggle" onclick="toggleTheme()">
            <i class="fas fa-moon"></i>
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Calories Consumed</h3>
            <div class="value">{{ $nutrition->calories_consumed ?? 0 }} / {{ $nutrition->calories_goal ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>Calories Burned</h3>
            <div class="value" id="caloriesBurned">0</div>
        </div>
        <div class="stat-card">
            <h3>Net Calories</h3>
            <div class="value" id="netCalories">0</div>
        </div>
        <div class="stat-card">
            <h3>Exercise Duration</h3>
            <div class="value" id="exerciseDuration">0 min</div>
        </div>
    </div>

    <div class="chart-container">
        <canvas id="nutritionChart"></canvas>
    </div>

    <div class="meal-section">
        <h2>Meal Tracking</h2>
        <div class="meal-tabs">
            <div class="meal-tab active" data-meal="breakfast">Breakfast</div>
            <div class="meal-tab" data-meal="lunch">Lunch</div>
            <div class="meal-tab" data-meal="dinner">Dinner</div>
            <div class="meal-tab" data-meal="snack">Snacks</div>
        </div>
        <div id="mealContent">
            <!-- Meal content will be loaded here -->
        </div>
        <button class="btn" onclick="showAddFoodModal()">Add Food</button>
    </div>

    <div class="history-section">
        <h2>History</h2>
        <div class="date-picker">
            <input type="date" id="historyDate" onchange="loadHistory()">
        </div>
        <div id="historyContent">
            <!-- History content will be loaded here -->
        </div>
    </div>
</div>

<!-- Add Food Modal -->
<div id="addFoodModal" class="modal">
    <div class="modal-content">
        <h2>Add Food</h2>
        <form id="addFoodForm">
            <div class="form-group">
                <label for="foodName">Food Name</label>
                <input type="text" id="foodName" required>
            </div>
            <div class="form-group">
                <label for="mealCategory">Meal Category</label>
                <select id="mealCategory" required>
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                    <option value="snack">Snack</option>
                </select>
            </div>
            <div class="form-group">
                <label for="calories">Calories</label>
                <input type="number" id="calories" required>
            </div>
            <div class="form-group">
                <label for="carbs">Carbs (g)</label>
                <input type="number" id="carbs" required>
            </div>
            <div class="form-group">
                <label for="fat">Fat (g)</label>
                <input type="number" id="fat" required>
            </div>
            <div class="form-group">
                <label for="protein">Protein (g)</label>
                <input type="number" id="protein" required>
            </div>
            <button type="submit" class="btn">Add Food</button>
            <button type="button" class="btn" onclick="closeAddFoodModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- Add Exercise Modal -->
<div id="addExerciseModal" class="modal">
    <div class="modal-content">
        <h2>Add Exercise</h2>
        <form id="addExerciseForm">
            <div class="form-group">
                <label for="exerciseName">Exercise Name</label>
                <input type="text" id="exerciseName" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration (minutes)</label>
                <input type="number" id="duration" required>
            </div>
            <div class="form-group">
                <label for="intensity">Intensity</label>
                <select id="intensity" required>
                    <option value="light">Light</option>
                    <option value="moderate">Moderate</option>
                    <option value="intense">Intense</option>
                </select>
            </div>
            <button type="submit" class="btn">Add Exercise</button>
            <button type="button" class="btn" onclick="closeAddExerciseModal()">Cancel</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // PHP to JavaScript variables
    const nutritionValues = {
        consumed: {
            calories: {{ $nutrition->calories_consumed ?? 0 }},
            protein: {{ $nutrition->protein_consumed ?? 0 }},
            carbs: {{ $nutrition->carbs_consumed ?? 0 }},
            fat: {{ $nutrition->fat_consumed ?? 0 }}
        },
        goals: {
            calories: {{ $nutrition->calories_goal ?? 0 }},
            protein: {{ $nutrition->protein_goal ?? 0 }},
            carbs: {{ $nutrition->carbs_goal ?? 0 }},
            fat: {{ $nutrition->fat_goal ?? 0 }}
        }
    };

    // Theme Toggle
    function toggleTheme() {
        const body = document.body;
        const currentTheme = body.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        body.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        const icon = document.querySelector('.theme-toggle i');
        icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }

    // Load saved theme
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.body.setAttribute('data-theme', savedTheme);
        const icon = document.querySelector('.theme-toggle i');
        icon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

        // Initialize Charts
        const ctx = document.getElementById('nutritionChart');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Calories', 'Protein', 'Carbs', 'Fat'],
                    datasets: [{
                        label: 'Consumed',
                        data: [
                            nutritionValues.consumed.calories,
                            nutritionValues.consumed.protein,
                            nutritionValues.consumed.carbs,
                            nutritionValues.consumed.fat
                        ],
                        backgroundColor: 'rgba(37, 99, 235, 0.5)',
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Goal',
                        data: [
                            nutritionValues.goals.calories,
                            nutritionValues.goals.protein,
                            nutritionValues.goals.carbs,
                            nutritionValues.goals.fat
                        ],
                        backgroundColor: 'rgba(245, 158, 11, 0.5)',
                        borderColor: 'rgba(245, 158, 11, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });

    // Meal Tabs
    document.querySelectorAll('.meal-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.meal-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            loadMealContent(this.dataset.meal);
        });
    });

    // Load Meal Content
    function loadMealContent(meal) {
        const mealContent = document.getElementById('mealContent');
        if (mealContent) {
            // Implement meal content loading
            mealContent.innerHTML = `<p>Loading ${meal} content...</p>`;
        }
    }

    // Load History
    function loadHistory() {
        const date = document.getElementById('historyDate')?.value;
        if (!date) return;

        fetch(`/exercise/history?date=${date}`)
            .then(response => response.json())
            .then(data => {
                const caloriesBurned = document.getElementById('caloriesBurned');
                const exerciseDuration = document.getElementById('exerciseDuration');
                const netCalories = document.getElementById('netCalories');

                if (caloriesBurned) caloriesBurned.textContent = data.total_calories_burned || 0;
                if (exerciseDuration) exerciseDuration.textContent = `${data.total_duration || 0} min`;
                if (netCalories) netCalories.textContent = nutritionValues.consumed.calories - (data.total_calories_burned || 0);
            })
            .catch(error => {
                console.error('Error loading history:', error);
            });
    }

    // Modal Functions
    function showAddFoodModal() {
        const modal = document.getElementById('addFoodModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeAddFoodModal() {
        const modal = document.getElementById('addFoodModal');
        if (modal) modal.style.display = 'none';
    }

    function showAddExerciseModal() {
        const modal = document.getElementById('addExerciseModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeAddExerciseModal() {
        const modal = document.getElementById('addExerciseModal');
        if (modal) modal.style.display = 'none';
    }

    // Form Submissions
    const addFoodForm = document.getElementById('addFoodForm');
    if (addFoodForm) {
        addFoodForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Implement food submission
            console.log('Food form submitted');
        });
    }

    const addExerciseForm = document.getElementById('addExerciseForm');
    if (addExerciseForm) {
        addExerciseForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Implement exercise submission
            console.log('Exercise form submitted');
        });
    }
</script>
@endsection

@extends('layouts.app')

@section('title', 'Exercise Tracker')

@section('content')
<style>
    .exercise-container {
        background: linear-gradient(135deg, var(--card-background) 0%, var(--card-background-secondary) 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-title {
        position: relative;
        display: inline-block;
        margin-bottom: 2rem;
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    .form-card {
        background: linear-gradient(135deg, #1a1f2c 0%, #2d3748 100%);
        border-radius: 1.25rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .form-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-header h2 {
        font-size: 1.75rem;
        color: #e2e8f0;
        margin-bottom: 0.75rem;
    }

    .form-header p {
        color: #94a3b8;
        font-size: 1rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-group i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .form-group input,
    .form-group select {
        background: #2d3748;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        height: auto;
        width: 100%;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        outline: none;
    }

    .form-group input::placeholder {
        color: #64748b;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #e2e8f0;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .submit-button {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color-dark) 100%);
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.875rem;
        font-weight: 600;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-top: 1.5rem;
    }

    .submit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .submit-button:active {
        transform: translateY(0);
    }

    .submit-button::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }

    .submit-button:hover::after {
        animation: ripple 1s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }

    .history-card {
        background: var(--card-background);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-top: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .history-card:hover {
        transform: translateY(-5px);
    }

    .table-header {
        background: linear-gradient(135deg, var(--table-header-background) 0%, var(--table-header-background-secondary) 100%);
        padding: 1rem;
    }

    .table-header th {
        color: var(--text-primary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem;
    }

    .table-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .table-row:hover {
        transform: scale(1.01);
        background: var(--hover-color);
    }

    .table-row td {
        padding: 1rem;
        color: var(--text-primary);
    }

    .intensity-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .intensity-badge:hover {
        transform: scale(1.05);
    }

    .delete-button {
        transition: all 0.3s ease;
        padding: 0.5rem;
        border-radius: 0.5rem;
        color: var(--error-color);
    }

    .delete-button:hover {
        background: var(--error-color-light);
        transform: scale(1.1);
    }

    .empty-state {
        padding: 3rem;
        text-align: center;
        background: var(--card-background);
        border-radius: 1rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-top: 1rem;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .error-message i {
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .form-header {
            margin-bottom: 1.5rem;
        }

        .form-header h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="exercise-container">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="page-title">Exercise Tracker</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 success-message" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Add Exercise Form -->
        <div class="form-card">
            <div class="form-header">
                <h2>Add New Exercise</h2>
                <p>Track your workout and stay motivated!</p>
            </div>
            <form action="{{ route('exercises.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="exercise_name" class="form-label">Exercise Name</label>
                        <input type="text" 
                               id="exercise_name" 
                               name="exercise_name" 
                               class="form-input"
                               value="{{ old('exercise_name') }}"
                               placeholder="e.g., Running, Swimming, Cycling"
                               required>
                        @error('exercise_name')
                            <p class="error-message">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" 
                               id="date" 
                               name="date" 
                               class="form-input"
                               value="{{ old('date', date('Y-m-d')) }}"
                               required>
                        @error('date')
                            <p class="error-message">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                        <input type="number" 
                               id="duration_minutes" 
                               name="duration_minutes" 
                               class="form-input"
                               value="{{ old('duration_minutes') }}"
                               placeholder="e.g., 30"
                               min="1"
                               required>
                        @error('duration_minutes')
                            <p class="error-message">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="calories_burned" class="form-label">Calories Burned</label>
                        <input type="number" 
                               id="calories_burned" 
                               name="calories_burned" 
                               class="form-input"
                               value="{{ old('calories_burned') }}"
                               placeholder="e.g., 300"
                               min="1"
                               required>
                        @error('calories_burned')
                            <p class="error-message">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="intensity" class="form-label">Intensity</label>
                        <select id="intensity" 
                                name="intensity" 
                                class="form-input"
                                required>
                            <option value="light" {{ old('intensity') === 'light' ? 'selected' : '' }}>Light</option>
                            <option value="moderate" {{ old('intensity') === 'moderate' ? 'selected' : '' }}>Moderate</option>
                            <option value="intense" {{ old('intensity') === 'intense' ? 'selected' : '' }}>Intense</option>
                        </select>
                        @error('intensity')
                            <p class="error-message">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="submit-button">
                    Save Exercise
                </button>
            </form>
        </div>

        <!-- Exercise History -->
        <div class="history-card">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="table-header">
                        <tr>
                            <th>Date</th>
                            <th>Exercise</th>
                            <th>Duration</th>
                            <th>Calories</th>
                            <th>Intensity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($exercises as $exercise)
                            <tr class="table-row">
                                <td>{{ $exercise->date->format('M d, Y') }}</td>
                                <td>{{ $exercise->exercise_name }}</td>
                                <td>{{ $exercise->duration_minutes }} minutes</td>
                                <td>{{ $exercise->calories_burned }} kcal</td>
                                <td>
                                    <span class="intensity-badge
                                        @if($exercise->intensity === 'light') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                        @elseif($exercise->intensity === 'moderate') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                        @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                        @endif">
                                        {{ ucfirst($exercise->intensity) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('exercises.destroy', $exercise) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this exercise?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-dumbbell"></i>
                                    <p>No exercises recorded yet. Start by adding your first exercise!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($exercises->hasPages())
            <div class="mt-6">
                {{ $exercises->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 
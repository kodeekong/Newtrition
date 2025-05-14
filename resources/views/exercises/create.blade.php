@extends('layouts.app')

<style>
    .exercise-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .exercise-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background-color: var(--card-background);
        color: var(--text-primary);
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }

    .back-button:hover {
        background-color: var(--hover-color);
        color: var(--text-primary);
    }

    .back-button i {
        margin-right: 0.5rem;
    }

    .exercise-form {
        background: var(--card-background);
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .form-title {
        color: var(--text-primary);
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-primary);
        background-color: var(--input-background);
        transition: all 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px var(--primary-color-transparent);
    }

    .form-input::placeholder {
        color: var(--text-secondary);
    }

    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-primary);
        background-color: var(--input-background);
        cursor: pointer;
        transition: all 0.2s;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px var(--primary-color-transparent);
    }

    .submit-button {
        width: 100%;
        padding: 0.875rem 1.5rem;
        background-color: var(--primary-color);
        color: white;
        font-weight: 500;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 1rem;
    }

    .submit-button:hover {
        background-color: var(--primary-color-dark);
    }

    .submit-button:active {
        transform: scale(0.98);
    }

    .error-message {
        color: var(--error-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: var(--card-background);
        border-radius: 1rem;
        padding: 2rem;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }

    .close-button {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        color: var(--text-primary);
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
        line-height: 1;
        border-radius: 0.5rem;
        transition: all 0.2s;
    }

    .close-button:hover {
        background-color: var(--hover-color);
    }

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .exercise-form {
            padding: 1.5rem;
        }

        .modal-content {
            width: 95%;
            padding: 1.5rem;
        }
    }
</style>

@section('content')
<div class="exercise-container">
    <div class="exercise-header">
        <a href="{{ route('exercises.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Exercise List
        </a>
    </div>

    <div class="exercise-form">
        <h1 class="form-title">Add New Exercise</h1>
        
        <form action="{{ route('exercises.store') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="exercise_name" class="form-label">Exercise Name</label>
                    <input type="text" 
                           id="exercise_name" 
                           name="exercise_name" 
                           class="form-input" 
                           value="{{ old('exercise_name') }}"
                           placeholder="e.g., Running, Swimming, Cycling"
                           required>
                    @error('exercise_name')
                        <p class="error-message">{{ $message }}</p>
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
                        <p class="error-message">{{ $message }}</p>
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
                        <p class="error-message">{{ $message }}</p>
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
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="intensity" class="form-label">Intensity</label>
                    <select id="intensity" 
                            name="intensity" 
                            class="form-select"
                            required>
                        <option value="light" {{ old('intensity') === 'light' ? 'selected' : '' }}>Light</option>
                        <option value="moderate" {{ old('intensity') === 'moderate' ? 'selected' : '' }}>Moderate</option>
                        <option value="intense" {{ old('intensity') === 'intense' ? 'selected' : '' }}>Intense</option>
                    </select>
                    @error('intensity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="submit-button">Save Exercise</button>
        </form>
    </div>
</div>

<!-- Modal Template -->
<div class="modal-overlay" id="exerciseModal">
    <div class="modal-content">
        <button class="close-button" onclick="closeModal()">&times;</button>
        <h1 class="form-title">Add New Exercise</h1>
        
        <form action="{{ route('exercises.store') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="modal_exercise_name" class="form-label">Exercise Name</label>
                    <input type="text" 
                           id="modal_exercise_name" 
                           name="exercise_name" 
                           class="form-input" 
                           value="{{ old('exercise_name') }}"
                           placeholder="e.g., Running, Swimming, Cycling"
                           required>
                    @error('exercise_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="modal_date" class="form-label">Date</label>
                    <input type="date" 
                           id="modal_date" 
                           name="date" 
                           class="form-input"
                           value="{{ old('date', date('Y-m-d')) }}"
                           required>
                    @error('date')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="modal_duration_minutes" class="form-label">Duration (minutes)</label>
                    <input type="number" 
                           id="modal_duration_minutes" 
                           name="duration_minutes" 
                           class="form-input"
                           value="{{ old('duration_minutes') }}"
                           placeholder="e.g., 30"
                           min="1"
                           required>
                    @error('duration_minutes')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="modal_calories_burned" class="form-label">Calories Burned</label>
                    <input type="number" 
                           id="modal_calories_burned" 
                           name="calories_burned" 
                           class="form-input"
                           value="{{ old('calories_burned') }}"
                           placeholder="e.g., 300"
                           min="1"
                           required>
                    @error('calories_burned')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="modal_intensity" class="form-label">Intensity</label>
                    <select id="modal_intensity" 
                            name="intensity" 
                            class="form-select"
                            required>
                        <option value="light" {{ old('intensity') === 'light' ? 'selected' : '' }}>Light</option>
                        <option value="moderate" {{ old('intensity') === 'moderate' ? 'selected' : '' }}>Moderate</option>
                        <option value="intense" {{ old('intensity') === 'intense' ? 'selected' : '' }}>Intense</option>
                    </select>
                    @error('intensity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="submit-button">Save Exercise</button>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('exerciseModal').classList.add('active');
}

function closeModal() {
    document.getElementById('exerciseModal').classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('exerciseModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>
@endsection 
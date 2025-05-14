@extends('layouts.app')

@section('title', 'Food Entry')

@section('content')
<style>
    .food-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .food-header {
        margin-bottom: 2rem;
    }

    .food-title {
        color: var(--text-primary);
        font-size: 1.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .food-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .food-form {
        background: var(--card-background);
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
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

    .food-table {
        width: 100%;
        background: var(--card-background);
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .food-table th {
        background-color: var(--table-header-background);
        padding: 1rem;
        text-align: left;
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .food-table td {
        padding: 1rem;
        color: var(--text-primary);
        font-size: 0.875rem;
        border-top: 1px solid var(--border-color);
    }

    .food-table tr:hover {
        background-color: var(--hover-color);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-edit {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }

    .btn-edit:hover {
        background-color: var(--primary-color-dark);
    }

    .btn-delete {
        background-color: var(--error-color);
        color: white;
        border: none;
    }

    .btn-delete:hover {
        background-color: var(--error-color-dark);
    }

    .edit-form {
        display: none;
        margin-top: 1rem;
        padding: 1rem;
        background-color: var(--input-background);
        border-radius: 0.5rem;
    }

    .edit-form.active {
        display: block;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: var(--card-background);
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .empty-state p {
        color: var(--text-secondary);
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .food-table {
            display: block;
            overflow-x: auto;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="food-container">
    <div class="food-header">
        <h1 class="food-title">Food Entry</h1>
        <p class="food-subtitle">Track your daily nutrition intake</p>
    </div>

    <div class="food-form">
        <h2 class="form-title">Add New Food Entry</h2>
        <form action="{{ route('food.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="food_name" class="form-label">Food Name</label>
                    <input type="text" 
                           id="food_name" 
                           name="food_name" 
                           class="form-input"
                           placeholder="e.g., Grilled Chicken Breast"
                           required>
                </div>

                <div class="form-group">
                    <label for="calories" class="form-label">Calories</label>
                    <input type="number" 
                           id="calories" 
                           name="calories" 
                           class="form-input"
                           step="0.1"
                           placeholder="e.g., 250"
                           required>
                </div>

                <div class="form-group">
                    <label for="carbs" class="form-label">Carbs (g)</label>
                    <input type="number" 
                           id="carbs" 
                           name="carbs" 
                           class="form-input"
                           step="0.1"
                           placeholder="e.g., 30"
                           required>
                </div>

                <div class="form-group">
                    <label for="fat" class="form-label">Fat (g)</label>
                    <input type="number" 
                           id="fat" 
                           name="fat" 
                           class="form-input"
                           step="0.1"
                           placeholder="e.g., 10"
                           required>
                </div>

                <div class="form-group">
                    <label for="protein" class="form-label">Protein (g)</label>
                    <input type="number" 
                           id="protein" 
                           name="protein" 
                           class="form-input"
                           step="0.1"
                           placeholder="e.g., 25"
                           required>
                </div>

                <div class="form-group">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" 
                           id="quantity" 
                           name="quantity" 
                           class="form-input"
                           value="1"
                           min="1"
                           required>
                </div>

                <div class="form-group">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" 
                           id="date" 
                           name="date" 
                           class="form-input"
                           value="{{ date('Y-m-d') }}"
                           required>
                </div>
            </div>

            <button type="submit" class="submit-button">Add Entry</button>
        </form>
    </div>

    @if($foodEntries->isEmpty())
        <div class="empty-state">
            <p>You haven't logged any food yet. Start adding food entries!</p>
        </div>
    @else
        <table class="food-table">
            <thead>
                <tr>
                    <th>Food Name</th>
                    <th>Calories</th>
                    <th>Carbs (g)</th>
                    <th>Fat (g)</th>
                    <th>Protein (g)</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($foodEntries as $entry)
                    <tr id="entry-row-{{ $entry->id }}">
                        <td>{{ $entry->food_name }}</td>
                        <td>{{ $entry->calories }}</td>
                        <td>{{ $entry->carbs }}</td>
                        <td>{{ $entry->fat }}</td>
                        <td>{{ $entry->protein }}</td>
                        <td>{{ $entry->quantity }}</td>
                        <td>{{ $entry->date ? $entry->date->format('Y-m-d') : $entry->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-edit" onclick="toggleEditForm({{ $entry->id }})">Edit</button>
                                <form action="{{ route('food.remove', $entry->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</button>
                                </form>
                            </div>
                            <form id="edit-form-{{ $entry->id }}" class="edit-form" action="{{ route('food.update', $entry->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="calories" class="form-label">Calories</label>
                                        <input type="number" 
                                               name="calories" 
                                               class="form-input"
                                               value="{{ $entry->calories }}" 
                                               step="0.1" 
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="carbs" class="form-label">Carbs (g)</label>
                                        <input type="number" 
                                               name="carbs" 
                                               class="form-input"
                                               value="{{ $entry->carbs }}" 
                                               step="0.1" 
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="fat" class="form-label">Fat (g)</label>
                                        <input type="number" 
                                               name="fat" 
                                               class="form-input"
                                               value="{{ $entry->fat }}" 
                                               step="0.1" 
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="protein" class="form-label">Protein (g)</label>
                                        <input type="number" 
                                               name="protein" 
                                               class="form-input"
                                               value="{{ $entry->protein }}" 
                                               step="0.1" 
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" 
                                               name="quantity" 
                                               class="form-input"
                                               value="{{ $entry->quantity }}" 
                                               min="1" 
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" 
                                               name="date" 
                                               class="form-input"
                                               value="{{ $entry->date ? $entry->date->format('Y-m-d') : $entry->created_at->format('Y-m-d') }}" 
                                               required>
                                    </div>
                                </div>

                                <div class="action-buttons">
                                    <button type="submit" class="btn btn-edit">Save</button>
                                    <button type="button" class="btn btn-delete" onclick="toggleEditForm({{ $entry->id }})">Cancel</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
function toggleEditForm(entryId) {
    const form = document.getElementById(`edit-form-${entryId}`);
    form.classList.toggle('active');
}
</script>
@endsection

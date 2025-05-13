@extends('layouts.app')

@section('title', 'Food Entry')

@section('content')
<style>
    .food-log { padding: 20px; max-width: 1200px; margin: 0 auto; }
    .food-log table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .food-log th, .food-log td { padding: 12px 15px; border: 1px solid #ccc; text-align: center; }
    .food-log th { background-color: #f4f4f4; }
    .food-log tr:nth-child(even) { background-color: #f9f9f9; }
    .food-log tr:hover { background-color: #f1f1f1; }
    .food-log h1 { text-align: center; margin-bottom: 20px; }
    .manual-entry-form {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group label {
        margin-bottom: 5px;
        color: #666;
    }
    .form-input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    .submit-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .submit-btn:hover {
        background-color: #45a049;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .btn-edit {
        background-color: #2196F3;
        color: white;
    }
    .btn-edit:hover {
        background-color: #1976D2;
    }
    .btn-delete {
        background-color: #f44336;
        color: white;
    }
    .btn-delete:hover {
        background-color: #d32f2f;
    }
    .edit-form {
        display: none;
    }
    .edit-form.active {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .edit-input {
        width: 80px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .edit-select {
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>

<div class="food-log">
    <h1>Food Entry</h1>

    <!-- Manual Entry Form -->
    <div class="manual-entry-form">
        <h2 style="margin-bottom: 20px;">Add New Food Entry</h2>
        <form action="{{ route('food.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label for="food_name">Food Name</label>
                    <input type="text" id="food_name" name="food_name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="calories">Calories</label>
                    <input type="number" id="calories" name="calories" class="form-input" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="carbs">Carbs (g)</label>
                    <input type="number" id="carbs" name="carbs" class="form-input" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="fat">Fat (g)</label>
                    <input type="number" id="fat" name="fat" class="form-input" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="protein">Protein (g)</label>
                    <input type="number" id="protein" name="protein" class="form-input" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-input" value="1" min="1" required>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <button type="submit" class="submit-btn">Add Entry</button>
        </form>
    </div>

    @if($foodEntries->isEmpty())
        <p style="text-align:center;">You haven't logged any food yet. Start adding food entries!</p>
    @else
        <table>
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
                                <input type="number" name="calories" class="edit-input" value="{{ $entry->calories }}" step="0.1" required>
                                <input type="number" name="carbs" class="edit-input" value="{{ $entry->carbs }}" step="0.1" required>
                                <input type="number" name="fat" class="edit-input" value="{{ $entry->fat }}" step="0.1" required>
                                <input type="number" name="protein" class="edit-input" value="{{ $entry->protein }}" step="0.1" required>
                                <input type="number" name="quantity" class="edit-input" value="{{ $entry->quantity }}" min="1" required>
                                <input type="date" name="date" class="edit-input" value="{{ $entry->date ? $entry->date->format('Y-m-d') : $entry->created_at->format('Y-m-d') }}" required>
                                <button type="submit" class="btn btn-edit">Save</button>
                                <button type="button" class="btn btn-delete" onclick="toggleEditForm({{ $entry->id }})">Cancel</button>
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
    const row = document.getElementById(`entry-row-${entryId}`);
    const editForm = document.getElementById(`edit-form-${entryId}`);
    const actionButtons = row.querySelector('.action-buttons');
    
    if (editForm.classList.contains('active')) {
        editForm.classList.remove('active');
        actionButtons.style.display = 'flex';
    } else {
        editForm.classList.add('active');
        actionButtons.style.display = 'none';
    }
}
</script>
@endsection

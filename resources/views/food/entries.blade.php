@extends('layouts.app')

@section('title', 'Food Entries')

@section('content')
<style>
    .food-log {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .food-log table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    .food-log th, .food-log td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    .food-log th {
        background-color: #2196F3;
        font-weight: 600;
        color: white;
    }
    .food-log tr:hover {
        background-color: #f8f9fa;
    }
    .food-log h1 {
        text-align: center;
        margin-bottom: 30px;
        color:rgb(0, 0, 0);
        font-weight: 600;
    }
    .food-log h2 {
        color: #1976D2;
        font-weight: 500;
    }
    .manual-entry-form {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        border: 1px solid #e3f2fd;
    }
    .manual-entry-form h2 {
        color:rgb(0, 0, 0);
        font-weight: 500;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e3f2fd;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group.date-group {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        gap: 20px;
        margin-top: 10px;
        grid-column: span 2;
    }
    .form-group.date-group .form-input {
        margin-bottom: 0;
        width: 100%;
        max-width: 200px;
    }
    .form-group.date-group > div {
        flex: 1;
        max-width: 182px;
        padding-right: 15px;
    }
    .form-group label {
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
    }
    .form-input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .form-input:focus {
        border-color: #2196F3;
        box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.1);
        outline: none;
    }
    .submit-btn {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        color: white;
        padding: 12px 38px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        height: 45px;
        white-space: nowrap;
        margin-left: 10px;
        align-self: flex-end;
    }
    .submit-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(33, 150, 243, 0.2);
    }
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: nowrap;
    }
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
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
        background: #f8f9fa;
        padding: 15px;
        border-radius: 6px;
        margin-top: 10px;
    }
    .edit-form.active {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .edit-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #2196F3;
        border-radius: 4px;
        font-size: 14px;
        background-color: white;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }
    .edit-input[type="number"] {
        padding-right: 8px;
        -moz-appearance: textfield;
    }
    .edit-input[type="number"]::-webkit-outer-spin-button,
    .edit-input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .edit-input:focus {
        border-color: #1976D2;
        box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.1);
        outline: none;
    }
    .edit-mode td {
        padding: 8px;
        vertical-align: middle;
    }
    .edit-mode .edit-input {
        width: 100%;
        min-width: 0;
        max-width: 100%;
    }
    .edit-mode .view-mode {
        display: none;
    }
    .edit-mode .edit-input {
        display: inline-block !important;
    }
    .date-cell {
        min-width: 100px;
        white-space: nowrap;
    }
    .date-input {
        width: 130px;
    }
    .no-entries {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        color: #666;
        font-size: 18px;
    }
    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
    }
    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
    }
    .error-text {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .is-invalid:focus {
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.25) !important;
    }
    .meal-category-select {
        padding: 12px;
        border: 1px solid #000;
        border-radius: 6px;
        font-size: 14px;
        background-color: white;
        cursor: pointer;
        color: #333;
        width: 100%;
        min-width: 150px;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px;
        padding-right: 30px;
    }
    .meal-category-select:focus {
        border-color: #000;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
        outline: none;
    }
    .meal-category-select option {
        padding: 12px;
        background-color: white;
        color: #333;
        min-width: 150px;
    }
    .meal-category-select option:hover {
        background-color: #f8f9fa;
    }
    .view-mode {
        display: inline-block;
        padding: 8px;
    }
    .edit-mode .view-mode {
        display: none;
    }
    .edit-mode .edit-input {
        display: inline-block !important;
    }
</style>

<div class="food-log">
    <h1>Food Entries</h1>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <!-- Manual Entry Form -->
    <div class="manual-entry-form">
        <h2>Add New Food Entry</h2>
        <form action="{{ route('food.store') }}" method="POST" id="foodEntryForm">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label for="food_name">Food Name</label>
                    <input type="text" id="food_name" name="food_name" class="form-input @error('food_name') is-invalid @enderror" value="{{ old('food_name') }}" required>
                    @error('food_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="calories">Calories</label>
                    <input type="number" id="calories" name="calories" class="form-input @error('calories') is-invalid @enderror" step="0.1" min="0" value="{{ old('calories') }}" required>
                    @error('calories')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="carbs">Carbs (g)</label>
                    <input type="number" id="carbs" name="carbs" class="form-input @error('carbs') is-invalid @enderror" step="0.1" min="0" value="{{ old('carbs') }}" required>
                    @error('carbs')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fat">Fat (g)</label>
                    <input type="number" id="fat" name="fat" class="form-input @error('fat') is-invalid @enderror" step="0.1" min="0" value="{{ old('fat') }}" required>
                    @error('fat')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="protein">Protein (g)</label>
                    <input type="number" id="protein" name="protein" class="form-input @error('protein') is-invalid @enderror" step="0.1" min="0" value="{{ old('protein') }}" required>
                    @error('protein')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-input @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" min="1" required>
                    @error('quantity')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="portion_size">Portion Size</label>
                    <input type="text" id="portion_size" name="portion_size" class="form-input @error('portion_size') is-invalid @enderror" value="{{ old('portion_size') }}" placeholder="e.g., 1 cup, 100g">
                    @error('portion_size')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="meal_category">Meal Category</label>
                    <select id="meal_category" name="meal_category" class="meal-category-select @error('meal_category') is-invalid @enderror" required>
                        <option value="">Select a meal</option>
                        <option value="breakfast" {{ old('meal_category') == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                        <option value="lunch" {{ old('meal_category') == 'lunch' ? 'selected' : '' }}>Lunch</option>
                        <option value="dinner" {{ old('meal_category') == 'dinner' ? 'selected' : '' }}>Dinner</option>
                    </select>
                    @error('meal_category')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group date-group">
                    <div>
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-input @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                        @error('date')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="submit-btn">Add Entry</button>
                </div>
            </div>
        </form>
    </div>

    @if($foodEntries->isEmpty())
        <div class="no-entries">
            <p>You haven't logged any food yet. Start adding food entries!</p>
        </div>
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
                    <th>Portion Size</th>
                    <th>Meal Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($foodEntries as $entry)
                    <tr id="entry-row-{{ $entry->id }}">
                        <td>
                            <span class="view-mode">{{ $entry->food_name }}</span>
                            <input type="text" name="food_name" class="edit-input" value="{{ $entry->food_name }}" style="display: none;" form="edit-form-{{ $entry->id }}" required>
                        </td>
                        <td>
                            <span class="view-mode">{{ number_format($entry->calories, 1) }}</span>
                            <input type="number" name="calories" class="edit-input" value="{{ $entry->calories }}" step="0.1" min="0" style="display: none;" form="edit-form-{{ $entry->id }}" required>
                        </td>
                        <td>
                            <span class="view-mode">{{ number_format($entry->carbs, 1) }}</span>
                            <input type="number" name="carbs" class="edit-input" value="{{ $entry->carbs }}" step="0.1" min="0" style="display: none;" form="edit-form-{{ $entry->id }}" required>
                        </td>
                        <td>
                            <span class="view-mode">{{ number_format($entry->fat, 1) }}</span>
                            <input type="number" name="fat" class="edit-input" value="{{ $entry->fat }}" step="0.1" min="0" style="display: none;" form="edit-form-{{ $entry->id }}" required>
                        </td>
                        <td>
                            <span class="view-mode">{{ number_format($entry->protein, 1) }}</span>
                            <input type="number" name="protein" class="edit-input" value="{{ $entry->protein }}" step="0.1" min="0" style="display: none;" form="edit-form-{{ $entry->id }}" required>
                        </td>
                        <td>
                            <span class="view-mode">{{ $entry->quantity }}</span>
                            <input type="number" name="quantity" class="edit-input" value="{{ $entry->quantity }}" min="1" style="display: none;" form="edit-form-{{ $entry->id }}" required>
                        </td>
                        <td>
                            <span class="view-mode">{{ $entry->portion_size }}</span>
                            <input type="text" name="portion_size" class="edit-input" value="{{ $entry->portion_size }}" style="display: none;" form="edit-form-{{ $entry->id }}" placeholder="e.g., 1 cup, 100g">
                        </td>
                        <td>
                            <span class="view-mode">{{ ucfirst($entry->meal_category) }}</span>
                            <select name="meal_category" class="edit-input" style="display: none;" form="edit-form-{{ $entry->id }}" required>
                                <option value="breakfast" {{ $entry->meal_category == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                                <option value="lunch" {{ $entry->meal_category == 'lunch' ? 'selected' : '' }}>Lunch</option>
                                <option value="dinner" {{ $entry->meal_category == 'dinner' ? 'selected' : '' }}>Dinner</option>
                            </select>
                        </td>
                        <td class="date-cell">
                            <span class="view-mode">{{ is_string($entry->date) ? \Carbon\Carbon::parse($entry->date)->format('l, F j, Y') : $entry->date->format('l, F j, Y') }}</span>
                            <input type="date" name="date" class="edit-input date-input" value="{{ is_string($entry->date) ? $entry->date : $entry->date->format('Y-m-d') }}" style="display: none;" form="edit-form-{{ $entry->id }}" required>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-edit" onclick="toggleEditMode({{ $entry->id }})">Edit</button>
                                <form action="{{ route('food.remove', $entry->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</button>
                                </form>
                            </div>
                            <form id="edit-form-{{ $entry->id }}" class="edit-form" action="{{ route('food.update', $entry->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PUT')
                                <div class="action-buttons">
                                    <button type="submit" class="btn btn-edit">Save</button>
                                    <button type="button" class="btn btn-delete" onclick="toggleEditMode({{ $entry->id }})">Cancel</button>
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
function toggleEditMode(entryId) {
    // Close any other open edit forms first
    const allRows = document.querySelectorAll('tr[id^="entry-row-"]');
    allRows.forEach(row => {
        if (row.id !== `entry-row-${entryId}` && row.classList.contains('edit-mode')) {
            row.classList.remove('edit-mode');
            const otherEditForm = row.querySelector('.edit-form');
            const otherActionButtons = row.querySelector('.action-buttons');
            if (otherEditForm) otherEditForm.style.display = 'none';
            if (otherActionButtons) otherActionButtons.style.display = 'flex';
        }
    });

    // Toggle the current row
    const row = document.getElementById(`entry-row-${entryId}`);
    const editForm = document.getElementById(`edit-form-${entryId}`);
    const actionButtons = row.querySelector('.action-buttons');
    
    if (row.classList.contains('edit-mode')) {
        row.classList.remove('edit-mode');
        editForm.style.display = 'none';
        actionButtons.style.display = 'flex';
    } else {
        row.classList.add('edit-mode');
        editForm.style.display = 'inline-block';
        actionButtons.style.display = 'none';
    }
}

// Handle form submission
document.getElementById('foodEntryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    try {
        const formData = new FormData(this);
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            // Handle validation errors
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const errorSpan = document.createElement('span');
                        errorSpan.className = 'error-text';
                        errorSpan.textContent = data.errors[field][0];
                        input.parentNode.appendChild(errorSpan);
                    }
                });
            } else {
                alert(data.message || 'Error adding food entry. Please try again.');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error adding food entry. Please try again.');
    }
});

// Clear validation errors on input
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const errorSpan = this.parentNode.querySelector('.error-text');
        if (errorSpan) {
            errorSpan.remove();
        }
    });
});
</script>
@endsection

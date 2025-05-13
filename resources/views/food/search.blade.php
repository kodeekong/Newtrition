@extends('layouts.app')

@section('title', 'Food Search')

@section('content')
<style>
    :root {
        --primary-color: #4a90e2;
        --secondary-color: #f5f6fa;
        --accent-color: #2ecc71;
        --text-primary: #2c3e50;
        --text-secondary: #7f8c8d;
        --border-color: #e0e0e0;
        --hover-color: #3498db;
        --error-color: #e74c3c;
        --success-color: #27ae60;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .search-container {
        background: linear-gradient(135deg, #f6f8fa 0%, #f1f4f8 100%);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .search-form {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .search-input {
        flex: 1;
        padding: 12px 20px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    .filters-container {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .filters-title {
        font-size: 18px;
        color: var(--text-primary);
        margin-bottom: 15px;
        font-weight: 600;
    }

    .filters-grid {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .filter-group {
        flex: 1;
        background: var(--secondary-color);
        padding: 15px;
        border-radius: 8px;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .filter-group h3 {
        margin-bottom: 10px;
        color: var(--text-primary);
        font-size: 16px;
    }

    .checkbox-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        border: 2px solid var(--border-color);
        border-radius: 4px;
        cursor: pointer;
    }

    .range-filter {
        margin-top: 10px;
    }

    .range-inputs {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .range-input {
        width: 65px;
        padding: 6px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 14px;
    }

    .food-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .food-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
    }

    .food-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .food-image-container {
        position: relative;
        padding-top: 75%;
        overflow: hidden;
    }

    .food-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        background-color: #f8f9fa;
    }

    .food-info {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .food-name {
        font-size: 18px;
        color: var(--text-primary);
        margin-bottom: 15px;
        font-weight: 600;
        line-height: 1.4;
    }

    .macro-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .macro-item {
        background: var(--secondary-color);
        padding: 12px;
        border-radius: 8px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .macro-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .macro-label {
        font-size: 14px;
        color: var(--text-secondary);
        margin-bottom: 4px;
    }

    .macro-value {
        font-size: 16px;
        color: var(--text-primary);
        font-weight: 600;
    }

    .add-to-entries-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-top: 10px;
    }
    .add-to-entries-btn:hover {
        background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    }
    .add-to-entries-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .scan-button {
        padding: 12px 24px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .scan-button:hover {
        background-color: var(--hover-color);
    }

    #video-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 1000;
    }

    .close-scanner {
        position: absolute;
        top: 20px;
        right: 20px;
        color: white;
        font-size: 30px;
        cursor: pointer;
        z-index: 1001;
    }

    .barcode-input {
        padding: 12px 20px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 16px;
        width: 200px;
        margin-right: 10px;
    }

    .macro-ranges {
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: transparent;
        padding: 0;
        margin-bottom: 0;
    }

    .range-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 0;
    }

    .range-label {
        width: 85px;
        color: var(--text-secondary);
        font-size: 14px;
    }

    /* Add this new style for equal height filter groups */
    .filter-group > div {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .quantity-container {
        margin: 15px 0;
        display: flex;
        align-items: center;
        background: var(--secondary-color);
        padding: 10px;
        border-radius: 8px;
    }
    .quantity-label {
        margin-right: 10px;
        color: var(--text-primary);
        font-size: 14px;
        font-weight: 500;
    }
    .quantity-input {
        width: 80px;
        padding: 8px 12px;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
        color: var(--text-primary);
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
    }
    .quantity-input:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        outline: none;
    }
    .quantity-input:hover {
        border-color: #999;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        background: white;
        padding: 25px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .modal-title {
        font-size: 20px;
        color: var(--text-primary);
        font-weight: 600;
    }
    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        color: #666;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }
    .modal-form {
        display: grid;
        gap: 15px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .form-group label {
        color: var(--text-secondary);
        font-size: 14px;
        font-weight: 500;
    }
    .form-group input {
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .form-group input:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        outline: none;
    }
    .modal-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    .modal-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .modal-btn-primary {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        color: white;
    }
    .modal-btn-secondary {
        background: #f1f1f1;
        color: #666;
    }
    .modal-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>

<div class="container">
    <div class="search-container">
        <form method="GET" action="{{ route('food.search') }}" class="search-form" id="searchForm">
            <input type="text" name="name" value="{{ request('name') }}" 
                   placeholder="Search for food..." class="search-input">
            <input type="text" name="barcode" placeholder="Enter barcode..." class="barcode-input">
            <button type="submit" class="scan-button">Search</button>
    </form>

        <div class="filters-container">
            <h2 class="filters-title">Filters</h2>
            <div class="filters-grid">
                <div class="filter-group">
                    <h3>Dietary Preferences</h3>
                    <div class="checkbox-list">
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="meat"> Contains Meat
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="vegetarian"> Vegetarian
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="vegan"> Vegan
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="pescetarian"> Pescetarian
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="gluten-free"> Gluten Free
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="halal"> Halal
                        </label>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Nutrition Ranges</h3>
                    <div class="macro-ranges">
                        <div class="range-row">
                            <span class="range-label">Calories:</span>
                            <input type="number" name="calories_min" class="range-input" placeholder="Min" value="{{ request('calories_min') }}">
                            <span>-</span>
                            <input type="number" name="calories_max" class="range-input" placeholder="Max" value="{{ request('calories_max') }}">
                        </div>
                        <div class="range-row">
                            <span class="range-label">Protein:</span>
                            <input type="number" name="protein_min" class="range-input" placeholder="Min" value="{{ request('protein_min') }}">
                            <span>-</span>
                            <input type="number" name="protein_max" class="range-input" placeholder="Max" value="{{ request('protein_max') }}">
                        </div>
                        <div class="range-row">
                            <span class="range-label">Carbs:</span>
                            <input type="number" name="carbs_min" class="range-input" placeholder="Min" value="{{ request('carbs_min') }}">
                            <span>-</span>
                            <input type="number" name="carbs_max" class="range-input" placeholder="Max" value="{{ request('carbs_max') }}">
                        </div>
                        <div class="range-row">
                            <span class="range-label">Fat:</span>
                            <input type="number" name="fat_min" class="range-input" placeholder="Min" value="{{ request('fat_min') }}">
                            <span>-</span>
                            <input type="number" name="fat_max" class="range-input" placeholder="Max" value="{{ request('fat_max') }}">
                        </div>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Goal-Based</h3>
                    <div class="checkbox-list">
                        <label class="checkbox-item">
                            <input type="checkbox" name="goals[]" value="weight-loss"> Weight Loss
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="goals[]" value="muscle-gain"> Muscle Gain
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="goals[]" value="maintenance"> Maintenance
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="goals[]" value="low-carb"> Low Carb
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="goals[]" value="high-protein"> High Protein
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="goals[]" value="balanced"> Balanced Diet
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($foods) && count($foods) > 0)
        <div class="food-grid">
            @foreach($foods as $food)
                <div class="food-card">
                    <div class="food-image-container">
                        <img src="{{ $food['image_url'] ?? 'https://via.placeholder.com/300x200' }}" 
                             alt="{{ $food['product_name'] ?? 'Food Image' }}" 
                             class="food-image">
                    </div>
                    <div class="food-info">
                        <h3 class="food-name">{{ $food['product_name'] ?? 'No Name' }}</h3>
                        <div class="macro-grid">
                            <div class="macro-item">
                                <div class="macro-label">Calories</div>
                                <div class="macro-value">{{ $food['nutriments']['energy-kcal_100g'] ?? 0 }}</div>
                            </div>
                            <div class="macro-item">
                                <div class="macro-label">Protein</div>
                                <div class="macro-value">{{ $food['nutriments']['proteins_100g'] ?? 0 }}g</div>
                            </div>
                            <div class="macro-item">
                                <div class="macro-label">Carbs</div>
                                <div class="macro-value">{{ $food['nutriments']['carbohydrates_100g'] ?? 0 }}g</div>
                            </div>
                            <div class="macro-item">
                                <div class="macro-label">Fat</div>
                                <div class="macro-value">{{ $food['nutriments']['fat_100g'] ?? 0 }}g</div>
                            </div>
                        </div>
                        <form action="{{ route('food.store') }}" method="POST" class="add-to-log-form">
                        @csrf
                        <input type="hidden" name="food_name" value="{{ $food['product_name'] ?? 'Unknown' }}">
                        <input type="hidden" name="calories" value="{{ $food['nutriments']['energy-kcal_100g'] ?? 0 }}">
                        <input type="hidden" name="carbs" value="{{ $food['nutriments']['carbohydrates_100g'] ?? 0 }}">
                        <input type="hidden" name="fat" value="{{ $food['nutriments']['fat_100g'] ?? 0 }}">
                        <input type="hidden" name="protein" value="{{ $food['nutriments']['proteins_100g'] ?? 0 }}">
                            <div class="quantity-container">
                                <label for="quantity" class="quantity-label">Quantity:</label>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       class="quantity-input">
                            </div>
                            <button type="submit" class="add-to-entries-btn">Add to Entries</button>
                    </form>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif(request()->all())
        <p style="text-align:center; color: var(--text-secondary); font-size: 18px; margin-top: 40px;">
            No results found. Try adjusting your search or filters.
        </p>
    @endif
</div>

<!-- Barcode Scanner Container -->
<div id="video-container">
    <span class="close-scanner" onclick="stopScan()">×</span>
    <video id="video" playsinline></video>
</div>

<!-- Add this before the closing body tag -->
<div id="manualEntryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Add Manual Entry</h3>
            <button class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        <form id="manualEntryForm" action="{{ route('food.store') }}" method="POST" class="modal-form">
            @csrf
            <div class="form-group">
                <label for="manual_food_name">Food Name</label>
                <input type="text" id="manual_food_name" name="food_name" required>
            </div>
            <div class="form-group">
                <label for="manual_calories">Calories</label>
                <input type="number" id="manual_calories" name="calories" step="0.1" min="0" required>
            </div>
            <div class="form-group">
                <label for="manual_carbs">Carbs (g)</label>
                <input type="number" id="manual_carbs" name="carbs" step="0.1" min="0" required>
            </div>
            <div class="form-group">
                <label for="manual_fat">Fat (g)</label>
                <input type="number" id="manual_fat" name="fat" step="0.1" min="0" required>
            </div>
            <div class="form-group">
                <label for="manual_protein">Protein (g)</label>
                <input type="number" id="manual_protein" name="protein" step="0.1" min="0" required>
            </div>
            <div class="form-group">
                <label for="manual_quantity">Quantity</label>
                <input type="number" id="manual_quantity" name="quantity" min="1" value="1" required>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="modal-btn modal-btn-primary">Add Entry</button>
                <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
    let selectedDeviceId;
    const codeReader = new ZXing.BrowserMultiFormatReader();

    // Auto-submit form when filters change
    document.querySelectorAll('input[type="checkbox"], input[type="number"]').forEach(input => {
        input.addEventListener('change', () => {
            document.querySelector('form').submit();
        });
    });

    async function startScan() {
        const videoContainer = document.getElementById('video-container');
        const videoElement = document.getElementById('video');
        
        try {
            videoContainer.style.display = 'block';
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            
            if (videoDevices.length > 0) {
                selectedDeviceId = videoDevices[0].deviceId;
                const constraints = {
                    video: { deviceId: selectedDeviceId }
                };
                
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                videoElement.srcObject = stream;
                videoElement.play();

                codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
                    if (result) {
                        const barcodeInput = document.createElement('input');
                        barcodeInput.type = 'hidden';
                        barcodeInput.name = 'barcode';
                        barcodeInput.value = result.text;
                        document.querySelector('form').appendChild(barcodeInput);
                        stopScan();
                        document.querySelector('form').submit();
                    }
                });
            }
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Error accessing camera. Please make sure you have granted camera permissions.');
        }
    }

    function stopScan() {
        const videoContainer = document.getElementById('video-container');
        const videoElement = document.getElementById('video');
        
        codeReader.reset();
        if (videoElement.srcObject) {
            videoElement.srcObject.getTracks().forEach(track => track.stop());
        }
        videoContainer.style.display = 'none';
    }

    // Handle form submission without page reload
    document.querySelectorAll('.add-to-log-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    alert('Food added to log successfully!');
                } else {
                    alert('Error adding food to log. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error adding food to log. Please try again.');
            }
        });
    });

    // Handle filter changes without signing out
    let timeout;
    document.querySelectorAll('input[type="checkbox"], input[type="number"]').forEach(input => {
        input.addEventListener('change', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 500);
        });
    });

    function showModal() {
        document.getElementById('manualEntryModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('manualEntryModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('manualEntryModal');
        if (event.target === modal) {
            closeModal();
        }
    }

    // Handle manual entry form submission
    document.getElementById('manualEntryForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            if (data.success) {
                closeModal();
                alert('Food entry added successfully!');
                // Optionally refresh the page or update the UI
                window.location.reload();
            } else {
                alert('Error adding food entry. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error adding food entry. Please try again.');
        }
    });

    // Add click event to the "Add to Entries" button
    document.querySelectorAll('.add-to-entries-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            showModal();
        });
    });
</script>
@endsection

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
        margin-bottom: 30px;
    }

    .search-input-group {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }

    .search-input {
        flex: 1;
        padding: 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        outline: none;
    }

    .search-btn {
        padding: 15px 30px;
        background: #4a90e2;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-btn:hover {
        background: #357abd;
    }

    .barcode-section {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .barcode-input {
        width: 200px;
        padding: 12px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
    }

    .barcode-btn {
        padding: 12px 25px;
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .barcode-btn:hover {
        background: #e9ecef;
        border-color: #4a90e2;
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
        <form id="searchForm" action="{{ route('food.search') }}" method="GET" class="search-form">
            <div class="search-input-group">
                <input type="text" 
                       name="name" 
                       class="search-input" 
                       placeholder="Search for foods..." 
                       value="{{ request('name') }}"
                       autocomplete="off">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

            <div class="barcode-section">
                <input type="text" 
                       name="barcode" 
                       class="barcode-input" 
                       placeholder="Enter barcode manually" 
                       value="{{ request('barcode') }}">
                <button type="button" class="barcode-btn" onclick="showModal()">
                    <i class="fas fa-barcode"></i> Scan Barcode
                </button>
            </div>
    </form>

        <div class="filters-container">
            <h2 class="filters-title">Filters</h2>
            <div class="filters-grid">
                <div class="filter-group">
                    <h3>Dietary Preferences</h3>
                    <div class="checkbox-list">
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="meat" {{ in_array('meat', request('dietary', [])) ? 'checked' : '' }}> Contains Meat
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="vegetarian" {{ in_array('vegetarian', request('dietary', [])) ? 'checked' : '' }}> Vegetarian
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="vegan" {{ in_array('vegan', request('dietary', [])) ? 'checked' : '' }}> Vegan
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="dietary[]" value="gluten-free" {{ in_array('gluten-free', request('dietary', [])) ? 'checked' : '' }}> Gluten Free
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
            </div>
        </div>
    </div>

    <div class="food-grid">
    @if(isset($foods) && count($foods) > 0)
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
        @else
            <p class="no-results">No results found. Try adjusting your search or filters.</p>
        @endif
    </div>
</div>

<!-- Barcode Scanner Modal -->
<div id="barcodeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Scan Barcode</h2>
        <div id="videoContainer"></div>
        <div id="result"></div>
        </div>
</div>

<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
    let selectedDeviceId;
    const codeReader = new ZXing.BrowserMultiFormatReader();
    let filterTimeout;

    // Handle search form submission
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const params = new URLSearchParams();
        
        for (let [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }

        window.location.href = `${this.action}?${params.toString()}`;
    });

    // Handle filter changes with debounce
    document.querySelectorAll('input[type="checkbox"], input[type="number"]').forEach(input => {
        input.addEventListener('change', () => {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(() => {
                const form = document.getElementById('searchForm');
                const formData = new FormData(form);
                const params = new URLSearchParams();
                
                for (let [key, value] of formData.entries()) {
                    if (value) {
                        params.append(key, value);
                    }
                }

                window.location.href = `${form.action}?${params.toString()}`;
            }, 500);
        });
    });

    // Handle form submissions
    document.querySelectorAll('.add-to-log-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
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
                    alert('Food entry added successfully!');
                    window.location.href = '{{ route("food.entries") }}';
                } else {
                    alert(data.message || 'Error adding food entry. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error adding food entry. Please try again.');
            }
        });
    });

    function showModal() {
        const modal = document.getElementById('barcodeModal');
        const videoContainer = document.getElementById('videoContainer');
        modal.style.display = 'block';
        videoContainer.style.display = 'block';

        codeReader.listVideoInputDevices()
            .then(videoInputDevices => {
                if (videoInputDevices.length > 0) {
                    selectedDeviceId = videoInputDevices[0].deviceId;
                    startScanning();
                } else {
                    document.getElementById('result').textContent = 'No camera found';
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('result').textContent = 'Error accessing camera';
            });
    }

    function closeModal() {
        const modal = document.getElementById('barcodeModal');
        const videoContainer = document.getElementById('videoContainer');
        modal.style.display = 'none';
        videoContainer.style.display = 'none';
        codeReader.reset();
    }

    function startScanning() {
        const videoContainer = document.getElementById('videoContainer');
        codeReader.decodeFromVideoDevice(selectedDeviceId, videoContainer, (result, err) => {
            if (result) {
                document.getElementById('result').textContent = `Barcode: ${result.text}`;
                document.querySelector('input[name="barcode"]').value = result.text;
                codeReader.reset();
                closeModal();
                document.getElementById('searchForm').submit();
            }
            if (err && !(err instanceof ZXing.NotFoundException)) {
                console.error(err);
                document.getElementById('result').textContent = 'Error scanning barcode';
            }
        });
    }
</script>
@endsection

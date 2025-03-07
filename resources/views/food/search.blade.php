@extends('layouts.app')

@section('title', 'Search Food')

@section('content')
<style>
    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
    }

    .card img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .food-item {
        margin-bottom: 20px;
    }

    .filters-container {
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .filter {
        margin: 0;
    }

    .food-item-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: space-around;
    }

    .food-card {
        width: 100%;
        max-width: 250px;
        margin-bottom: 20px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    #scanner {
        width: 100%;
        height: auto;
        border: 1px solid #ccc;
        object-fit: contain;
    }

    #barcode-scanner {
        display: none;
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        background: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        padding: 20px;
    }

    .filters-container {
        justify-content: space-between;
    }

    #barcode-btn {
        display: inline-block;
        margin-left: 15px;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .food-item-container {
            flex-direction: column;
            align-items: center;
        }

        .filters-container {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="container">
    <h1 class="mb-4">Search for Food by Barcode or Name</h1>

    <!-- Search Form at the Top -->
    <form action="{{ route('food.search.results') }}" method="GET" class="mb-4">
        <input type="text" name="name" placeholder="Search by food name" value="{{ request('name') }}" class="form-control form-control-lg mb-3" style="max-width: 500px; margin: 0 auto;">
        <button type="submit" class="btn btn-primary btn-lg btn-block">Search</button>
    </form>

    <!-- Filters: Alphabetical, Calorie Range -->
    <div class="filters-container">
        <form action="{{ route('food.search.results') }}" method="GET" class="mb-4 flex-grow-1">
            <select name="order" class="form-control mb-2 filter">
                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Alphabetical (A-Z)</option>
                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Alphabetical (Z-A)</option>
            </select>
            <select name="calories_range" class="form-control mb-2 filter">
                <option value="">Filter by Calories</option>
                <option value="low" {{ request('calories_range') == 'low' ? 'selected' : '' }}>Low (0-100 kcal)</option>
                <option value="medium" {{ request('calories_range') == 'medium' ? 'selected' : '' }}>Medium (100-500 kcal)</option>
                <option value="high" {{ request('calories_range') == 'high' ? 'selected' : '' }}>High (500+ kcal)</option>
            </select>
            <button type="submit" class="btn btn-secondary">Apply Filters</button>
        </form>

        <!-- Barcode Search Button -->
        <button id="barcode-btn" class="btn btn-info" onclick="openBarcodeScanner()">Search by Barcode</button>
    </div>

    <!-- Display Food List -->
    <div class="food-item-container">
        @if(isset($foods) && !empty($foods))
            @foreach ($foods as $food)
                <div class="food-card card">
                    <img class="card-img-top" src="{{ $food['image_url'] ?? 'https://via.placeholder.com/250' }}" alt="{{ $food['product_name'] ?? 'Food Image' }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $food['product_name'] ?? 'No name available' }}</h5>
                        <p class="card-text">Calories: {{ $food['nutriments']['energy-kcal'] ?? 'N/A' }} kcal</p>
                        <p class="card-text">Protein: {{ $food['nutriments']['proteins'] ?? 'N/A' }}g</p>
                        <p class="card-text">Carbs: {{ $food['nutriments']['carbohydrates'] ?? 'N/A' }}g</p>
                        <p class="card-text">Fat: {{ $food['nutriments']['fat'] ?? 'N/A' }}g</p>
                    </div>
                </div>
            @endforeach
        @else
            <p>No foods found. Try a different search.</p>
        @endif
    </div>

    <!-- Scanned Product Info (Modal) -->
    <div id="barcode-scanner">
        <video id="scanner"></video>
        <button class="btn btn-danger" onclick="closeBarcodeScanner()">Close Scanner</button>
    </div>
</div>

<script>
    // Barcode Scanner Initialization
    function openBarcodeScanner() {
        document.getElementById('barcode-scanner').style.display = 'block';
        startCamera();

        // Initialize Quagga scanner
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner'),
            },
            decoder: {
                readers: ["ean_reader", "upc_reader"] // Barcode types to scan
            }
        }, function(err) {
            if (err) {
                console.log(err);
                return;
            }
            Quagga.start();
        });

        // Handle barcode detection
        Quagga.onDetected(function(result) {
            const barcode = result.codeResult.code;
            console.log("Barcode Detected: " + barcode);

            fetch(`/food/barcode/${barcode}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.product_name) {
                        alert(`Product found: ${data.product_name}`);
                        closeBarcodeScanner();
                    } else {
                        alert('Product not found.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching product data:', error);
                    closeBarcodeScanner();
                });
        });
    }

    // Stop camera and close the barcode scanner
    function closeBarcodeScanner() {
        document.getElementById('barcode-scanner').style.display = 'none';
        Quagga.stop(); // Stop the barcode scanner
    }

    // Function to start the camera feed
    function startCamera() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then(function(stream) {
                var videoElement = document.getElementById('scanner');
                videoElement.srcObject = stream;
                videoElement.play();
            })
            .catch(function(error) {
                console.log("Error accessing camera: ", error);
            });
    }
</script>

@endsection

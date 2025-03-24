@extends('layouts.app')

@section('title', 'Food Search')

@section('content')

<style>
    .food-search {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .food-search form {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .food-search input {
        width: 300px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }

    .food-search button {
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #4CAF50;
        color: white;
        border: none;
    }

    .filter-options {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
        gap: 15px;
    }

    .food-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Adjust grid for responsiveness */
        gap: 20px;
        margin-top: 20px;
    }

    .food-item {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .food-item img {
        max-width: 100%;
        max-height: 150px;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .food-item h4 {
        margin-bottom: 10px;
        font-size: 1.2rem;
    }

    .food-item p {
        font-size: 14px;
        color: #555;
        margin-bottom: 15px;
    }

    .food-item button {
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #2196F3;
        color: white;
        border: none;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .food-list {
            grid-template-columns: 1fr;  /* Stacks the items vertically on smaller screens */
        }
    }
</style>

<div class="food-search">
    <h1>Food Search</h1>

    <!-- Food Search Form -->
    <form method="GET" action="{{ route('food.search.results') }}">
        <input type="text" name="name" placeholder="Search food...">
        <button type="submit">Search</button>
    </form>

    <!-- Filters Section -->
    <div class="filter-options">
        <form method="GET" action="{{ route('food.search.results') }}">
            <input type="text" name="category" placeholder="Category">
            <button type="submit">Filter by Category</button>
        </form>
        <form method="GET" action="{{ route('food.search.results') }}">
            <input type="text" name="barcode" placeholder="Barcode">
            <button type="submit">Filter by Barcode</button>
        </form>
    </div>

    <!-- Display search results (if any) -->
    @if(isset($foods) && count($foods) > 0)
    <div class="food-list">
        <h3>Search Results</h3>
        @foreach($foods as $food)
        <div class="food-item">
            <img src="{{ $food['image_url'] ?? 'default-image.jpg' }}" alt="{{ $food['product_name'] }}">
            <h4>{{ $food['product_name'] }}</h4>
            <p>{{ $food['ingredients_text'] ?? 'Ingredients information not available' }}</p>
            <form method="POST" action="{{ route('food.add', $food['id']) }}">
                @csrf
                <button type="submit">Add to Profile</button>
            </form>
        </div>
        @endforeach
    </div>
    @else
    <p>No results found. Try searching for another food item.</p>
    @endif
</div>

@endsection

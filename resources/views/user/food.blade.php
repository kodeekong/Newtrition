@extends('layouts.app')

@section('title', 'Search Food')

@section('content')
    <div class="container">
        <h1>Search for Food</h1>

        <!-- Search Bar (for Dashboard or other areas) -->
        <form action="{{ route('food.search.results') }}" method="GET">
            <input type="text" name="name" placeholder="Search by food name" value="{{ request('name') }}">
            <button type="submit">Search</button>
        </form>

        <br>

        <!-- Search Form for Food -->
        <form action="{{ route('food.search.results') }}" method="GET">
            <input type="text" name="name" placeholder="Search by food name" value="{{ request('name') }}">
            <button type="submit">Search</button>
        </form>

        <!-- Open Food Facts Search Form -->
        <form action="{{ route('food.search.openFoodFacts') }}" method="GET">
            <input type="text" name="name" placeholder="Search Open Food Facts" value="{{ request('name') }}">
            <button type="submit">Search Open Food Facts</button>
        </form>

        <hr>

        <!-- Display Food List (if any results are returned) -->
        @if(!empty($foods))
            <ul>
                @foreach ($foods as $food)
                    <li>
                        <p>{{ $food['product_name'] ?? 'No name available' }}</p>
                        <p>Calories: {{ $food['nutriments']['energy-kcal'] ?? 'N/A' }} kcal</p>
                        <p>Protein: {{ $food['nutriments']['proteins'] ?? 'N/A' }}g</p>
                        <p>Carbs: {{ $food['nutriments']['carbohydrates'] ?? 'N/A' }}g</p>
                        <p>Fat: {{ $food['nutriments']['fat'] ?? 'N/A' }}g</p>

                        <!-- Add Food to Entries -->
                        <form action="{{ route('food.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="food_id" value="{{ $food['id'] }}">
                            <input type="number" name="quantity" placeholder="Quantity" required>
                            <select name="portion_size" required>
                                <option value="small">Small</option>
                                <option value="medium" selected>Medium</option>
                                <option value="large">Large</option>
                            </select>
                            <input type="date" name="date" value="{{ now()->toDateString() }}" required>
                            <button type="submit">Add to My Entries</button>
                        </form>

                        <!-- Link to Add to Database -->
                        <a href="{{ route('food.add.openFood', $food['id']) }}">Add to Database</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No foods found.</p>
        @endif
    </div>
@endsection

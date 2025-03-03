@extends('layouts.app')

@section('title', 'Search Food')

@section('content')
    <div class="container">
        <h1>Search for Food</h1>

        <!-- Search Bar -->
        <form action="{{ route('food.search.results') }}" method="GET">
            <input type="text" name="name" placeholder="Search by food name" value="{{ request('name') }}">
            <button type="submit">Search</button>
        </form>

        <br>

        <!-- Display Food List (if any results are returned) -->
        @if($foods->isNotEmpty())
            <ul>
                @foreach ($foods as $food)
                    <li>
                        <p>{{ $food->name }}</p>
                        <p>Calories: {{ $food->calories }} kcal</p>
                        <p>Protein: {{ $food->protein }}g</p>
                        <p>Carbs: {{ $food->carbohydrates }}g</p>
                        <p>Fat: {{ $food->fat }}g</p>

                        <!-- Add Food to Entries -->
                        <form action="{{ route('food.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="food_id" value="{{ $food->id }}">
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
                        <a href="{{ route('food.add.openFood', $food->id) }}">Add to Database</a>
                    </li>
                @endforeach
            </ul>

            <!-- Pagination Links -->
            <div class="pagination">
                {{ $foods->links() }}
            </div>
        @else
            <p>No foods found.</p>
        @endif
    </div>
@endsection

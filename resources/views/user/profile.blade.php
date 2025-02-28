@extends('layouts.app')

@section('content')
    <h2>Edit your information here</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form>
        <p><strong>Activity Level:</strong> {{ $profile->activity_level }}</p>
        <p><strong>Goal:</strong> {{ $profile->goal }}</p>
        <p><strong>Weight:</strong> {{ $profile->weight }} lb</p>
        <p><strong>Height:</strong> {{ intdiv($profile->height_inch, 12) }}' {{ $profile->height_inch % 12 }}"</p>
        <p><strong>Gender:</strong> {{ $profile->gender }}</p>
        <p><strong>Age:</strong> {{ $profile->age }}</p>

        <a href="{{ route('personal') }}">
            <button type="button">Edit Profile</button>
        </a>
        <a href="{{ route('home') }}">
            <button type="button">Sign Out</button>
        </a>
    </form>
@endsection

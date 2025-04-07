@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="dashboard">
        <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
        <p>Here you can see your profile information, daily calorie needs, and more.</p>

        <!-- Profile Information Section -->
        <div class="profile-info">
            <h3>Profile Information</h3>
            <p><strong>Age:</strong> {{ $profile->age }}</p>
            <p><strong>Weight:</strong> {{ $profile->weight }} lb</p>
            <p><strong>Height:</strong> {{ intdiv($profile->height_inch, 12) }}' {{ $profile->height_inch % 12 }}"</p>
            <p><strong>Gender:</strong> {{ $profile->gender }}</p>
            <p><strong>Activity Level:</strong> {{ $profile->activity_level }}</p>
            <p><strong>Goal:</strong> {{ $profile->goal }}</p>
        </div>

    </div>

@endsection

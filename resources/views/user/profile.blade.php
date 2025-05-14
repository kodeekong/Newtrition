@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh; 
        overflow: hidden; 
    }

    .dashboard {
        width: 90%;
        max-width: 1000px;
        margin: auto;
        padding: 20px; 
        background-color: var(--card-background);
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
        text-align: center;
        height: 100%; 
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dashboard h1 {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 15px; 
    }

    .dashboard p {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    .profile-info {
        margin-top: 20px; 
        background-color: var(--card-background);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        text-align: left;
        overflow: auto; 
        max-height: 60%; 
        position: relative; 
    }

    .profile-info h3 {
        color: var(--primary-color);
        margin-bottom: 15px; 
        font-size: 1.4rem;
    }

    .profile-info p {
        font-size: 1rem;
        margin: 10px 0; 
        color: var(--text-primary);
    }

    .profile-info strong {
        color: var(--text-primary);
    }

    .dashboard-button {
        position: absolute; 
        bottom: 20px;
        right: 20px; 
        padding: 10px 20px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        font-size: 1rem;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .dashboard-button:hover {
        background-color: var(--primary-hover);
    }

    /* Dark mode specific styles */
    body.dark-mode .dashboard {
        background-color: var(--card-background);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    body.dark-mode .profile-info {
        background-color: var(--card-background);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    body.dark-mode .dashboard h1,
    body.dark-mode .profile-info h3 {
        color: var(--primary-color);
    }

    body.dark-mode .dashboard p,
    body.dark-mode .profile-info p,
    body.dark-mode .profile-info strong {
        color: var(--text-primary);
    }

    body.dark-mode .dashboard-button {
        background-color: var(--primary-color);
    }

    body.dark-mode .dashboard-button:hover {
        background-color: var(--primary-hover);
    }
</style>

<div class="dashboard">
    <h1>Welcome to Your Profile, {{ Auth::user()->username }}!</h1>
    <p>Here you can see your profile information, daily calorie needs, and more..</p>

    <div class="profile-info">
        <h3>Profile Information</h3>
        <p><strong>Age:</strong> {{ ucwords($profile->age) }}</p>
        <p><strong>Weight:</strong> {{ ucwords($profile->weight) }} lb</p>
        <p><strong>Height:</strong> {{ ucwords(intdiv($profile->height_inch, 12) . "' " . $profile->height_inch % 12 . '"') }}</p>
        <p><strong>Gender:</strong> {{ ucwords($profile->gender) }}</p>
        <p><strong>Activity Level:</strong> {{ ucwords(str_replace('_', ' ', $profile->activity_level)) }}</p>
        <p><strong>Goal:</strong> {{ ucwords(str_replace('_', ' ', $profile->goal)) }}</p>

        <a href="{{ route('dashboard') }}" class="dashboard-button">See Your Dashboard</a>
        <a href="{{ route('edit.profile') }}" class="dashboard-button" style="right: 230px;">Edit Profile</a>
    </div>
</div>
@endsection
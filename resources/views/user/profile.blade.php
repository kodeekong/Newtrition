@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #eef3f8;
        margin: 0;
        padding: 0;
        height: 100vh; /* Set the body height to the full viewport height */
        overflow: hidden; /* Prevent scrolling */
    }

    .dashboard {
        width: 90%;
        max-width: 1000px;
        margin: auto;
        padding: 20px; /* Reduce padding to save space */
        background-color: #f8fbff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
        text-align: center;
        height: 100%; /* Make the dashboard take up the full height */
        display: flex;
        flex-direction: column;
        justify-content: center; /* Center content vertically */
    }

    .dashboard h1 {
        font-size: 2rem; /* Increase font size */
        color: #2c3e50;
        margin-bottom: 15px; /* Add more spacing below the heading */
    }

    .dashboard p {
        color: #555;
        font-size: 1.1rem; /* Increase font size */
    }

    .profile-info {
    margin-top: 20px; /* Reduce margin */
    background-color: #ffffff;
    padding: 25px; /* Increase padding for better spacing */
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    text-align: left;
    overflow: auto; /* Allow scrolling within the profile-info box if needed */
    max-height: 60%; /* Limit the height of the profile-info box */
    position: relative; /* Set relative positioning for the container */
}

    .profile-info h3 {
        color: #4195be;
        margin-bottom: 15px; /* Add more spacing below the heading */
        font-size: 1.4rem; /* Increase font size */
    }

    .profile-info p {
        font-size: 1rem; /* Increase font size */
        margin: 10px 0; /* Add more spacing between paragraphs */
        color: #34495e;
    }

    .profile-info strong {
        color: #2c3e50;
    }

    .dashboard-button {
    position: absolute; /* Position the button relative to the container */
    bottom: 20px; /* Place it 20px from the bottom */
    right: 20px; /* Place it 20px from the right */
    padding: 10px 20px; /* Increase padding for a larger button */
    background-color: #4195be;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none; /* Remove underline from the link */
    font-size: 1rem; /* Increase font size */
    font-weight: bold;
    transition: background-color 0.3s ease; /* Smooth hover effect */
}

.dashboard-button:hover {
    background-color: #317a9e; /* Darker shade on hover */
}
</style>

<div class="dashboard">
    <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
    <p>Here you can see your profile information, daily calorie needs, and more.</p>

    <div class="profile-info">
        <h3>Profile Information</h3>
        <p><strong>Age:</strong> {{ ucwords($profile->age) }}</p>
        <p><strong>Weight:</strong> {{ ucwords($profile->weight) }} lb</p>
        <p><strong>Height:</strong> {{ ucwords(intdiv($profile->height_inch, 12) . "' " . $profile->height_inch % 12 . '"') }}</p>
        <p><strong>Gender:</strong> {{ ucwords($profile->gender) }}</p>
        <p><strong>Activity Level:</strong> {{ ucwords($profile->activity_level) }}</p>
        <p><strong>Goal:</strong> {{ ucwords(str_replace('_', ' ', $profile->goal)) }}</p>

        <a href="{{ route('dashboard') }}" class="dashboard-button">See Your Dashboard</a>
    </div>
</div>

@endsection
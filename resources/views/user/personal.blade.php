@extends('layouts.app')

@section('content')
    
    <h2>Your information</h2>
    <form action="/submit" method="POST">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>

        <label for="weight">Weight (lb):</label>
        <input type="number" id="weight" name="weight" min="20" max="300" required>

        <label for="height">Height (inch):</label>
        <input type="number" id="height" name="height" min="100" max="250" required>

        <label for="activity">Activity Level:</label>
        <select id="activity" name="activity" required>
            <option value="">Select Activity Level</option>
            <option value="very_active">Very Active</option>
            <option value="moderately_active">Moderately Active</option>
            <option value="lightly_active">Lightly Active</option>
        </select>

        <button type="submit">Submit</button>
    </form>

@endsection
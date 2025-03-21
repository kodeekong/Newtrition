@extends('layouts.app')

@section('content')
    <h2>Your information</h2>
    <form action="{{ route('personal') }}" method="POST">
        @csrf  
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" min="14" max="100" required>

        <label for="weight">Weight (lb):</label>
        <input type="number" id="weight" name="weight" min="50" max="300" required>

        <label for="height">Height (inch):</label>
        <input type="number" id="height" name="heigh" min="0" max="90" required>

        <label for="activity">Activity Level:</label>
        <select id="activity_level" name="activity_level" required>
            <option value="">Select Activity Level</option>
            <option value="very_active">Very Active</option>
            <option value="moderately_active">Moderately Active</option>
            <option value="lightly_active">Lightly Active</option>
        </select>

        <button type="submit">Submit</button>
    </form>
@endsection

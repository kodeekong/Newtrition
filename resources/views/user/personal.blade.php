@extends('layouts.app')

@section('content')
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
    <input type="number" id="height" name="height" min="0" max="90" required>

    <label for="activity">Activity Level:</label>
    <select id="activity_level" name="activity_level" required>
        <option value="">Select Activity Level</option>
        <option value="very_active">Very Active</option>
        <option value="moderate">Moderately Active</option>
        <option value="light">Lightly Active</option>
    </select>

    <!-- Add weight goal -->
    <label for="goal">Weight Goal:</label>
    <select id="goal" name="goal" required>
        <option value="">Select Weight Goal</option>
        <option value="gain_weight">Gain Weight</option>
        <option value="maintain_weight">Maintain Weight</option>
        <option value="lose_weight">Lose Weight</option>
    </select>

    <button type="submit">Submit</button>
</form>

@endsection

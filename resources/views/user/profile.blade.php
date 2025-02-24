@extends('layouts.app')

@section('content')
    <h2>Your Profile Information</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('POST')

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="{{ old('age', $profile->age) }}" min="14" max="100" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male" {{ $profile->gender == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ $profile->gender == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ $profile->gender == 'other' ? 'selected' : '' }}>Other</option>
        </select>

        <label for="weight">Weight (lb):</label>
        <input type="number" id="weight" name="weight" value="{{ old('weight', $profile->weight) }}" min="3" max="1000" required>

        <label for="height_ft">Height (ft):</label>
        <input type="number" id="height_ft" name="height_ft" value="{{ old('height_ft', $profile->height_ft) }}" min="0" max="10" required>

        <label for="height_inch">Height (inch):</label>
        <input type="number" id="height_inch" name="height_inch" value="{{ old('height_inch', $profile->height_inch) }}" min="0" max="11" required>

        <label for="activity_level">Activity Level:</label>
        <select id="activity_level" name="activity_level" required>
            <option value="light" {{ $profile->activity_level == 'light' ? 'selected' : '' }}>Light</option>
            <option value="moderate" {{ $profile->activity_level == 'moderate' ? 'selected' : '' }}>Moderate</option>
            <option value="very_active" {{ $profile->activity_level == 'very_active' ? 'selected' : '' }}>Very Active</option>
        </select>

        <button type="submit">Update Profile</button>
    </form>
@endsection

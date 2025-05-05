@extends('layouts.app')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f8fb;
        margin: 0;
        padding: 0;
    }

    form {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        text-align: center;
        color: #2c3e50;
        font-size: 28px;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        margin: 10px 0 5px;
        display: block;
        color: #34495e;
        font-size: 16px;
    }

    select, input {
        width: 100%;
        padding: 12px;
        margin: 10px 0 20px;
        border-radius: 8px;
        border: 1px solid #d1d9e6;
        font-size: 16px;
        color: #34495e;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    select:focus, input:focus {
        border-color: #4195be;
        box-shadow: 0 0 8px rgba(65, 149, 190, 0.3);
        outline: none;
    }

    button {
        width: 100%;
        padding: 15px;
        background-color: #4195be;
        color: white;
        font-size: 18px;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button:hover {
        background-color: #357f9f;
        transform: scale(1.02);
    }

    button:active {
        transform: scale(0.98);
    }

    .tooltip {
        position: relative;
        display: inline-block;
        cursor: pointer;
        color: #4195be;
        font-weight: bold;
        font-size: 18px;
        margin-left: 5px;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 220px;
        background-color: rgba(255, 255, 255, 0.9);
        color: #333;
        text-align: center;
        border-radius: 5px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -110px;
        opacity: 0;
        transition: opacity 0.3s;
        border: 1px solid #d1d9e6;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    @media screen and (max-width: 768px) {
        form {
            padding: 20px;
        }

        select, input, button {
            font-size: 14px;
        }
    }
</style>

@section('content')
    <h2>Your Information</h2>
    <form action="{{ route('profile.submit') }}" method="POST">
    @csrf

    <label>Age:</label>
    <input type="number" name="age" value="{{ old('age', $profile->age ?? '') }}" required>

    <label>Gender:</label>
    <select name="gender" required>
        <option value="male" {{ (old('gender', $profile->gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
        <option value="female" {{ (old('gender', $profile->gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
    </select>

    <label>Weight (kg):</label>
    <input type="number" name="weight" value="{{ old('weight', $profile->weight ?? '') }}" required>

    <label>Height (inches):</label>
    <input type="number" name="height" value="{{ old('height', $profile->height_inch ?? '') }}" required>

    <label>Activity Level:</label>
    <select name="activity_level" required>
        <option value="light" {{ (old('activity_level', $profile->activity_level ?? '') == 'light') ? 'selected' : '' }}>Light</option>
        <option value="moderate" {{ (old('activity_level', $profile->activity_level ?? '') == 'moderate') ? 'selected' : '' }}>Moderate</option>
        <option value="very_active" {{ (old('activity_level', $profile->activity_level ?? '') == 'very_active') ? 'selected' : '' }}>Very Active</option>
    </select>

    <label>Goal:</label>
    <select name="goal" required>
        <option value="gain_weight" {{ (old('goal', $profile->goal ?? '') == 'gain_weight') ? 'selected' : '' }}>Gain Weight</option>
        <option value="maintain_weight" {{ (old('goal', $profile->goal ?? '') == 'maintain_weight') ? 'selected' : '' }}>Maintain Weight</option>
        <option value="lose_weight" {{ (old('goal', $profile->goal ?? '') == 'lose_weight') ? 'selected' : '' }}>Lose Weight</option>
    </select>

    <button type="submit">Save Profile</button>
</form>

@endsection
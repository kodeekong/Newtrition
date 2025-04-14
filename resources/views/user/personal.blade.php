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
            <option value="light">Light</option>
            <option value="moderate">Moderate</option>
            <option value="very_active">Very Active</option>
            <option value="moderately_active">Moderately Active</option>
            <option value="lightly_active">Lightly Active</option>
        </select>

        <label for="goal">Goal:</label>
        <select id="goal" name="goal" required>
            <option value="">Select Goal</option>
            <option value="gain_weight">Gain Weight</option>
            <option value="maintain_weight">Maintain Weight</option>
            <option value="lose_weight">Lose Weight</option>
        </select>

        <button type="submit">Submit</button>
    </form>
@endsection
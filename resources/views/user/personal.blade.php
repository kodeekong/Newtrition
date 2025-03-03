@extends('layouts.app')
<style>
    /* General form styling */
form {
    max-width: 600px; /* Adjusted max width */
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    font-family: 'Poppins', sans-serif; /* Comic-inspired, professional font */
}

/* Heading styling */
h2 {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Aligning labels with inputs */
label {
    font-weight: bold;
    margin: 10px 0 5px;
    display: block; /* Makes sure the label is above the input */
    color: #333;
    font-size: 16px;
}

/* Styling for form fields */
select, input {
    width: 100%; /* Full width for input and select fields */
    max-width: 250px; /* Smaller width for age, height, weight */
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px; /* Rounded corners */
    border: 2px solid #333; /* Black outline */
    color: #333; /* Black text */
    font-size: 16px;
    box-sizing: border-box; /* Ensures padding doesn’t break layout */
    transition: all 0.3s ease;
}

/* Focus effect for inputs */
select:focus, input:focus {
    border-color: #4195be; /* Blue outline when focused */
    box-shadow: 0 0 8px rgba(65, 149, 190, 0.7); /* Subtle blue glow */
    outline: none;
}

/* Button styling */
button {
    width: 100%;
    max-width: 300px; /* Button size adjusted */
    padding: 12px;
    background-color: #4195be; /* Blue button color */
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
    box-sizing: border-box;
}

button:hover {
    background-color: #357f9f; /* Darker blue on hover */
}

/* Tooltip styling for the clickable question mark */
.tooltip {
    position: relative;
    display: inline-block;
    cursor: pointer;
    color: #4195be; /* Blue color for the question mark */
    font-weight: bold;
    font-size: 18px;
    margin-left: 5px;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 220px;
    background-color: rgba(255, 255, 255, 0.9); /* White background with slight transparency */
    color: #333;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Position the tooltip above the element */
    left: 50%;
    margin-left: -110px; /* Offset the tooltip */
    opacity: 0;
    transition: opacity 0.3s;
    border: 2px solid #333; /* Black outline */
}

.tooltip:focus .tooltiptext,
.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

/* Adjusting form layout for mobile responsiveness */
@media screen and (max-width: 768px) {
    form {
        padding: 15px;
    }

    select, input, button {
        font-size: 14px;
    }

    /* Stack inputs vertically on small screens */
    .form-group {
        display: flex;
        flex-direction: column; /* Stack vertically */
        gap: 15px;
    }
}

/* Styling for the form's inputs container */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 15px;
    justify-content: space-between;
}

/* Styling when input boxes are next to each other (Horizontal alignment) */
.horizontal-form .form-group {
    flex-direction: row; /* Align fields horizontally */
    gap: 20px;
    align-items: flex-start;
}

/* Adjust for smaller screen sizes with horizontal form */
@media screen and (max-width: 768px) {
    .horizontal-form .form-group {
        flex-direction: column; /* Switch to vertical on smaller screens */
    }
}

</style>
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
        <input type="number" id="height" name="height" min="0" max="90" required>

        <label for="activity">Activity Level:</label>
        <select id="activity_level" name="activity_level" required>
            <option value="">Select Activity Level</option>
            <option value="light">Light</option>
            <option value="moderate">Moderate</option>
            <option value="very_active">Very Active</option>
        </select>

        <label for="goal">Goal:</label>
        <select id="goal" name="goal" required>
            <option value="gain_weight">Gain weight</option>
            <option value="maintain_weight">Maintain weight</option>
            <option value="lose_weight">Lose weight</option>
        </select>

        <button type="submit">Submit</button>

    </form>

@endsection
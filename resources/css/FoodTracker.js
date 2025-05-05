document.getElementById("foodForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let totalCalories = 0;
    const calorieFields = ["breakfastCalories", "lunchCalories", "dinnerCalories", "snacksCalories"];

    for (const field of calorieFields) {
        const value = document.forms["foodForm"][field].value;
        if (value !== "") {
            const num = parseInt(value, 10);
            if (isNaN(num) || num < 0) {
                alert("Please enter a valid (non-negative) number for all calories.");
                return;
            }
            totalCalories += num;
        }
    }

    document.getElementById("totalCalories").textContent = totalCalories;
});
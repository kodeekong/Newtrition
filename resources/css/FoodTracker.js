document.addEventListener("DOMContentLoaded", function() {
    const foodForm = document.getElementById("foodForm");
    if (!foodForm) {
        console.warn("Food form not found on page");
        return;
    }

    foodForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let totalCalories = 0;
        const calorieFields = ["breakfastCalories", "lunchCalories", "dinnerCalories", "snacksCalories"];

        try {
            for (const field of calorieFields) {
                const input = document.forms["foodForm"]?.[field];
                if (!input) continue;
                
                const value = input.value;
                if (value !== "") {
                    const num = parseInt(value, 10);
                    if (isNaN(num) || num < 0) {
                        alert("Please enter a valid (non-negative) number for all calories.");
                        return;
                    }
                    totalCalories += num;
                }
            }

            const totalCaloriesElement = document.getElementById("totalCalories");
            if (totalCaloriesElement) {
                totalCaloriesElement.textContent = totalCalories;
            }
        } catch (error) {
            console.error("Error calculating calories:", error);
            alert("An error occurred while calculating calories. Please try again.");
        }
    });
});
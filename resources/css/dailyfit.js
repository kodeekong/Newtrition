// Save Data to Local Storage
function saveData() {
    const data = {
        date: document.getElementById("date").value,
        goals: document.getElementById("goals").value,
        workout1: {
            exercise: document.getElementById("exercise1").value,
            time: document.getElementById("time1").value,
            reps: document.getElementById("reps1").value,
        },
        workout2: {
            exercise: document.getElementById("exercise2").value,
            time: document.getElementById("time2").value,
            reps: document.getElementById("reps2").value,
        },
        breakfast: document.getElementById("breakfast").value,
        lunch: document.getElementById("lunch").value,
        dinner: document.getElementById("dinner").value,
        snacks: document.getElementById("snacks").value
    };

    // Save to localStorage
    localStorage.setItem("dailySummary", JSON.stringify(data));

    alert("Daily summary saved successfully!");
}
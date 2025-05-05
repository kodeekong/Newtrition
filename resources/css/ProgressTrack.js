function saveProgress() {
    if (!validateInputs()) {
        alert("Please enter valid values (no negative numbers).");
        return;
    }

    const progressData = {
        affirmations: document.getElementById("affirmations").value,
        progress: {
            weight: getValue("weight", 7),
            time: getValue("time", 7),
            reps: getValue("reps", 7),
        }
    };

    localStorage.setItem("progressData", JSON.stringify(progressData));
    alert("Progress Saved!");
}

// Validate inputs to ensure no negatives
function validateInputs() {
    const metrics = ["weight", "time", "reps"];
    for (let metric of metrics) {
        for (let i = 1; i <= 7; i++) {
            const value = document.getElementById(`${metric}${i}`).value;
            if (value !== "" && parseInt(value) < 0) {
                return false;
            }
        }
    }
    return true;
}

// Get multiple input values by ID
function getValue(metric, count) {
    let values = [];
    for (let i = 1; i <= count; i++) {
        values.push(document.getElementById(`${metric}${i}`).value || 0);
    }
    return values;
}

// Load Progress Data when page loads
document.addEventListener("DOMContentLoaded", () => {
    const data = JSON.parse(localStorage.getItem("progressData"));
    if (data) {
        document.getElementById("affirmations").value = data.affirmations || "";

        setValues("weight", data.progress.weight);
        setValues("time", data.progress.time);
        setValues("reps", data.progress.reps);
    }
});

// Set multiple values by ID
function setValues(metric, values) {
    values.forEach((val, index) => {
        document.getElementById(`${metric}${index + 1}`).value = val || 0;
    });
}
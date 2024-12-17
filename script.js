let dataset = [];

// Load the CSV file
function loadDataset() {
    Papa.parse("symptoms_diseases_dataset_200_with_prescription.csv", {
        download: true,
        header: true,
        complete: function (results) {
            dataset = results.data; // Store parsed data in dataset array
        },
        error: function (error) {
            console.error("Error loading CSV:", error);
        }
    });
}

// Call loadDataset to parse and load data at the beginning
loadDataset();

function predictDisease() {
    const symptom1 = document.getElementById("symptom1").value.trim().toLowerCase();
    const symptom2 = document.getElementById("symptom2").value.trim().toLowerCase();
    const symptom3 = document.getElementById("symptom3").value.trim().toLowerCase();

    if (!symptom1 && !symptom2 && !symptom3) {
        alert("Please enter at least one symptom.");
        return;
    }

    // Step 1: Try to find an exact match for all three symptoms
    let result = dataset.find(entry =>
        entry.Symptom1.toLowerCase() === symptom1 &&
        entry.Symptom2.toLowerCase() === symptom2 &&
        entry.Symptom3.toLowerCase() === symptom3
    );

    // Step 2: If no exact match, search for a match based on Symptom1 only
    if (!result) {
        result = dataset.find(entry => entry.Symptom1.toLowerCase() === symptom1);
    }

    // Step 3: If no exact match, search for a partial match on Symptom1
    if (!result) {
        result = dataset.find(entry => entry.Symptom1.toLowerCase().includes(symptom1));
    }

    // Display results
    if (result) {
        document.getElementById("disease").textContent = `Disease: ${result.Disease}`;
        document.getElementById("diet").textContent = `Diet: ${result.Diet}`;
        document.getElementById("prescription").textContent = `Prescription: ${result.Prescription}`;
        document.getElementById("safetyMeasures").textContent = 
            `Safety Measures: ${result["Safety Measures"]}`; // Updated to match CSV key
        document.getElementById("dosageMessage").textContent = 
            "PLEASE ENSURE THAT ALL MEDICATIONS ARE TAKEN STRICTLY ACCORDING TO THE PRESCRIBED DOSAGE AND INSTRUCTIONS PROVIDED BY YOUR DOCTOR.";
    } else {
        document.getElementById("disease").textContent = "Disease: No match found";
        document.getElementById("diet").textContent = "Diet: N/A";
        document.getElementById("prescription").textContent = "Prescription: N/A";
        document.getElementById("safetyMeasures").textContent = "Safety Measures: N/A";
        document.getElementById("dosageMessage").textContent = ""; // Clear dosage message if no match
    }
}

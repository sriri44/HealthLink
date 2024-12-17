<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'logindetails'); // Replace 'healthcare' with your database name

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection Failed: " . $conn->connect_error]));
}

// Fetch form data
$fullName = $_POST['fullName'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$contactNumber = $_POST['contactNumber'];
$email = $_POST['email'];
$emergencyContact = $_POST['emergencyContact'];
$address = $_POST['address'];

$chronicConditions = $_POST['chronicConditions'];
$surgeries = $_POST['surgeries'];
$allergies = $_POST['allergies'];
$currentMedications = $_POST['currentMedications'];
$familyHistory = $_POST['familyHistory'];

$symptomLog = $_POST['symptomLog'];
$healthConcerns = $_POST['healthConcerns'];
$vitals = $_POST['vitals'];
$labResults = $_POST['labResults'];

$diet = $_POST['diet'];
$exercise = $_POST['exercise'];
$socialHabits = $_POST['socialHabits'];

$mentalHistory = $_POST['mentalHistory'];
$currentMentalConcerns = $_POST['currentMentalConcerns'];
$supportSystems = $_POST['supportSystems'];

$insuranceDetails = $_POST['insuranceDetails'];
$billingInfo = $_POST['billingInfo'];

$virtualConsent = $_POST['virtualConsent'];
$communicationMethod = $_POST['communicationMethod'];
$notificationPreferences = $_POST['notificationPreferences'];

// Prepare and execute SQL query to insert data
$stmt = $conn->prepare("INSERT INTO patient_profiles (
    full_name, age, gender, contact_number, email, emergency_contact, address, 
    chronic_conditions, surgeries, allergies, current_medications, family_history, 
    symptom_log, health_concerns, vitals, lab_results, diet, exercise, social_habits, 
    mental_history, current_mental_concerns, support_systems, insurance_details, billing_info, 
    virtual_consent, communication_method, notification_preferences
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sisssssssssssssssssssssssss",
    $fullName, $age, $gender, $contactNumber, $email, $emergencyContact, $address,
    $chronicConditions, $surgeries, $allergies, $currentMedications, $familyHistory,
    $symptomLog, $healthConcerns, $vitals, $labResults, $diet, $exercise, $socialHabits,
    $mentalHistory, $currentMentalConcerns, $supportSystems, $insuranceDetails, $billingInfo,
    $virtualConsent, $communicationMethod, $notificationPreferences
);

if ($stmt->execute()) {
    // Redirect to index.html on success
    header("Location: index.html");
    exit();
} else {
    echo "<script>alert('Error saving profile: " . $conn->error . "'); window.location.href='index.html';</script>";
}


$stmt->close();
$conn->close();
?>

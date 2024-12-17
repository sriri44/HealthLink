<?php
header("Content-Type: application/json"); // Set content type to JSON for responses

// Check if form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch data from the feedback form
    $name = trim($_POST['name']);          // Customer's name
    $email = trim($_POST['email']);        // Customer's email
    $feedback = trim($_POST['feedback']);  // Customer's feedback message
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0; // Star rating

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'logindetails'); // Database name: logindetails

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(["status" => "error", "message" => "Connection Failed: " . $conn->connect_error]);
        exit;
    }

    // Input validation
    if (empty($name) || empty($email) || empty($feedback) || $rating <= 0) {
        echo json_encode(["status" => "error", "message" => "All fields, including rating, are required."]);
        exit;
    }

    // Insert feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $feedback, $rating);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Thank you for your feedback, $name!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to submit feedback. Please try again."]);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request methods
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>

<?php
// Fetch data from login form
$email = $_POST['email'];
$password = $_POST['password'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'logindetails'); // Ensure the database name is correct
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection Failed: " . $conn->connect_error]);
    exit;
} else {
    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Login successful! Welcome back, $email"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = $_POST['name'];
    $dateTime = $_POST['dateTime'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'logindetails');

    // Check connection
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    } else {
        // Insert appointment details into database
        $stmt = $conn->prepare("INSERT INTO appointments (name, appointment_time) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $dateTime);

        if ($stmt->execute()) {
            // Redirect to index.html on success
            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('Error appointment booking: " . $conn->error . "'); window.location.href='index.html';</script>";
        }
        

        // Close connection
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Invalid request.";
}
?>

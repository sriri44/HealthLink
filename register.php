<?php
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$password = $_POST['password']; // No hashing applied here
$number = $_POST['number'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'logindetails');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    // Check if the email is already registered in the `register` table
    $checkStmt = $conn->prepare("SELECT * FROM register WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>
                alert('This email is already registered.');
                window.history.back();
              </script>";
    } else {
        // Insert the new user's details into the `register` table
        $stmt = $conn->prepare("INSERT INTO register (firstName, lastName, gender, email, password, number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $firstName, $lastName, $gender, $email, $password, $number);

        if ($stmt->execute()) {
            // After successful registration, insert the details into the `login` table
            $loginStmt = $conn->prepare("INSERT INTO registration (email, password) VALUES (?, ?)");
            $loginStmt->bind_param("ss", $email, $password);

            if ($loginStmt->execute()) {
                // Redirect to login.html after successful registration
                header("Location: login.html");
                exit;
            } else {
                echo "Error adding user to login table.";
            }

            $loginStmt->close();
        } else {
            echo "Error during registration.";
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>

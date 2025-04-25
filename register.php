<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password is empty for XAMPP
$dbname = "platform"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $fullname = $_POST['name'] ?? '';
    $emailid = $_POST['email'] ?? '';
    $password = $_POST['pass'] ?? '';
    $mobile = $_POST['phone'] ?? '';

    // Initialize an array to hold error messages
    $errors = [];

    // Validate input
    if (empty($fullname)) {
        $errors[] = "Full name is required.";
    }
    if (empty($emailid)) {
        $errors[] = "Email ID is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if (empty($mobile)) {
        $errors[] = "Mobile number is required.";
    }

    // Password validation
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        $errors[] = "Password must contain at least one special character.";
    }

    // If there are errors, show them in an alert
    if (!empty($errors)) {
        echo "<script>
                alert('" . implode("\\n", $errors) . "');
                window.history.back(); // Go back to the form
              </script>";
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO register (fullname, emailid, password, mobile) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $fullname, $emailid, $password, $mobile);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful, redirect to login page with alert
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'login.html'; // Change to your login page
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close the connection
$conn->close();
?>
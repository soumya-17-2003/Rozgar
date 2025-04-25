<?php
session_start();

// Replace with your DB credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "platform";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch inputs directly (no sanitization)
$email = $_POST['email'];
$pass = $_POST['password']; // No trimming or sanitization

// Securely fetch user
$sql = "SELECT * FROM register WHERE emailid = '$email'"; // Directly using the variable (not recommended)
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    
    // Verify password directly (no hashing)
    if ($pass === $row['password']) { // Direct comparison (not secure)
        // Auth successful, regenerate session ID
        session_regenerate_id(true);
        $_SESSION['user'] = $row['fullname'];
        
        // Output JavaScript to show alert and redirect
        echo "<script>
                alert('Login successful');
                window.location.href = 'loginindex.html';
              </script>";
        exit();
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "User  not found.";
}

$conn->close();
?>
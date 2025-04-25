<?php
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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO JobPostings (companyName, companyWebsite, contactEmail, jobTitle, jobLocation, jobType, salaryRange, jobDescription, qualifications, applicationDeadline, howToApply, contactPerson, contactPhone, benefits, diversityStatement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssssss", $companyName, $companyWebsite, $contactEmail, $jobTitle, $jobLocation, $jobType, $salaryRange, $jobDescription, $qualifications, $applicationDeadline, $howToApply, $contactPerson, $contactPhone, $benefits, $diversityStatement);

// Get form data
$companyName = $_POST['companyName'];
$companyWebsite = $_POST['companyWebsite'];
$contactEmail = $_POST['contactEmail'];
$jobTitle = $_POST['jobTitle'];
$jobLocation = $_POST['jobLocation'];
$jobType = $_POST['jobType'];
$salaryRange = $_POST['salaryRange'];
$jobDescription = $_POST['jobDescription'];
$qualifications = $_POST['qualifications'];
$applicationDeadline = $_POST['applicationDeadline'];
$howToApply = $_POST['howToApply'];
$contactPerson = $_POST['contactPerson'];
$contactPhone = $_POST['contactPhone'];
$benefits = $_POST['benefits'];
$diversityStatement = $_POST['diversityStatement'];

// Execute the statement
if ($stmt->execute()) {
    echo "New job posting created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>

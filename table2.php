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
$sql="CREATE TABLE JobPostings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    companyName VARCHAR(255) NOT NULL,
    companyLogo VARCHAR(255), -- Assuming you store the file path or URL
    companyWebsite VARCHAR(255) NOT NULL,
    contactEmail VARCHAR(255) NOT NULL,
    jobTitle VARCHAR(255) NOT NULL,
    jobLocation VARCHAR(255) NOT NULL,
    jobType ENUM('full-time', 'part-time', 'internship', 'contract') NOT NULL,
    salaryRange VARCHAR(100) NOT NULL,
    jobDescription TEXT NOT NULL,
    qualifications TEXT NOT NULL,
    applicationDeadline DATE NOT NULL,
    howToApply TEXT NOT NULL,
    contactPerson VARCHAR(255) NOT NULL,
    contactPhone VARCHAR(20) NOT NULL,
    benefits TEXT,
    diversityStatement TEXT
)";



if ($conn->query($sql) === TRUE) {
    echo "Table JobPostings created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  
  $conn->close();
  ?>
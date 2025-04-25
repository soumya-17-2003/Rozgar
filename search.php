<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "platform";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the location from the query string
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Prepare the SQL statement
$sql = "SELECT * FROM JobPostings WHERE jobLocation = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $location);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row with styling
    echo "
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border: 1px solid #dddddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .apply-button {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none; /* Remove underline */
        }
        .apply-button:hover {
            background-color: #45a049; /* Darker green */
        }
    </style>
    ";

    echo "<table>";
    echo "<tr>
            <th>Company Name</th>
            <th>Job Title</th>
            <th>Location</th>
            <th>Job Type</th>
            <th>Salary Range</th>
            <th>Action</th>
          </tr>";

    // Fetch and display each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['companyName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['jobTitle']) . "</td>";
        echo "<td>" . htmlspecialchars($row['jobLocation']) . "</td>";
        echo "<td>" . htmlspecialchars($row['jobType']) . "</td>";
        echo "<td>" . htmlspecialchars($row['salaryRange']) . "</td>";
        echo "<td><a href='wipro.html' class='apply-button'>Apply</a></td>"; // Redirect to wipro.html
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No job postings found for the specified location.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
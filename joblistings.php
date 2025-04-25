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

// Initialize filter variables
$jobTitleFilter = isset($_POST['jobTitle']) ? $_POST['jobTitle'] : '';
$locationFilter = isset($_POST['location']) ? $_POST['location'] : '';
$jobTypeFilter = isset($_POST['jobType']) ? $_POST['jobType'] : '';

// Build SQL query with filters
$sql = "SELECT * FROM JobPostings WHERE 1=1";
if ($jobTitleFilter) {
    $sql .= " AND jobTitle LIKE '%" . $conn->real_escape_string($jobTitleFilter) . "%'";
}
if ($locationFilter) {
    $sql .= " AND jobLocation LIKE '%" . $conn->real_escape_string($locationFilter) . "%'";
}
if ($jobTypeFilter) {
    $sql .= " AND jobType = '" . $conn->real_escape_string($jobTypeFilter) . "'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .save-button, .apply-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .saved {
            background-color: #ccc;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form input, .filter-form select {
            padding: 10px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<h2>Job Listings</h2>

<!-- Filter Form -->
<form method="POST" class="filter-form">
    <input type="text" name="jobTitle" placeholder="Job Title" value="<?php echo htmlspecialchars($jobTitleFilter); ?>">
    <input type="text" name="location" placeholder="Location" value="<?php echo htmlspecialchars($locationFilter); ?>">
    <select name="jobType">
        <option value="">All Job Types</option>
        <option value="full-time" <?php if ($jobTypeFilter == 'full-time') echo 'selected'; ?>>Full-Time</option>
        <option value="part-time" <?php if ($jobTypeFilter == 'part-time') echo 'selected'; ?>>Part-Time</option>
        <option value="internship" <?php if ($jobTypeFilter == 'internship') echo 'selected'; ?>>Internship</option>
        <option value="contract" <?php if ($jobTypeFilter == 'contract') echo 'selected'; ?>>Contract</option>
    </select>
    <input type="submit" value="Filter">
</form>

<table>
    <tr>
        <th>Company Name</th>
        <th>Job Title</th>
        <th>Location</th>
        <th>Job Type</th>
        <th>Salary Range</th>
        <th>Application Deadline</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['companyName']}</td>
                    <td>{$row['jobTitle']}</td>
                    <td>{$row['jobLocation']}</td>
                    <td>{$row['jobType']}</td>
                    <td>{$row['salaryRange']}</td>
                    <td>{$row['applicationDeadline']}</td>
                    <td>
                        <button class='save-button' onclick='toggleSave(this)'>Save</button>
                        <button class='apply-button' onclick='applyForJob(\"{$row['jobTitle']}\")'>Apply</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No job postings found.</td></tr>";
    }
    ?>
</table>

<script>
function toggleSave(button) {
    if (button.innerHTML === "Save") {
        button.innerHTML = "Saved";
        button.classList.add('saved');
    } else {
        button.innerHTML = "Save";
        button.classList.remove('saved');
    }
}

function applyForJob(jobTitle) {
    alert("You have applied for the job: " + jobTitle);
    // Here you can redirect to an application form or perform other actions
}
</script>

</body>
</html>

<?php
$conn->close();
?>
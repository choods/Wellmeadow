<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "wellmeadow"; // Adjusted database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch ward data
$sql = "SELECT ward_num, ward_name, location, total_number_of_bed, telephone_extension_num FROM Ward";
$result = $conn->query($sql);

// Array to store ward data
$wards = array();

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $wards[] = $row;
    }
}

// Close connection
$conn->close();

// Return ward data as JSON
echo json_encode($wards);
?>

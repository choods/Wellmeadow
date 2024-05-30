<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if email already exists in the database
    $check_email_sql = "SELECT id FROM users WHERE email = ?";
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_stmt->store_result();

    if ($check_email_stmt->num_rows > 0) {
        // Email already exists, display alert message
        echo "<script>alert('Email address already exists.'); window.history.back();</script>";
        exit();
    }

    // Check if passwords match
    if ($password != $confirm_password) {
        // Passwords do not match, display alert message
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit();
    }

    // Insert new user into database
    $insert_sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

    if ($insert_stmt->execute()) {
        // Registration successful, display alert message and redirect to login page
        echo "<script>alert('Registration successful.'); window.location.href = 'login.html';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $insert_stmt->close();
}

$conn->close();
?>

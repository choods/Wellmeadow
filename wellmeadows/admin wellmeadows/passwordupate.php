<?php
session_start();

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
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    if ($newpassword !== $confirmpassword) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit();
    }

    $email = $_SESSION['reset_email'];

    // Update password in the database only for the user with the provided email
    $update_password_sql = "UPDATE users SET password = ? WHERE email = ?";
    $update_password_stmt = $conn->prepare($update_password_sql);
    $update_password_stmt->bind_param("ss", $newpassword, $email);

    if ($update_password_stmt->execute()) {
        // Password updated successfully
        echo "<script>alert('Password updated successfully.');</script>";
        // Redirect to login page
        echo "<script>window.location.href = 'login.html';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
    }

    $update_password_stmt->close();
}

$conn->close();
?>

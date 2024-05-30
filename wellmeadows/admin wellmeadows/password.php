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
    $email = $_POST['email'];

    // Check if the email exists in the database
    $check_email_sql = "SELECT * FROM users WHERE email = ?";
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $result = $check_email_stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists, set the email in session and redirect to passwordupdate.php
        $_SESSION['reset_email'] = $email;
        header("Location: passwordupdate.html");
        exit();
    } else {
        // Email does not exist, display script alert and redirect back to password.html
        echo "<script>alert('Email does not exist.'); window.history.back();</script>";
        exit();
    }

    $check_email_stmt->close();
}

$conn->close();
?>

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
    $password = $_POST['password'];

    // Check if user exists in the database
    $check_user_sql = "SELECT id, email, password FROM users WHERE email = ?";
    $check_user_stmt = $conn->prepare($check_user_sql);
    $check_user_stmt->bind_param("s", $email);
    $check_user_stmt->execute();
    $check_user_result = $check_user_stmt->get_result();

    if ($check_user_result->num_rows == 1) {
        // User exists, verify password
        $user_row = $check_user_result->fetch_assoc();
        if ($password === $user_row['password']) {
            // Password is correct, set session variables and redirect
            $_SESSION['user_id'] = $user_row['id'];
            header("Location: index.html");
            exit();
        } else {
            // Incorrect password, display alert message
            echo "<script>alert('Incorrect email or password.'); window.history.back();</script>";
            exit();
        }
    } else {
        // User does not exist, display alert message
        echo "<script>alert('Incorrect email or password.'); window.history.back();</script>";
        exit();
    }
}

$conn->close();
?>

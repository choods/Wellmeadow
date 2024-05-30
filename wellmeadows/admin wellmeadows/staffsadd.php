<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "wellmeadow"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$address = $_POST['address'];
$sex = $_POST['sex'];
$hoursPerWeek = $_POST['hoursPerWeek'];
$salaryPaymentType = $_POST['salaryPaymentType'];
$wardName = $_POST['wardName'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$nin = $_POST['nin'];
$position = $_POST['position'];
$currentSalary = $_POST['currentSalary'];
$salaryScale = $_POST['salaryScale'];
$qualificationType = $_POST['qualificationType'];
$dateOfQualification = $_POST['dateOfQualification'];
$institutionName = $_POST['institutionName'];
$positionExp = $_POST['positionExp'];
$startDateExp = $_POST['startDateExp'];
$finishDateExp = $_POST['finishDateExp'];
$orgNameExp = $_POST['orgNameExp'];

// Insert data into Staff table
$sql = "INSERT INTO Staff (first_name, last_name, address, sex, hours_per_week, type_of_salary_payment, ward_name, date_of_birth, tel_no, national_insurance_num, position_held, current_salary, salary_scale, qualification_id, work_experience_id)
        VALUES ('$firstName', '$lastName', '$address', '$sex', '$hoursPerWeek', '$salaryPaymentType', '$wardName', '$dob', '$phone', '$nin', '$position', '$currentSalary', '$salaryScale', NULL, NULL)";

if ($conn->query($sql) === TRUE) {
    $staff_id = $conn->insert_id;
    // Insert data into Qualifications table
    $sql_qualifications = "INSERT INTO Qualifications (type, date_of_qualification, institution_name)
                           VALUES ('$qualificationType', '$dateOfQualification', '$institutionName')";
    $conn->query($sql_qualifications);

    // Insert data into Work_Experience table
    $sql_experience = "INSERT INTO Work_Experience (position, start_date, finish_date, organization_name)
                       VALUES ('$positionExp', '$startDateExp', '$finishDateExp', '$orgNameExp')";
    $conn->query($sql_experience);

    // Update Staff table with qualification_id and work_experience_id
    $sql_update_staff = "UPDATE Staff SET qualification_id = LAST_INSERT_ID(), work_experience_id = LAST_INSERT_ID() WHERE staff_num = '$staff_id'";
    $conn->query($sql_update_staff);

    header("Location: staffs.html"); // Redirect to staffs.html after successful addition
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

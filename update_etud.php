<?php
// Start session
session_start();

// Check if user is logged in as a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
    // Redirect to login page if not logged in as a student
    header('Location: login.php');
    exit;
}

// Fetch student data from the database
include_once 'php/config.php';

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    $sql = "SELECT * FROM Students WHERE student_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $student_card_number = $row['student_card_number'];
        $email = $row['email'];
    } else {
        // If student not found, redirect to login page
        header('Location: login.php');
        exit;
    }
} else {
    // If session variable is not set, redirect to login page
    header('Location: login.php');
    exit;
}

// Update student information if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if fields are not empty
    if (!empty($_POST['first_name'])) {
        $first_name = $_POST['first_name'];
    }
    if (!empty($_POST['last_name'])) {
        $last_name = $_POST['last_name'];
    }
    if (!empty($_POST['student_card_number'])) {
        $student_card_number = $_POST['student_card_number'];
    }
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
    }

    // Update student information in the database
    $sql = "UPDATE Students SET first_name = ?, last_name = ?, student_card_number = ?, email = ? WHERE student_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $student_card_number, $email, $student_id);

    if ($stmt->execute()) {
        // Successful update
        echo "Student information updated successfully.";
    } else {
        // Error occurred
        echo "Error updating student information: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles/up.css">

<title>Update Student Information</title>
</head>
<body>

<h2>Update Student Information</h2>

<form action="update_student.php" method="POST">
    <label for="first_name">First Name:</label><br>
    <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>"><br><br>
    
    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>"><br><br>
    
    <label for="student_card_number">Student Card Number:</label><br>
    <input type="text" id="student_card_number" name="student_card_number" value="<?php echo $student_card_number; ?>"><br><br>
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br><br>
    
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br><br>
    
    <input type="submit" value="Update">
</form>

</body>
</html>

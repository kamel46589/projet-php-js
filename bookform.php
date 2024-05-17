<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a random token
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Borrow Book Form</title>
  <link rel="stylesheet" href="styles/bookform.css">
</head>

<body>

<h2>Borrow Book Form</h2>

<form action="book_process.php" method="POST">
    <label for="student_id">Student ID:</label><br>
    <!-- Autofill student ID from session -->
    <input type="text" id="student_id" name="student_id" value="<?php echo isset($_SESSION['student_id']) ? $_SESSION['student_id'] : ''; ?>" readonly><br><br>
    
    <label for="book_id">Book ID:</label><br>
    <!-- Autofill book ID from URL parameter -->
    <input type="text" id="book_id" name="book_id" value="<?php echo isset($_GET['book_id']) ? htmlspecialchars($_GET['book_id']) : ''; ?>" readonly><br><br>
    
    <label for="borrow_date">Borrow Date:</label><br>
    <input type="datetime-local" id="borrow_date" name="borrow_date" value="<?php echo date('Y-m-d\TH:i:s'); ?>"><br><br>
    
    <label for="return_date">Return Date:</label><br>
    <input type="datetime-local" id="return_date" name="return_date"><br><br>
    
    <!-- CSRF Token -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    
    <input type="submit" value="Borrow Book">
</form>

</body>
</html>

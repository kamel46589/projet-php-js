<?php
// Database connection
include_once 'php/config.php';

// Start session (needed for CSRF token)
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }

    // Sanitize input data
    $book_id = mysqli_real_escape_string($mysqli, $_POST['book_id']);
    $title = mysqli_real_escape_string($mysqli, $_POST['title']);
    $author = mysqli_real_escape_string($mysqli, $_POST['author']);
    $genre = mysqli_real_escape_string($mysqli, $_POST['genre']);
    $publication_year = mysqli_real_escape_string($mysqli, $_POST['publication_year']);
    $isbn = mysqli_real_escape_string($mysqli, $_POST['isbn']);

    // Update book information in the database
    $sql = "UPDATE Books 
            SET title = '$title', author = '$author', genre = '$genre', publication_year = '$publication_year', isbn = '$isbn'
            WHERE book_id = '$book_id'";

    if ($mysqli->query($sql) === TRUE) {
        $message = "Book information updated successfully.";
    } else {
        $message = "Error updating book information: " . $mysqli->error;
    }
} else {
    // If form is not submitted, redirect to home page or display an error message
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link rel="stylesheet" href="styles/styleP.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Update Book</h2>
        <p><?php echo $message; ?></p>
        <a href="book_list.php" class="btn">Back to Book List</a>
    </div>
</body>
</html>

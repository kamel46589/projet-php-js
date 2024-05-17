<?php
// Database connection
include_once 'php/config.php';

// Start session (needed for CSRF token)
session_start();

// Set CSRF token if not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }

    // Sanitize input data
    $book_id = mysqli_real_escape_string($mysqli, $_POST['book_id']);

    // Retrieve book data from database
    $sql = "SELECT * FROM Books WHERE book_id = '$book_id'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows == 1) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit;
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
    <link rel="stylesheet" href="updatelib.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Update Book</h2>
        <form action="update_process_book.php" method="post">
            <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo $book['title']; ?>">
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" value="<?php echo $book['author']; ?>">
            </div>
            <div class="form-group">
                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" value="<?php echo $book['genre']; ?>">
            </div>
            <div class="form-group">
                <label for="publication_year">Publication Year:</label>
                <input type="text" id="publication_year" name="publication_year" value="<?php echo $book['publication_year']; ?>">
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" value="<?php echo $book['isbn']; ?>">
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>

<?php
// Close connection
$mysqli->close();
?>

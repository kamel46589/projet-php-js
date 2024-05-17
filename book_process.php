<?php
// Start session
session_start();

// Check CSRF token
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    // Database connection
    include_once 'php/config.php';

    // Sanitize input data
    $student_id = $_SESSION['student_id']; // Retrieve student ID from session
    $book_id = $_POST['book_id']; // Retrieve book ID from form
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];

    // Prepare and execute SQL statement to insert data
    $sql_insert = "INSERT INTO BorrowedBooks (student_id, book_id, borrow_date, return_date) VALUES (?, ?, ?, ?)";
    $stmt_insert = $mysqli->prepare($sql_insert);
    $stmt_insert->bind_param("iiss", $student_id, $book_id, $borrow_date, $return_date);

    // Update the availability of the book
    $sql_update = "UPDATE Books SET is_available = 0 WHERE book_id = ?";
    $stmt_update = $mysqli->prepare($sql_update);
    $stmt_update->bind_param("i", $book_id);
    
    // Execute both queries within a transaction
    $mysqli->begin_transaction();
    $insert_success = $stmt_insert->execute();
    $update_success = $stmt_update->execute();
    
    if ($insert_success && $update_success) {
        // Both queries executed successfully, commit the transaction
        $mysqli->commit();
        echo "Book borrowed successfully.";
    } else {
        // Error occurred, rollback the transaction
        $mysqli->rollback();
        echo "Error: " . $mysqli->error;
    }

    // Close prepared statements
    $stmt_insert->close();
    $stmt_update->close();
} else {
    // Invalid request or CSRF token mismatch
    echo "Invalid request.";
}
?>

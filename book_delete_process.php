<?php
// Start session (optional, can be used to redirect after processing)
session_start();

// Database connection
include_once 'php/config.php';

// Check if book ID is provided
if (!isset($_POST['book_id'])) {
    // Redirect back with an error message
    $_SESSION['delete_message'] = "Erreur : ID du livre manquant.";
    header("Location: booklist.php");
    exit;
}

// Retrieve book ID from POST
$book_id = $_POST['book_id'];

// Delete book from the database
$sql_delete = "DELETE FROM Books WHERE book_id = ?";
$stmt_delete = $mysqli->prepare($sql_delete);
$stmt_delete->bind_param("i", $book_id);

// Execute deletion query
if ($stmt_delete->execute()) {
    // Success message
    $_SESSION['delete_message'] = "Livre supprimé avec succès.";
} else {
    // Error message
    $_SESSION['delete_message'] = "Erreur lors de la suppression du livre : " . $stmt_delete->error;
}

// Close statement and connection
$stmt_delete->close();
$mysqli->close();

// Redirect to the previous page
header("Location: book_list.php");
exit;
?>

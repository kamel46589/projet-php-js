<?php
// Start session (optional, can be used to redirect after processing)
session_start();

// Database connection
include_once 'php/config.php';

// Check if librarian ID and password (for validation) are provided
if (!isset($_POST['librarian_id']) || !isset($_POST['password'])) {
    // Redirect back with an error message (modify as needed)
    $_SESSION['delete_message'] = "Erreur : Données de suppression du bibliothécaire invalides.";
    header("Location: deletelib.php");
    exit;
}

// Retrieve data from POST
$librarian_id = $_POST['librarian_id'];
$password = $_POST['password']; // Password provided by the user

// Get the hashed password from the database
$sql = "SELECT password FROM Librarians WHERE librarian_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $librarian_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    // Redirect back with an error message if librarian not found
    $_SESSION['delete_message'] = "Erreur : Bibliothécaire introuvable.";
    header("Location: deletelib.php");
    exit;
}

$row = $result->fetch_assoc();
$hashed_password = $row['password'];

// Verify the password
if (password_verify($password, $hashed_password)) {
    // If password matches, proceed with deletion
    $sql_delete = "DELETE FROM Librarians WHERE librarian_id = ?";
    $stmt_delete = $mysqli->prepare($sql_delete);
    $stmt_delete->bind_param("i", $librarian_id);

    // Execute deletion query
    if ($stmt_delete->execute()) {
        // Success message
        $_SESSION['delete_message'] = "Bibliothécaire supprimé avec succès.";
    } else {
        // Error message
        $_SESSION['delete_message'] = "Erreur lors de la suppression du bibliothécaire : " . $stmt_delete->error;
    }

    // Close statement and connection
    $stmt_delete->close();
} else {
    // If password doesn't match, redirect back with an error message
    $_SESSION['delete_message'] = "Erreur : Mot de passe incorrect.";
}

$stmt->close();
$mysqli->close();

// Redirect to the previous page
header("Location: liblist.php");
exit;
?>

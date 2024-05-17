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
    $librarian_id = mysqli_real_escape_string($mysqli, $_POST['librarian_id']);
    $first_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);

    // Update librarian information in the database
    $sql = "UPDATE Librarians 
            SET first_name = '$first_name', last_name = '$last_name', email = '$email'
            WHERE librarian_id = '$librarian_id'";

    if ($mysqli->query($sql) === TRUE) {
        $message = "Les informations du bibliothécaire ont été mises à jour avec succès.";
    } else {
        $message = "Erreur lors de la mise à jour des informations du bibliothécaire: " . $mysqli->error;
    }
} else {
    // If form is not submitted, redirect to home page or display an error message
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Librarian</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="container">
    <h2>Update Librarian</h2>
    <p><?php echo $message; ?></p>
    <a href="liblist.php" class="btn">Retour à la liste des bibliothécaires</a>
</div>
</body>
</html>

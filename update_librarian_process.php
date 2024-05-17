<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un bibliothécaire - Admin</title>
    <link rel="stylesheet" href="styles/process.css"> <!-- Link to your CSS file -->
</head>

<?php
// Start session (optional, can be used to redirect after processing)
session_start();

// Database connection
include_once 'php/config.php';

// Check if librarian ID and password (for validation) are provided
if (!isset($_POST['librarian_id']) || !isset($_POST['password'])) {
  // Redirect back with an error message (modify as needed)
  $_SESSION['update_message'] = "Erreur : Données de mise à jour du bibliothécaire invalides.";
  header("Location: updatelib.php?id=" . $_POST['librarian_id']);
  exit;
}

// Retrieve data from POST
$librarian_id = $_POST['librarian_id'];
$password = $_POST['password']; // Password for validation

// Validate librarian ID and password (modify as needed)
$sql = "SELECT * FROM Librarians WHERE librarian_id = ? AND password = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("is", $librarian_id, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
  // Redirect back with an error message if not found (modify as needed)
  $_SESSION['update_message'] = "Erreur : Bibliothécaire introuvable ou mot de passe incorrect.";
  header("Location: updatelib.php?id=" . $_POST['librarian_id']);
  exit;
}

// Close statement
$stmt->close();

// If validation successful, proceed with additional update logic (replace with your actual logic)
// This example just echoes a success message (modify as needed)
echo "Bibliothécaire mis à jour avec succès ! (Mettre à jour la logique de mise à jour ici)";

// Optional: Redirect to a different page after successful update (modify as needed)
// header("Location: success.php");

?>

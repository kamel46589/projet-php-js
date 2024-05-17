<?php
// Start session
session_start();

// Check if librarian ID is provided in the session
if (!isset($_SESSION['librarian_id'])) {
    // If not, redirect back to the list page
    header("Location: liblist.php");
    exit;
}

// Database connection
include_once 'php/config.php';

// Retrieve librarian ID from session
$librarian_id = $_SESSION['librarian_id'];

// Fetch librarian details from the database
$sql = "SELECT * FROM Librarians WHERE librarian_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $librarian_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if librarian exists
if ($result->num_rows == 0) {
    // If not, redirect back to the list page
    header("Location: liblist.php");
    exit;
}

// Fetch librarian data
$librarian = $result->fetch_assoc();

// Close statement
$stmt->close();

// Clear the session to remove the librarian ID
unset($_SESSION['librarian_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un bibliothécaire - Bibliothécaire</title>
    <link rel="stylesheet" href="styles/style7.css"> <!-- Adjust the path to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Modifier un bibliothécaire</h2>
        <form action="update_librarian_process.php" method="post">
            <input type="hidden" name="librarian_id" value="<?php echo $librarian_id; ?>">
            <div class="input-group">
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $librarian['first_name']; ?>" required>
            </div>
            <div class="input-group">
                <label for="last_name">Nom :</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $librarian['last_name']; ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" value="<?php echo $librarian['email']; ?>" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn">Enregistrer</button>
            </div>
        </form>
    </div>
</body>
</html>

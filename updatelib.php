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

    // Retrieve librarian data from database
    $sql = "SELECT * FROM Librarians WHERE librarian_id = '$librarian_id'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows == 1) {
        $librarian = $result->fetch_assoc();
    } else {
        echo "Bibliothécaire introuvable.";
        exit;
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
    <title>Modifier Bibliothécaire</title>
    <link rel="stylesheet" href="updatelib.css">
</head>
<body>
<div class="container">
    <h2>Modifier Bibliothécaire</h2>
    <form action="update_process.php" method="post">
        <input type="hidden" name="librarian_id" value="<?php echo $librarian['librarian_id']; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="form-group">
            <label for="first_name">Prénom:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $librarian['first_name']; ?>">
        </div>
        <div class="form-group">
            <label for="last_name">Nom:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $librarian['last_name']; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $librarian['email']; ?>">
        </div>
        <button type="submit">Mettre à jour</button>
    </form>
</div>
</body>
</html>

<?php
// Close connection
$mysqli->close();
?>

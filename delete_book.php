<?php
// Start session
session_start();

// Database connection
include_once 'php/config.php';

// Check if book ID is provided
if (!isset($_POST['book_id'])) {
    $_SESSION['delete_message'] = "Erreur : ID du livre manquant.";
    header("Location: booklist.php");
    exit;
}

// Retrieve book ID from POST
$book_id = $_POST['book_id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un livre - Admin</title>
    <link rel="stylesheet" href="styles/delete.css">
</head>
<body>
    <div class="container">
        <h2>Supprimer un livre</h2>
        <form action="book_delete_process.php" method="post">
            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
            <button type="submit">Supprimer</button>
        </form>
        <a href="booklist.php" class="btn">Retour à la liste des livres</a>
    </div>
</body>
</html>

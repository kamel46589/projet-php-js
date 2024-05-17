<!-- deletelib.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un bibliothécaire - Admin</title>
    <link rel="stylesheet" href="styles/delete.css">
</head>
<body>
    <div class="container">
        <h2>Supprimer un bibliothécaire</h2>
        <?php
        // Start session
        session_start();

        // Database connection
        include_once 'php/config.php';

        // Check if librarian ID is provided
        if (!isset($_POST['librarian_id'])) {
            $_SESSION['delete_message'] = "Erreur : ID du bibliothécaire manquant.";
            header("Location: liblist.php");
            exit;
        }

        // Retrieve librarian ID from POST
        $librarian_id = $_POST['librarian_id'];
        ?>
        <form action="delete_process.php" method="post">
            <div class="form-group">
                <label for="librarian_id">ID du Bibliothécaire:</label>
                <input type="text" id="librarian_id" name="librarian_id" value="<?php echo $librarian_id; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Supprimer</button>
        </form>
        <a href="liblist.php" class="btn">Retour à la liste des bibliothécaires</a>
    </div>
</body>
</html>

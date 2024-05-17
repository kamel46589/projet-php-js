<?php
session_start(); // Starting the session

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a login logic here
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Assuming some validation and authentication logic
    // For demonstration, I'm storing the entered email and password in session
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

    // Redirect to appropriate page after login (you might handle this differently)
    header('Location: index.php?action=admin');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système de Bibliothèque</title>
    <link rel="stylesheet" href="styles/style1.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Connexion au Système de Bibliothèque</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de Passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn">Connexion</button>
            </div>
           
        </form>
        <p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous ici</a>.</p>
    </div>
</body>
</html>

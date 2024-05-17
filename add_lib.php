<?php
// Database connection
include_once 'php/config.php';

// Define variables and initialize with empty values
$first_name = $last_name = $email = $password = "";
$first_name_err = $last_name_err = $email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate first name
    if (empty($_POST["first_name"])) {
        $first_name_err = "Veuillez entrer votre prénom.";
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if (empty($_POST["last_name"])) {
        $last_name_err = "Veuillez entrer votre nom.";
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Veuillez entrer votre adresse email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Adresse email invalide.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $password_err = "Veuillez entrer un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting into database
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO Librarians (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_first_name, $param_last_name, $param_email, $param_password);

            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page or show success message
                echo "<p>L'administrateur a été ajouté avec succès.</p>";
                header("Location: dashboard_admin.php");
            } else {
                echo "Oops! Une erreur s'est produite. Veuillez réessayer plus tard.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un bibliothécaire - Admin</title>
    <link rel="stylesheet" href="styles/style5.css"> <!-- Link to your CSS file -->
    <script src=javascript/lib.js></script>
</head>
<body>
    <div class="container">
        <h2>Ajouter un bibliothécaire</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return closePopup();">
            <div class="input-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" >
                <span class="help-block"><?php echo $first_name_err; ?></span>
            </div>
            <div class="input-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                <label for="last_name">Nom :</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" >
                <span class="help-block"><?php echo $last_name_err; ?></span>
            </div>
            <div class="input-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" >
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="input-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label for="password">Mot de Passe :</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>" >
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="input-group">
                <button type="submit" class="btn">Ajouter</button>
            </div>
        </form>
    </div>
</body>
</html>


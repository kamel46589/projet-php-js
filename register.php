<?php
include_once 'php/config.php';

$first_name = $last_name = $student_card_number = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $student_card_number = trim($_POST["student_card_number"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($first_name)) {
        $first_name_err = "Veuillez entrer votre prénom.";
    }

    if (empty($last_name)) {
        $last_name_err = "Veuillez entrer votre nom.";
    }

    if (empty($student_card_number)) {
        $student_card_number_err = "Veuillez entrer votre numéro de carte étudiant.";
    }

    if (empty($email)) {
        $email_err = "Veuillez entrer votre adresse email.";
    }

    if (empty($password)) {
        $password_err = "Veuillez entrer un mot de passe.";
    } elseif (strlen($password) < 6) {
        $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    if ($password != $confirm_password) {
        $confirm_password_err = "Les mots de passe ne correspondent pas.";
    }

    if (empty($first_name_err) && empty($last_name_err) && empty($student_card_number_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO Students (first_name, last_name, student_card_number, email, password) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sssss", $param_first_name, $param_last_name, $param_student_card_number, $param_email, $param_password);
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_student_card_number = $student_card_number;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                header("location: login.php");
                exit;
            } else {
                echo "Oops! Une erreur s'est produite. Veuillez réessayer plus tard.";
            }

            $stmt->close();
        }
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Système de Bibliothèque</title>
    <link rel="stylesheet" href="styles/register.css">
    <script src="javascript/register_validation.js"></script>
</head>
<body style="background-image: url('images/cropped-1920-1080-1338193.png');">
    <div class="container">
        <h2>Inscription au Système de Bibliothèque</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
            <div class="input-group">
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" >
                <span class="help-block" id="first_name_err"><?php echo isset($first_name_err) ? $first_name_err : ''; ?></span>
            </div>
            <div class="input-group">
                <label for="last_name">Nom :</label>
                <input type="text" id="last_name" name="last_name" >
                <span class="help-block" id="last_name_err"><?php echo isset($last_name_err) ? $last_name_err : ''; ?></span>
            </div>
            <div class="input-group">
                <label for="student_card_number">Numéro de carte étudiant :</label>
                <input type="text" id="student_card_number" name="student_card_number" >
                <span class="help-block" id="student_card_number_err"><?php echo isset($student_card_number_err) ? $student_card_number_err : ''; ?></span>
            </div>
            <div class="input-group">
                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" >
                <span class="help-block" id="email_err"><?php echo isset($email_err) ? $email_err : ''; ?></span>
            </div>
            <div class="input-group">
                <label for="password">Mot de Passe :</label>
                <input type="password" id="password" name="password" >
                <span class="help-block" id="password_err"></span>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirmer le Mot de Passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" >
                <span class="help-block" id="confirm_password_err"><?php echo isset($confirm_password_err) ? $confirm_password_err : ''; ?></span>
            </div>
            <div class="input-group">
                <button type="submit" class="btn">S'inscrire</button>
            </div>
        </form>
        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    </div>
</body>
</html>

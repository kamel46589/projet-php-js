<?php
session_start();
include_once 'php/config.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);

        // Admin login
        if ($email === 'admin@admin') {
            if ($_POST['password'] === 'admin') {
                $_SESSION['user_type'] = 'admin';
                header('Location: dashboard_admin.php');
                exit;
            } else {
                $error_message = "Mot de passe incorrect.";
            }
        } else {
            // Prepare and execute statement for librarian login
            $sql = "SELECT * FROM Librarians WHERE email = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $librarian_id = $row['librarian_id'];
                $stored_password = $row['password'];

                if (password_verify($_POST['password'], $stored_password)) {
                    $_SESSION['user_type'] = 'librarian';
                    $_SESSION['librarian_id'] = $librarian_id;
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    header('Location: lib_dashboard.php');
                    exit;
                } else {
                    $error_message = "Mot de passe incorrect.";
                }
            } else {
                // No librarian found, proceed to student login
                $sql = "SELECT * FROM Students WHERE email = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $student_id = $row['student_id'];
                    $stored_password = $row['password'];

                    if (password_verify($_POST['password'], $stored_password)) {
                        $_SESSION['user_type'] = 'student';
                        $_SESSION['student_id'] = $student_id;
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        header('Location: etud_dashboard.php');
                        exit;
                    } else {
                        $error_message = "Mot de passe incorrect.";
                    }
                } else {
                    $error_message = "Utilisateur non trouvé.";
                }
            }
            $stmt->close();
        }
    } else {
        $error_message = "Veuillez fournir une adresse email et un mot de passe.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système de Bibliothèque</title>
    <link rel="stylesheet" href="styles/login.css">
    <script src="javascript/login_validation.js"></script>
</head>
<body style="background-image: url('images/cropped-1920-1080-1338193.png');">
    <div class="container">
        <h2>Connexion au Système de Bibliothèque</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateLoginForm()">
            <div class="input-group">
                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" >
                <div id="email_err" class="error"></div> <!-- Error message for email -->
            </div>
            <div class="input-group">
                <label for="password">Mot de Passe :</label>
                <input type="password" id="password" name="password" >
                <div id="password_err" class="error"></div> <!-- Error message for password -->
            </div>
            <?php if (isset($error_message)) : ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <button type="submit" class="btn">Connexion</button>
            </div>
        </form>
        <p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous ici</a>.</p>
    </div>
</body>
</html>

<?php
// Database connection
include_once 'php/config.php';

// Start session (needed for CSRF token)
session_start();

// Define an empty array to store librarian data
$librarians = array();

// Generate a CSRF token (if not already set)
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Fetch librarians from the database
$sql = "SELECT * FROM Librarians";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
  // Loop through each row of the result set and store librarian data in the array
  while ($row = $result->fetch_assoc()) {
    $librarians[] = $row;
  }
} else {
  // Handle potential database errors (e.g., display an error message)
  echo "Une erreur est survenue lors de la récupération des bibliothécaires.";
}

// Close connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des Bibliothécaires - Administration</title>
  <link rel="stylesheet" href="styles/lib.css"> </head>
<body>
<div class="menu">
            <div class="menu-item"><a href="#">Bienvenue, Admin!</a></div>
            <div class="menu-item"><a href="logout.php">Déconnexion</a></div>
        </div>
  <div class="container">
    <h2>Liste des Bibliothécaires</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Prénom</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($librarians)) : ?>
          <?php foreach ($librarians as $librarian) : ?>
            <tr>
              <td><?php echo $librarian['librarian_id']; ?></td>
              <td><?php echo $librarian['first_name']; ?></td>
              <td><?php echo $librarian['last_name']; ?></td>
              <td><?php echo $librarian['email']; ?></td>
              <td>
                <form action="updatelib.php" method="post" style="display: inline;">
                  <input type="hidden" name="librarian_id" value="<?php echo $librarian['librarian_id']; ?>">
                  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                  <button type="submit">Modifier</button>
                </form>
                <form action="deletelib.php" method="post" style="display: inline;">
                                <input type="hidden" name="librarian_id" value="<?php echo $librarian['librarian_id']; ?>">
                                <button type="submit">Supprimer</button>
                            </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="5">Aucun bibliothécaire trouvé.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

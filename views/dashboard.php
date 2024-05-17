<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Librarian</title>
  <link rel="stylesheet" href="styles/admindashboard.css">
</head>
<body>
<div class="top-nav">
    <div class="container">
      <img src="path_to_your_logo_image" alt="Your Logo" class="logo">
      <span class="biblio-online">Biblio Online</span>
    </div>
  </div>
  <div class="container">
    <ul>
      <li class="card">
        <h2>Ajouter un nouveau livre</h2>
        <a href="add_book.php">Gérer votre collection de livres</a>
      </li>
      <li class="card">
        <h2>Supprimer un livre</h2>
        <a href="delete_book.php">Retirer les titres indésirables</a>
      </li>
      <li class="card">
        <h2>Voir les livres en retard</h2>
        <a href="index.php?action=viewOverdueBooks">Suivre les retours en retard</a>
      </li>
    </ul>
  </div>
</body>
</html>

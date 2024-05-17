<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Admin</title>
  <link rel="stylesheet" href="styles/ad.css">
  <script src="javascript/admin.js"></script>
</head>
<body>
  <header class="navbar">
    <img src="images/library-book.svg" alt="Biblio Online Logo" class="logo"> 
    <span class="title">Biblio Online</span>
  </header>

  <div class="menu">
    <div class="menu-item"><a href="#">Bienvenue, Admin!</a></div>
    <div class="menu-item"><a href="logout.php">Déconnexion</a></div>
  </div>
  <div class="container">
    <div class="dashboard">
      <h2>Tableau de bord - Admin</h2>
      <div class="links">
        <div class="link-item">
          <img src="images/prso.jpeg" alt="Ajouter un bibliothécaire">
          <a href="#" class="btn" onclick="openPopup('add_lib.php',1000,1000)">Ajouter un bibliothécaire</a>
        </div>
        <div class="link-item">
          <img src="images/staff.jpeg" alt="Liste des bibliothécaires">
          <a href="#" onclick="openPopup('liblist.php',1000,1000)" class="btn">Liste des bibliothécaires</a>
        </div>
        <div class="link-item">
          <img src="images/b.png" alt="Liste des livres">
          <a href="booklistadmin.php" class="btn">Liste des livres</a>
        </div>
        <div class="link-item">
          <img src="images/etud.jpg" alt="Liste des étudiants">
          <a href="#" onclick="openPopup('student_list.php',1000,1000)" class="btn">Liste des étudiants</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

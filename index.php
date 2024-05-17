<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bibliothèque en Ligne</title>
  <link rel="stylesheet" href="styles/landing.css">
</head>

<body>
  <header>
    <h1>Bibliothèque en Ligne</h1>
    <nav>
      <ul>
        <li><a href="#accueil">Accueil</a></li>
        <li><a href="#a-propos">À propos</a></li>
        <li><a href="#collections">Collections</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="hero" id="accueil" style="background-image: url('images/background.jpg');">
      <div class="overlay">
        <h2>La meilleure librairie en ligne</h2>
        <p>Découvrez un monde de connaissances à portée de clic. Empruntez des livres électroniques, des livres audio et plus encore.</p>
        <div class="buttons">
          <a href="login.php">Connexion</a>
          <a href="register.php">Inscription</a>
        </div>
      </div>
    </section>

    <section class="sections" id="a-propos">
      <img src="images/books.jpg" alt="Image représentant à propos">
      <div class="content">
        <h2>À propos</h2>
        <p>Découvrez qui nous sommes, notre mission et notre engagement envers nos utilisateurs. Nous nous efforçons de fournir un accès facile et pratique à la lecture pour tous.</p>
      </div>
    </section>

    <section class="sections" id="collections">
  <div class="content">
    <h2 style="text-align: left;">Collections</h2>
    <p>Explorez nos collections variées de livres électroniques et audio. Que vous soyez intéressé par la fiction, la non-fiction, la science, la littérature classique ou tout autre sujet, vous trouverez ce que vous cherchez ici.</p>
  </div>
  <img src="images/audiobook.jpg" alt="Image représentant les collections">
</section>

    <section class="services" id="services" style="background-image: url('images/book3.png');">
      <div class="content">
        <h2>Services</h2>
        <p>Nous offrons une variété de services pour faciliter votre expérience de lecture.</p>
        <ul>
          <li>Téléchargement de livres électroniques et audio simples et rapides.</li>
          <li>Gestion de votre compte et de vos prêts en ligne.</li>
          <li>Recommandations personnalisées en fonction de vos lectures précédentes.</li>
          <li>Accès à des ressources et des documents en ligne.</li>
        </ul>
      </div>
      
    </section>
  </main>

  <footer>
    <p>&copy; Bibliothèque en Ligne 2024</p>
  </footer>

</body>

</html>

<?php
session_start();

// Redirect to login if session user_type is not librarian
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'librarian') {
    header('Location: login.php');
    exit;
}

$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : "";
$last_name = isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : "";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bibliothécaire</title>
    <link rel="stylesheet" href="styles/admin.css">
    <style>
    
            
        /* Reset default styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        /* Main container */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* Menu styles */
        .menu {
            background-color: #2196f3;
            color: #fff;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .menu-item {
            margin-right: 20px;
        }

        .menu-item:last-child {
            margin-right: 0;
        }

        .menu-item a {
            color: #fff;
            text-decoration: none;
        }

        /* Dashboard styles */
        .dashboard {
            max-width: 800px;
            width: 90%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        .dashboard h2 {
            margin-bottom: 30px;
        }

        /* Links styles */
        .links {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .link-item {
            width: 200px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s ease;
            text-align: center;
        }

        .link-item:hover {
            transform: scale(1.05); /* Enlarge the box on hover */
        }

        .link-item img {
            width: 100px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .link-item .btn {
            display: inline-block;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .link-item .btn:hover {
            background-color: #0056b3;
        }

        /* Navbar styles */
        .navbar {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(to right, #007bff, #20057455); /* Gradient background */
        }

        /* Logo styles */
        .logo {
            width: 80px;
            height: auto;
            margin-right: 20px;
        }

        /* Title styles */
        .title {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
    <script src="javascript/books.js"></script>
    
</head>
<body>
<header class="navbar">
    <img src="images/library-book.svg" alt="Biblio Online Logo" class="logo"> <span class="title">Biblio Online</span>
</header>

<div class="menu">
    <div class="menu-item"><a href="#">Bienvenue, <?php echo "$name $last_name"; ?>!</a></div>
    <div class="menu-item"><a href="logout.php">Déconnexion</a></div>
</div>
<div class="container">
    <div class="dashboard">
        <h2>Tableau de bord - Bibliothécaire</h2>
        
        <div class="links">
            <div class="link-item">
                <a href="#"  onclick="openPopup('addbook.php')">
                    <img src="images/Fantasy-Book-Painting-4k-53560665-1.png" alt="Add Book">
                    <span class="btn">Ajouter un livre</span>
                </a>
            </div>
            <div class="link-item">
                <a href="book_list.php">
                    <img src="images/liste_books.jpg" alt="Book List">
                    <span class="btn">Liste des livres</span>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

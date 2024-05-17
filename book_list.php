<?php
session_start();

// Redirect to login if session user_type is not librarian
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'librarian') {
    header('Location: login.php');
    exit;
}

$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : "";
$last_name = isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : "";

// Include database connection
include_once 'php/config.php';

// Fetch books from database
$sql = "SELECT * FROM Books";
$result = $mysqli->query($sql);

// Initialize books array
$books = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    echo "An error occurred while retrieving books.";
}

$mysqli->close(); // Close database connection

// Generate CSRF token
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bibliothécaire</title>
    <link rel="stylesheet" href="styles/list.css">
</head>
<body>
<header class="navbar">
    <img src="images/library-book.svg" alt="Biblio Online Logo" class="logo"> <span class="title">Biblio Online</span>
</header>
<header class="menu">
    <div class="menu-item"><a href="#">Bienvenue, <?php echo "$name $last_name"; ?>!</a></div>
    <div class="menu-item"><a href="logout.php">Déconnexion</a></div>
</header>

<div class="container">
    <div class="dashboard">
        <h2>Tableau de bord - Bibliothécaire</h2>

        <div class="container">
            <h2>List of Books</h2>
            <div class="book-grid">
                <?php if (!empty($books)) : ?>
                    <?php foreach ($books as $book) : ?>
                        <div class="book-wrapper">
                            <div class="book-item">
                                <div class="book-cover">
                                    <?php if (!empty($book['photo_url'])) : ?>
                                        <img src="<?php echo $book['photo_url']; ?>" alt="<?php echo $book['title']; ?>" class="book-image">
                                    <?php endif; ?>
                                </div>
                                <div class="book-details">
                                    <h3><?php echo $book['title']; ?></h3>
                                    <p><strong>Genre:</strong> <?php echo $book['genre']; ?></p>
                                    <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
                                </div>
                                <div class="actions">
                                    <form action="update_book.php" method="post">
                                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                        <button type="submit">Edit</button>
                                    </form>
                                    <form action="delete_book.php" method="post">
                                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                        <button type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No books found.</p>
                <?php endif; ?>
            </div> <!-- Closing tag for book-grid -->
        </div> <!-- Closing tag for container -->
    </div> <!-- Closing tag for dashboard -->
</body>
</html>

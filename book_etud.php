<?php
// Start session
session_start();

// Database connection
include_once 'php/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// Fetch student data from the database
$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM Students WHERE student_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
} else {
    // If student not found, redirect to login page
    header('Location: login.php');
    exit;
}

// Generate CSRF token
$csrf_token = bin2hex(random_bytes(32)); // Generate a random token

// Fetch available books from the database
$sql = "SELECT * FROM Books WHERE is_available = 1";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Available Books</title>
    <link rel="stylesheet" href="styles/book_list.css"> <!-- Link to your CSS file -->
</head>
<body>
<header class="navbar">
    <img src="images/library-book.svg" alt="Biblio Online Logo" class="logo"> <span class="title">Biblio Online</span>
</header>

<header class="menu">
    <div class="menu-item"><a href="#">Bienvenue, <?php echo "$first_name $last_name"; ?>!</a></div>
    <div class="menu-item"><a href="logout.php">Déconnexion</a></div>
</header>

<div class="container">
    <h2>List of Available Books</h2>
    <div class="book-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $book_id = $row['book_id'];
                $title = $row['title'];
                $author = $row['author'];
                $genre = $row['genre'];
                $publication_year = $row['publication_year'];
                $isbn = $row['isbn'];
                $photo_url = $row['photo_url']; // Added photo_url

                ?>
                <div class="book-item">
                    <?php if (!empty($photo_url)) : ?> <!-- Check if photo_url is available -->
                        <div class="book-image">
                            <img src="<?php echo $photo_url; ?>" alt="<?php echo $title; ?>" class="book-cover">
                        </div>
                    <?php endif; ?>
                    <div class="book-details">
                        <h3><?php echo $title; ?></h3>
                        <p><strong>Author:</strong> <?php echo $author; ?></p>
                        <p><strong>Genre:</strong> <?php echo $genre; ?></p>
                        <p><strong>Publication Year:</strong> <?php echo $publication_year; ?></p>
                        <p><strong>ISBN:</strong> <?php echo $isbn; ?></p>
                        <form action="bookform.php" method="get"> <!-- Changed action to borrow_book_form.php -->
                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                            <!-- Removed student_id since it's already available in the session -->
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <button type="submit">Borrow</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No available books found.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>

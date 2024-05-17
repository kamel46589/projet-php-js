<?php
// Start session
session_start();

// Check if user is logged in as a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
    // Redirect to login page if not logged in as a student
    header('Location: login.php');
    exit;
}

// Fetch student data from the database
include_once 'php/config.php';

if (isset($_SESSION['student_id'])) {
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
} else {
    // If session variable is not set, redirect to login page
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Étudiant</title>
    <link rel="stylesheet" href="styles/st.css"> <!-- Add card-style CSS file -->
</head>
<body>
<header class="navbar">
    <img src="images/library-book.svg" alt="Biblio Online Logo" class="logo"> 
    <span class="title">Biblio Online</span>
  </header>
    <div class="menu">
        <div class="menu-item">Bienvenue <?php echo htmlspecialchars($first_name) . " " . htmlspecialchars($last_name); ?></div>
        <div class="menu-item"><a href="logout.php">Logout</a></div>
    </div>
    
    <div class="container">
        <div class="card-container">
            <!-- Card for Borrowed Books -->
            <div class="card">
                <img src="images/bar.jpeg" alt="Books Borrowed Image">
                <h2>Books Borrowed</h2>
                <p>View the list of books you've borrowed from the library.</p>
                <form action="mybooks.php" method="post">
                    <button type="submit" class="card-button">View</button>
                </form>
            </div>

            <!-- Card for Available Books -->
            <div class="card">
                <img src="images/best.png" alt="Available Books Image">
                <h2>Available Books</h2>
                <p>View the list of available books in the library.</p>
                <form action="book_etud.php" method="post">
                    <button type="submit" class="card-button">View</button>
                </form>
            </div>

            <!-- Card for Update Personal Info -->
            <div class="card">
                <img src="images/update.jpeg" alt="Update Personal Info Image">
                <h2>Update Personal Info</h2>
                <p>Update your personal information.</p>
                <form action="update_etud.php" method="post">
                    <button type="submit" class="card-button">View</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

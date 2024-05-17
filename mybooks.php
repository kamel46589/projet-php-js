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

// Fetch borrowed books data
$sql_borrowed = "SELECT Books.title, Books.author, Books.genre, Books.url, Books.photo_url, BorrowedBooks.borrow_date, BorrowedBooks.return_date 
                 FROM BorrowedBooks 
                 INNER JOIN Books ON BorrowedBooks.book_id = Books.book_id 
                 WHERE BorrowedBooks.student_id = ?";
$stmt_borrowed = $mysqli->prepare($sql_borrowed);
$stmt_borrowed->bind_param("i", $student_id);
$stmt_borrowed->execute();
$result_borrowed = $stmt_borrowed->get_result();
$today = date("Y-m-d");
while ($row_borrowed = $result_borrowed->fetch_assoc()) {
    $return_date = $row_borrowed['return_date'];
    if ($return_date <= $today) {
        // Remove from borrowed books
        $borrow_id = $row_borrowed['borrow_id'];
        $sql_delete_borrowed = "DELETE FROM BorrowedBooks WHERE borrow_id = ?";
        $stmt_delete_borrowed = $mysqli->prepare($sql_delete_borrowed);
        $stmt_delete_borrowed->bind_param("i", $borrow_id);
        $stmt_delete_borrowed->execute();

        // Update book availability
        $book_id = $row_borrowed['book_id'];
        $sql_update_book = "UPDATE Books SET is_available = 1 WHERE book_id = ?";
        $stmt_update_book = $mysqli->prepare($sql_update_book);
        $stmt_update_book->bind_param("i", $book_id);
        $stmt_update_book->execute();
    }
}

// Fetch borrowed books data again after updating
$stmt_borrowed->execute();
$result_borrowed = $stmt_borrowed->get_result();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Borrowed</title>
    <link rel="stylesheet" href="styles/my_books.css"> <!-- Add your dashboard CSS file -->
    <style>
        .book-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .book-item {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: calc(50% - 10px); /* Two items per row */
            max-width: 300px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .book-item:hover {
            transform: translateY(-5px);
        }

        .book-details {
            margin-top: 10px;
            font-size: 14px;
            line-height: 1.5;
        }

        .book-details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="menu">
        <div class="menu-item">Bienvenue <?php echo $first_name . " " . $last_name; ?></div>
        <div class="menu-item"><a href="update_info.php">Update Personal Info</a></div>
        <div class="menu-item"><a href="logout.php">Logout</a></div>
    </div>
    
    <div class="container">
        <h2>Books Borrowed</h2>
        <div class="book-container">
            <?php if ($result_borrowed->num_rows > 0) { ?>
                <?php while ($row_borrowed = $result_borrowed->fetch_assoc()) { ?>
                    <div class="book-item" onclick="window.open('<?php echo $row_borrowed['url']; ?>', '_blank')">
                        <img src="<?php echo $row_borrowed['photo_url']; ?>" alt="<?php echo $row_borrowed['title']; ?>" style="width: 100%;">
                        <div class="book-details">
                            <p><strong>Title:</strong> <?php echo $row_borrowed['title']; ?></p>
                            <p><strong>Author:</strong> <?php echo $row_borrowed['author']; ?></p>
                            <p><strong>Genre:</strong> <?php echo $row_borrowed['genre']; ?></p>
                            <p><strong>URL:</strong> <a href="<?php echo $row_borrowed['url']; ?>" target="_blank"><?php echo $row_borrowed['url']; ?></a></p>
                            <p><strong>Borrow Date:</strong> <?php echo $row_borrowed['borrow_date']; ?></p>
                            <p><strong>Return Date:</strong> <?php echo $row_borrowed['return_date']; ?></p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No books borrowed yet.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include_once 'php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];

    // Delete the student's borrowed books
    $delete_borrowed_books_sql = "DELETE FROM BorrowedBooks WHERE student_id = ?";
    $stmt = $mysqli->prepare($delete_borrowed_books_sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();

    // Update books to set them as available
    $sql = "UPDATE Books SET is_available = 1 WHERE book_id IN (SELECT book_id FROM BorrowedBooks WHERE student_id = ?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();

    // Delete the student
    $delete_student_sql = "DELETE FROM Students WHERE student_id = ?";
    $stmt = $mysqli->prepare($delete_student_sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard_admin.php"); // Redirect to refresh the page
    exit;
}

$sql = "SELECT s.student_id, s.first_name, s.last_name, b.title
        FROM students s, borrowedbooks bb, books b
        WHERE s.student_id = bb.student_id
        AND b.book_id = bb.book_id";
$result = $mysqli->query($sql);

$students = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Students and Their Borrowed Books</h2>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Borrowed Book</th>
            <th>Action</th>
        </tr>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['first_name']) ?></td>
            <td><?= htmlspecialchars($student['last_name']) ?></td>
            <td><?= htmlspecialchars($student['title']) ?></td>
            <td>
                <form method="post" onsubmit="return confirm('Are you sure you want to ban this student?');">
                    <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>">
                    <button type="submit">Ban</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

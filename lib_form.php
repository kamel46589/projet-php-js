<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Librarian - Admin</title>
    <link rel="stylesheet" href="styles/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Add Librarian</h2>
        <form action="add_lib.php"post">
            <div class="input-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="input-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn">Add Librarian</button>
            </div>
        </form>
    </div>
</body>
</html>

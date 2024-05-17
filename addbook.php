<?php
// Database connection
include_once 'php/config.php';

// Define variables and initialize with empty values
$title = $author = $genre = $publication_year = $isbn = $photo_url = $url = "";
$title_err = $author_err = $genre_err = $publication_year_err = $isbn_err = $photo_url_err = "";

// Define genres
$genres = array("Comedy", "Drama", "Thriller", "Mystery", "Romance", "Horror", "Science Fiction", "Fantasy", "Adventure", "Action", "Biography", "History", "Poetry", "Self-help", "Cookbook", "Art", "Children", "Young Adult", "Other");

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate title
    if (empty($_POST["title"])) {
        $title_err = "Please enter the title of the book.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate author
    if (empty($_POST["author"])) {
        $author_err = "Please enter the author of the book.";
    } else {
        $author = trim($_POST["author"]);
    }

    // Validate genre
    if (empty($_POST["genre"])) {
        $genre_err = "Please select the genre of the book.";
    } else {
        $genre = $_POST["genre"];
    }

    // Validate publication year
    if (empty($_POST["publication_year"])) {
        $publication_year = NULL;
    } else {
        $publication_year = trim($_POST["publication_year"]);
        if (!preg_match("/^\d{4}$/", $publication_year)) {
            $publication_year_err = "Please enter a valid publication year.";
        }
    }

    // Validate ISBN
    if (empty($_POST["isbn"])) {
        $isbn_err = "Please enter the ISBN of the book.";
    } else {
        $isbn = trim($_POST["isbn"]);
    }

    // File upload handling
    if (!empty($_FILES["photo"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $photo_url_err = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $photo_url_err = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            $photo_url_err = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $photo_url_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $photo_url_err = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo_url = $target_file;
            } else {
                $photo_url_err = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Validate URL
    if (!empty($_POST["url"])) {
        $url = trim($_POST["url"]);
    }

    // Check input errors before inserting into database
    if (empty($title_err) && empty($author_err) && empty($genre_err) && empty($isbn_err) && empty($photo_url_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO Books (title, author, genre, publication_year, isbn, photo_url, url) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssss", $param_title, $param_author, $param_genre, $param_publication_year, $param_isbn, $param_photo_url, $param_url);

            // Set parameters
            $param_title = $title;
            $param_author = $author;
            $param_genre = $genre;
            $param_publication_year = $publication_year;
            $param_isbn = $isbn;
            $param_photo_url = $photo_url;
            $param_url = $url;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to book list or show success message
                echo "<p>The book has been added successfully.</p>";
            } else {
                echo "Oops! An error occurred. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="styles/add_books.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Add Book</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="input-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
                <span class="help-block"><?php echo $title_err; ?></span>
            </div>
            <div class="input-group <?php echo (!empty($author_err)) ? 'has-error' : ''; ?>">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" value="<?php echo $author; ?>" required>
                <span class="help-block"><?php echo $author_err; ?></span>
            </div>
            <div class="input-group <?php echo (!empty($genre_err)) ? 'has-error' : ''; ?>">
                <label for="genre">Genre:</label>
                <select id="genre" name="genre" required>
                    <option value="">Select Genre</option>
                    <?php
                    foreach ($genres as $g) {
                        echo "<option value=\"$g\"";
                        if ($genre === $g) {
                            echo " selected";
                        }
                        echo ">$g</option>";
                    }
                    ?>
                </select>
                <span class="help-block"><?php echo $genre_err; ?></span>
            </div>
            <div class="input-group <?php echo (!empty($publication_year_err)) ? 'has-error' : ''; ?>">
                <label for="publication_year">Publication Year:</label>
                <input type="text" id="publication_year" name="publication_year" value="<?php echo $publication_year; ?>">
                <span class="help-block"><?php echo $publication_year_err; ?></span>
            </div>
            <div class="input-group <?php echo (!empty($isbn_err)) ? 'has-error' : ''; ?>">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" value="<?php echo $isbn; ?>" required>
                <span class="help-block"><?php echo $isbn_err; ?></span>
            </div>
            <div class="input-group">
                <label for="photo">Upload Photo:</label>
                <input type="file" id="photo" name="photo">
                <span class="help-block"><?php echo isset($photo_url_err) ? $photo_url_err : ''; ?></span>
            </div>
            <div class="input-group">
                <label for="url">URL:</label>
                <input type="text" id="url" name="url" value="<?php echo $url; ?>">
            </div>
            <div class="input-group">
                <button type="submit" class="btn">Add</button>
            </div>
        </form>
    </div>
</body>
</html>

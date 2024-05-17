<?php

use Librarian; // Assuming this is your Librarian model class
require_once 'models/Librarian.php';

define('DB_SERVER', 'localhost:3360'); // Adjust hostname and port if needed
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'lib');

class LibrarianController {

  public function __construct() {
    // No need for constructor logic here without private $db
  }

  public function dashboard() {
    include 'views/includes/header.php';
    include 'views/librarian/dashboard.php';
    include 'views/includes/footer.php';
  }

  public function addBook($title, $author, $isbn, $conn) {  // Add connection as argument
    try {
      // Prepare the SQL statement
      $sql = "INSERT INTO books (title, author, isbn) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);

      // Bind values to placeholders
      $stmt->bind_param("sss", $title, $author, $isbn);

      // Execute the prepared statement
      $stmt->execute();

      // Success message (optional)
      echo "Book added successfully!";

    } catch (Exception $e) {
      // Handle errors (e.g., duplicate ISBN)
      echo "Error adding book: " . $e->getMessage();
    } 
     
      // Close resources regardless of success or error
    
  }

  public function deleteBook($bookId, $conn) {  // Add connection as argument
    try {
      // Prepare the SQL statement
      $sql = "DELETE FROM books WHERE id = ?";
      $stmt = $conn->prepare($sql);

      // Bind value to placeholder
      $stmt->bind_param("i", $bookId); // Use "i" for integer

      // Execute the prepared statement
      $stmt->execute();

      // Success message (optional)
      echo "Book deleted successfully!";

    } catch (Exception $e) {
      // Handle errors (e.g., non-existent book)
      echo "Error deleting book: " . $e->getMessage();
    }  
      // Close resources regardless of success or error
      $conn->close(); // Close connection here
    
  }

  // Other Librarian-related functions with database interactions receiving connection as argument...
}

?>

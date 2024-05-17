<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createUser($firstName, $lastName, $studentCardNumber, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, last_name, student_card_number, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssss", $firstName, $lastName, $studentCardNumber, $email, $hashedPassword);
        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Add more methods as needed
}
?>

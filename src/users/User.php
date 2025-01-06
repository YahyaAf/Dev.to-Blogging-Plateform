<?php
namespace Src\users;

class User {
    private $db;
    private $table = "users";

    public function __construct($db) {
        $this->db = $db;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function signup($username, $email, $password, $profile_picture_url) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO {$this->table} (username, email, password_hash, profile_picture_url)
                VALUES (:username, :email, :password_hash, :profile_picture_url)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $hashed_password);
        $stmt->bindParam(':profile_picture_url', $profile_picture_url);

        return $stmt->execute();
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['profile_picture_url'] = $user['profile_picture_url'];

            return true;
        }

        return false;
    }

    public function logout() {
        session_unset(); 
        session_destroy(); 
        return true;
    }
}
?>

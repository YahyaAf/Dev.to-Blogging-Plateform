<?php
namespace Src\users;


use PDO;
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

        try {
            $sql = "INSERT INTO {$this->table} (username, email, password_hash, profile_picture_url)
                    VALUES (:username, :email, :password_hash, :profile_picture_url)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $hashed_password);
            $stmt->bindParam(':profile_picture_url', $profile_picture_url);

            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'profile_picture_url' => $user['profile_picture_url']
                ];

                return true;

            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        return true;
    }


    public function readAll() {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update($id, $username, $email, $profile_picture_url, $role) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET username = :username, email = :email, profile_picture_url = :profile_picture_url, role = :role 
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':profile_picture_url', $profile_picture_url);
            $stmt->bindParam(':role', $role);

            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateRole($id, $role) {
        try {
            $sql = "UPDATE {$this->table} SET role = :role WHERE id = :id";
            $stmt = $this->db->prepare($sql);
    
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':role', $role);
    
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    
    public function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        return isset($_SESSION['user']);
    }

    public function countUsers() {
        try {
            $sql = "SELECT COUNT(*) AS user_count FROM {$this->table}";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['user_count'];
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

    
}
?>

<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\users\User;

$database = new Database("dev_blog");
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    // Validate required fields
    if (empty($email) || empty($password)) {
        echo "Please fill in both email and password.";
        exit;
    }

    // Call the login method
    if ($user->login($email, $password)) {
        header("Location: ../../public/pages/home.php"); // Redirect to home page
        exit();
    } else {
        echo "Invalid email or password.";
    }
} else {
    echo "Invalid request method.";
}
?>

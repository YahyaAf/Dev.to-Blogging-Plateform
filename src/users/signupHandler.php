<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\users\User;

$database = new Database("dev_blog");
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(strip_tags($_POST['username']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password_hash']));
    $profile_picture_url = htmlspecialchars(strip_tags($_POST['profile_picture_url']));

    if ($user->signup($username, $email, $password, $profile_picture_url)) {
        header("Location: ../../public/pages/login.php");
        exit();
    } else {
        echo "Failed to create user.";
    }
} else {
    echo "Invalid request method.";
}
?>

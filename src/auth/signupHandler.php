<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\auth\Signup;

$database = new Database("dev_blog");
$db = $database->getConnection();

$signup = new Signup($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['username'])) {
        $signup_name = htmlspecialchars(strip_tags($_POST['username']));
        $signup_email = htmlspecialchars(strip_tags($_POST['email']));
        $signup_password_hash = htmlspecialchars(strip_tags($_POST['password_hash']));
        $signup_profile_picture_url = htmlspecialchars(strip_tags($_POST['profile_picture_url']));

        $signup->username = $signup_name;
        $signup->email = $signup_email;
        $signup->password_hash = $signup_password_hash;
        $signup->profile_picture_url = $signup_profile_picture_url;

        if ($signup->create()) {
            header("Location: ../../public/index.php");
        } else {
            echo "Failed to create signup.";
        }
    } else {
        echo "Signup name is required.";
    }
} else {
    echo "Invalid request method.";
}
<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\users\User;

$database = new Database("dev_blog");
$db = $database->getConnection();

$user = new User($db);

if ($user->logout()) {
    header("Location: ../../public/index.php"); 
    exit();
} else {
    echo "Logout failed.";
}
?>

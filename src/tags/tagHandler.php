<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\tags\Tag;

$database = new Database("dev_blog");
$db = $database->getConnection();

$tag = new Tag($db);

// ajouter un tags
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['name'])) {
        $tag_name = htmlspecialchars(strip_tags($_POST['name']));

        $tag->name = $tag_name;
        if ($tag->create()) {
            header("Location: ../../public/pages/tag.php");
        } else {
            echo "Failed to create tag.";
        }
    } else {
        echo "tag name is required.";
    }
} else {
    echo "Invalid request method.";
}

// delete un tag
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $tag_id = $_GET['id'];

    if (!empty($tag_id)) {
        $tag->id = $tag_id;
        if ($tag->delete()) {
            header("Location: ../../public/pages/tag.php");
            exit();
        } else {
            echo "Failed to delete tag.";
        }
    } else {
        echo "Invalid tag ID.";
    }
}




?>

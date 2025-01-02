<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\categories\Category;

$database = new Database("dev_blog");
$db = $database->getConnection();

$category = new Category($db);

// ajouter un category
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['name'])) {
        $category_name = htmlspecialchars(strip_tags($_POST['name']));

        $category->name = $category_name;
        if ($category->create()) {
            header("Location: ../../public/pages/categorie.php");
        } else {
            echo "Failed to create category.";
        }
    } else {
        echo "Category name is required.";
    }
} else {
    echo "Invalid request method.";
}

// delete un categorie
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $category_id = $_GET['id'];

    if (!empty($category_id)) {
        $category->id = $category_id;
        if ($category->delete()) {
            header("Location: ../../public/pages/categorie.php");
            exit();
        } else {
            echo "Failed to delete category.";
        }
    } else {
        echo "Invalid category ID.";
    }
}

?>

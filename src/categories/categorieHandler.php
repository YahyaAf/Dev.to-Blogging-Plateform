<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\categories\Category;

$database = new Database("dev_blog");
$db = $database->getConnection();

$category = new Category($db);

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


?>

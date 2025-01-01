<?php
require_once '../../vendor/autoload.php'; 
use config\Database;
use Src\categories\Categorie;


$database = new Database("dev_blog");  
$db = $database->getConnection();


$category = new Categorie($db);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
      
        $category_name = htmlspecialchars(strip_tags($_POST['name'])); 
        $category->name = $category_name;

        if ($category->create()) {
            echo "Category created successfully!";
        } else {
            echo "Failed to create category.";
        }
    }

    if (isset($_POST['update'])) {
        if (isset($_POST['id']) && isset($_POST['name'])) {
            $category->id = $_POST['id']; 
            $category->name = $_POST['name']; 

            if ($category->update()) {
                echo "Category updated successfully!";
            } else {
                echo "Failed to update category.";
            }
        }
    }

    if (isset($_POST['delete'])) {
        if (isset($_POST['id'])) {
            $category->id = $_POST['id']; 

            if ($category->delete()) {
                echo "Category deleted successfully!";
            } else {
                echo "Failed to delete category.";
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'read') {
    $categories = $category->read();
    if ($categories) {
        foreach ($categories as $cat) {
            echo "ID: " . $cat['id'] . " - Name: " . $cat['name'] . "<br>";
        }
    } else {
        echo "No categories found.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'readOne' && isset($_GET['id'])) {
    $category->id = $_GET['id'];
    $cat = $category->readOne();
    if ($cat) {
        echo "ID: " . $cat['id'] . " - Name: " . $cat['name'];
    } else {
        echo "Category not found.";
    }
}
?>

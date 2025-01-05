<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\articles\Article;

$database = new Database("dev_blog");
$db = $database->getConnection();

$article = new Article($db);

// Ajouter un article
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['title'], $_POST['content'], $_POST['categorie']) &&
        !empty($_POST['title']) &&
        !empty($_POST['content']) &&
        !empty($_POST['categorie'])
    ) {
        $title = htmlspecialchars(strip_tags($_POST['title']));
        $content = htmlspecialchars(strip_tags($_POST['content']));
        $excerpt = isset($_POST['excerpt']) ? htmlspecialchars(strip_tags($_POST['excerpt'])) : null;
        $meta_description = isset($_POST['meta_description']) ? htmlspecialchars(strip_tags($_POST['meta_description'])) : null;
        $featured_image = isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK 
            ? uploadImage($_FILES['featured_image']) 
            : null;
        $status = $_POST['status'];
        $scheduled_date = isset($_POST['scheduled_date']) ? $_POST['scheduled_date'] : null;
        $category_id = htmlspecialchars(strip_tags($_POST['categorie']));
        
        $author_id = isset($_POST['author_id']) ? $_POST['author_id'] : null;

        $data = [
            'title' => $title,
            'slug' => generateSlug($title),
            'content' => $content,
            'excerpt' => $excerpt,
            'meta_description' => $meta_description,
            'featured_image' => $featured_image,
            'status' => $status,
            'scheduled_date' => $scheduled_date,
            'category_id' => $category_id,
            'author_id' => $author_id,  
            'tags' => isset($_POST['tags']) ? $_POST['tags'] : [] 
        ];

        if ($article->create($data)) {
            header("Location: ../../public/pages/article.php");
        } else {
            echo "Failed to create article. Please check your input and try again.";
            echo "<pre>";
            var_dump($data); 
            echo "</pre>";
        }
    } else {
        echo "All required fields must be filled.";
    }
} else {
    echo "Invalid request method.";
}

function uploadImage($file)
{
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $targetFile = $targetDir . basename($file['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        return null;
    }

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return $targetFile;
    } else {
        echo "Failed to upload image.";
        return null;
    }
}

function generateSlug($title)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    return $slug;
}

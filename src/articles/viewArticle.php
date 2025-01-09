<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';
use config\Database;
use Src\articles\Article;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../../pages/home.php');
    exit();
}

$articleId = intval($_GET['id']);
$role = $_SESSION['user']['role'] ?? null;

if ($role === 'user') {
    try {
        $database = new Database("dev_blog");
        $db = $database->getConnection();
        $article = new Article($db);

        $article->incrementViews($articleId);

    } catch (PDOException $e) {
        error_log("Error incrementing article views: " . $e->getMessage());
    }
}

header("Location: ../../public/pages/detailsArticle.php?id=$articleId");
exit();

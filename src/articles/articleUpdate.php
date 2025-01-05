<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\articles\Article;
use Src\categories\Category;
use Src\tags\Tag;

$database = new Database("dev_blog");
$db = $database->getConnection();

$article = new Article($db);
$category = new Category($db);
$tag = new Tag($db);

$categories = $category->read();
$tags = $tag->read();

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
    $article_data = $article->read($article_id);

    if ($article_data) {
        $current_title = $article_data['title'];
        $current_content = $article_data['content'];
        $current_excerpt = $article_data['excerpt'];
        $current_meta_description = $article_data['meta_description'];
        $current_category_id = $article_data['category_id'];
        $current_tags = $article_data['tags'];
        $current_status = $article_data['status'];
        $current_featured_image = $article_data['featured_image'];
        $current_scheduled_date = $article_data['scheduled_date'];
    } else {
        echo "Article not found!";
        exit();
    }
} else {
    echo "Article ID is missing!";
    exit();
}

function generateSlug($title) {
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug); 
    $slug = preg_replace('/-+/', '-', $slug); 
    $slug = trim($slug, '-'); 

    return $slug;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['title'], $_POST['content'], $_POST['categorie'])) {
    $title = htmlspecialchars(strip_tags($_POST['title']));
    $content = htmlspecialchars(strip_tags($_POST['content']));
    $excerpt = isset($_POST['excerpt']) ? htmlspecialchars(strip_tags($_POST['excerpt'])) : null;
    $meta_description = isset($_POST['meta_description']) ? htmlspecialchars(strip_tags($_POST['meta_description'])) : null;
    $status = $_POST['status'];
    $category_id = htmlspecialchars(strip_tags($_POST['categorie']));
    $scheduled_date = $_POST['scheduled_date'] ?? null;

    $featured_image = isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK
        ? uploadImage($_FILES['featured_image'])
        : $current_featured_image;

    $selected_tags = isset($_POST['tags']) ? $_POST['tags'] : [];

    $data = [
        'id' => $article_id,
        'title' => $title,
        'slug' => generateSlug($title),
        'content' => $content,
        'excerpt' => $excerpt,
        'meta_description' => $meta_description,
        'featured_image' => $featured_image,
        'status' => $status,
        'scheduled_date' => $scheduled_date,
        'category_id' => $category_id,
        'tags' => $selected_tags
    ];

    if ($article->update($article_id, $data)) {
        header("Location: ../../public/pages/article.php");
        exit();
    } else {
        echo "Failed to update article.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<div class="bg-gray-800 shadow-lg rounded-lg w-full max-w-2xl mx-auto p-8">
    <main class="w-full flex-grow p-6">
        <h1 class="text-2xl font-bold text-gray-100 mb-6">Update Article</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Hidden input for article ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($article_id); ?>">

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-400">Title</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="<?php echo htmlspecialchars($current_title); ?>"
                    class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" 
                    placeholder="Enter title" 
                    required
                />
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-400">Content</label>
                <textarea 
                    id="content" 
                    name="content" 
                    class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" 
                    placeholder="Enter content" 
                    rows="5"
                    required
                ><?php echo htmlspecialchars($current_content); ?></textarea>
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-sm font-medium text-gray-400">Excerpt</label>
                <textarea 
                    id="excerpt" 
                    name="excerpt" 
                    class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" 
                    placeholder="Enter excerpt" 
                    rows="2"
                ><?php echo htmlspecialchars($current_excerpt); ?></textarea>
            </div>

            <!-- Meta Description -->
            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-400">Meta Description</label>
                <textarea 
                    id="meta_description" 
                    name="meta_description" 
                    class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" 
                    placeholder="Enter meta description" 
                    rows="2"
                ><?php echo htmlspecialchars($current_meta_description); ?></textarea>
            </div>

            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-400">Featured Image</label>
                <input 
                    type="file" 
                    id="featured_image" 
                    name="featured_image" 
                    class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" 
                />
                <?php if ($current_featured_image): ?>
                    <img src="./<?php echo htmlspecialchars($current_featured_image); ?>" alt="Current Image" class="mt-2 w-32 h-32 object-cover rounded-md">
                <?php endif; ?>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-400">Status</label>
                <select 
                    id="status" 
                    name="status" 
                    class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                    required
                >
                    <option value="draft" <?php echo ($current_status == 'draft') ? 'selected' : ''; ?>>Draft</option>
                    <option value="published" <?php echo ($current_status == 'published') ? 'selected' : ''; ?>>Published</option>
                    <option value="scheduled" <?php echo ($current_status == 'scheduled') ? 'selected' : ''; ?>>Scheduled</option>
                </select>
            </div>

            <!-- Category -->
            <div>
                <label for="categorie" class="block text-sm font-medium text-gray-400">Category</label>
                <select 
                    id="categorie" 
                    name="categorie" 
                    class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                    required
                >
                    <option value="">--Please choose a category--</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($current_category_id == $cat['id']) ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tags -->
            <div>
                <label for="tags" class="block text-sm font-medium text-gray-400">Tags</label>
                <select 
                    id="tags" 
                    name="tags[]" 
                    multiple 
                    class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                >
                    <?php foreach ($tags as $tagItem): ?>
                        <option value="<?php echo $tagItem['id']; ?>" <?php echo in_array($tagItem['id'], explode(',', $current_tags)) ? 'selected' : ''; ?>><?php echo $tagItem['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Scheduled Date -->
            <div>
                <label for="scheduled_date" class="block text-sm font-medium text-gray-400">Scheduled Date</label>
                    <input 
                        type="datetime-local" 
                        id="scheduled_date" 
                        name="scheduled_date"
                        value="<?php echo htmlspecialchars($current_scheduled_date); ?>"
                        class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" 
                    />
                </div>

            <!-- Submit button -->
            <div class="flex justify-between">
                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded">Update Article</button>
            </div>
        </form>
    </main>
</div>
</body>
</html>
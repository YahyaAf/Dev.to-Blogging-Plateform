<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    use config\Database;
    use Src\categories\Category;
    use Src\tags\Tag;
    session_start();

    $database = new Database("dev_blog");
    $db = $database->getConnection();

    $category = new Category($db);

    $categories = $category->read();

    // tags
    $database = new Database("dev_blog");
    $db = $database->getConnection();

    $tag = new Tag($db);

    $tags = $tag->read();
?>
<?php
    use Src\articles\Article;

    $articleObj = new Article($db);

    $articles = $articleObj->readAll(); 

    $id = isset($_GET['id']) ? htmlspecialchars(strip_tags($_GET['id'])) : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = $_POST['status'];
    $id = isset($_POST['id']) ? htmlspecialchars(strip_tags($_POST['id'])) : null; 

    $data = [
        'id' => $id,
        'status' => $status,
    ];

    if ($articleObj->updateStatus($id, $data)) {
        header("Location: publication.php"); 
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
    <title>Publication</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background:rgb(44, 44, 45); }
        .cta-btn { background:rgb(44, 44, 45); }
        .upgrade-btn { background:rgb(44, 44, 45); }
        .upgrade-btn:hover { background:rgb(44, 44, 45); }
        .active-nav-link { background:rgb(44, 44, 45); }
        .nav-item:hover { background:rgb(44, 44, 45); }
        .account-link:hover { background:rgb(44, 44, 45); }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">
    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="../index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="home.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-home mr-3"></i>
                Home
            </a>
            <a href="utilisateur.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-users mr-3"></i>
                utilisateurs
            </a>
            <a href="categorie.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-th-list mr-3"></i>
                categories
            </a>
            <a href="tag.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-tags mr-3"></i>
                tags
            </a>
            <a href="article.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-file-alt mr-3"></i>
                articles
            </a>
            <a href="publication.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-file-alt mr-3"></i>
                publication
            </a>
        </nav>
        <a href="#" class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
            <i class="fas fa-arrow-circle-up mr-3"></i>
            Upgrade to Pro!
        </a>
    </aside>

    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
            <div class="w-1/2"></div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="<?php echo $_SESSION['user']['profile_picture_url'] ?>" alt="">
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="profile.php" class="block px-4 py-2 account-link hover:text-white">Account</a>
                    <a href="#" class="block px-4 py-2 account-link hover:text-white">Support</a>
                    <a href="../../src/users/logoutHandler.php" class="block px-4 py-2 account-link hover:text-white">Sign Out</a>
                </div>
            </div>
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                <a href="home.html" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-home mr-3"></i>
                    Home
                </a>
                <a href="utilisateur.php" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-users mr-3"></i>
                    utilisateurs
                </a>
                <a href="categorie.php" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-th-list mr-3"></i>
                    categories
                </a>
                <a href="tag.php" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-tags mr-3"></i>
                    tags
                </a>
                <a href="article.php" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-file-alt mr-3"></i>
                    articles
                </a>
                <a href="publication.php" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-file-alt mr-3"></i>
                    publication
                </a>
                <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-cogs mr-3"></i>
                    Support
                </a>
                <a href="profile.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-user mr-3"></i>
                    My Account
                </a>
                <a href="../../src/users/logoutHandler.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Sign Out
                </a>
                <button class="w-full bg-white cta-btn font-semibold py-2 mt-3 rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-arrow-circle-up mr-3"></i> Upgrade to Pro!
                </button>
            </nav>
            <!-- <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button> -->
        </header>
        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h2 class="text-2xl font-semibold mb-6 text-center text-white">Articles List :</h2>
                <table class="w-full table-auto bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <thead>
                        <tr class="bg-gray-700 text-white">
                            <th class="px-6 py-3 text-left text-sm font-semibold">Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Category</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Tags</th> 
                            <th class="px-6 py-3 text-left text-sm font-semibold">Scheduled Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Author</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($articles)): ?>
                            <?php foreach ($articles as $article): ?>
                                <tr class="border-t border-gray-600 hover:bg-gray-700 transition duration-200">
                                    <td class="px-6 py-4 text-gray-200"><?php echo htmlspecialchars($article['title']); ?></td>
                                    <td class="px-6 py-4 text-gray-200">
                                        <img src="<?php echo '../../src/articles/'.$article['featured_image']; ?>" alt="image" class="rounded-lg w-16 h-16 object-cover">
                                    </td>
                                    <td class="px-6 py-4 text-gray-200"><?php echo htmlspecialchars($article['category_name']); ?></td>
                                    <td class="px-6 py-4 text-gray-200">
                                        <?php echo htmlspecialchars($article['tags'] ?: 'No tags'); ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-200"><?php echo htmlspecialchars($article['scheduled_date']); ?></td>
                                    <td class="px-6 py-4 text-gray-200"><?php echo htmlspecialchars($article['author_name']); ?></td>
                                    <td class="px-6 py-4">
                                    <form action="publication.php" method="POST" class="flex items-center space-x-3">
                                        <!-- Hidden input to store article ID -->
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($article['id']); ?>">

                                        <!-- Status dropdown with selected value -->
                                        <select name="status" id="status_<?php echo $article['id']; ?>" class="bg-gray-700 text-white border border-gray-600 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                            <option value="draft" <?php echo $article['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                            <option value="published" <?php echo $article['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                        </select>

                                        <!-- Save button -->
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                            Save
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">No articles found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>                  
            </main>
        </div>

            <footer class="w-full bg-white text-right p-4">
                Built by <a target="_blank" href="https://www.linkedin.com/in/yahya-afadisse-236b022a9/" class="underline">Yahya Afadisse</a>.
            </footer>
        </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>
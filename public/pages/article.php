<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    use config\Database;
    use Src\categories\Category;
    use Src\tags\Tag;

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

    // Fetch all articles
    $articles = $articleObj->readAll(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
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
                    <img src="../assets/images/me.png" alt="">
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="#" class="block px-4 py-2 account-link hover:text-white">Account</a>
                    <a href="#" class="block px-4 py-2 account-link hover:text-white">Support</a>
                    <a href="#" class="block px-4 py-2 account-link hover:text-white">Sign Out</a>
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
                <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-cogs mr-3"></i>
                    Support
                </a>
                <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-user mr-3"></i>
                    My Account
                </a>
                <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
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
            <div class="bg-gray-800 shadow-lg rounded-lg w-full max-w-2xl mx-auto p-8">
                <main class="w-full flex-grow p-6">
                    <h1 class="text-2xl font-bold text-gray-100 mb-6">Create Article</h1>
                    <form action="../../src/articles/articleHandler.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-400">Title</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
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
                            ></textarea>
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
                            ></textarea>
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
                            ></textarea>
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
                        </div>
                        <!-- categorie  -->
                        <div>
                            <label for="categorie" class="block text-sm font-medium text-gray-400">Categorie</label>
                            <select 
                                id="categorie" 
                                name="categorie" 
                                class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                required
                            >
                                <option value="">--Please choose a category--</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo htmlspecialchars($cat['id']); ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- tags  -->
                        <select 
                            id="tags" 
                            name="tags[]" 
                            class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                            multiple
                        >
                            <?php foreach ($tags as $tag): ?>
                                <option value="<?php echo htmlspecialchars($tag['id']); ?>">
                                    <?php echo htmlspecialchars($tag['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Scheduled Date -->
                        <div>
                            <label for="scheduled_date" class="block text-sm font-medium text-gray-400">Scheduled Date</label>
                            <input 
                                type="datetime-local" 
                                id="scheduled_date" 
                                name="scheduled_date" 
                                class="w-full mt-1 p-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 focus:outline-none" 
                            />
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button 
                                type="submit" 
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 focus:ring focus:ring-blue-500"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </main>
            </div>
            <h2 class="text-xl font-semibold mb-4 text-center">Articles List :</h2>
            <table class="w-full table-auto bg-gray-700 rounded-md shadow-md">
                <thead>
                    <tr class="bg-gray-600">
                        <th class="px-4 py-2 text-left text-white">Title</th>
                        <th class="px-4 py-2 text-left text-white">Image</th>
                        <th class="px-4 py-2 text-left text-white">Category</th>
                        <th class="px-4 py-2 text-left text-white">Tags</th> 
                        <th class="px-4 py-2 text-left text-white">Scheduled Date</th>
                        <th class="px-4 py-2 text-left text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <tr class="border-t border-gray-600">
                                <td class="px-4 py-2 text-gray-200"><?php echo htmlspecialchars($article['title']); ?></td>
                                <td class="px-4 py-2 text-gray-200">
                                    <img src="<?php echo '../../src/articles/'.$article['featured_image']; ?>" alt="image" class="rounded-lg" width="50">
                                </td>
                                <td class="px-4 py-2 text-gray-200"><?php echo htmlspecialchars($article['category_name']); ?></td>
                                <td class="px-4 py-2 text-gray-200">
                                    <?php echo htmlspecialchars($article['tags'] ?: 'No tags'); ?>
                                </td>
                                <td class="px-4 py-2 text-gray-200"><?php echo htmlspecialchars($article['scheduled_date']); ?></td>
                                <td class="px-4 py-2">
                                    <a href="../../src/articles/articleUpdate.php?id=<?php echo $article['id']; ?>" class="text-yellow-500 hover:text-yellow-300 mr-2">Update</a>
                                    <a href="../../src/articles/articleHandler.php?id=<?php echo $article['id']; ?>" class="text-red-500 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this article?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-gray-400">No articles found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
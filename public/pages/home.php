<?php
    session_start();
    if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['role'] !== 'author')) {
        header('Location: erreur404.php');
        exit();
    }

    require_once __DIR__ . '/../../vendor/autoload.php';

    use config\Database;
    use Src\articles\Article;
    use Src\categories\Category;
    use Src\tags\Tag;
    use Src\users\User;

    $database = new Database("dev_blog");
    $db = $database->getConnection();
    $article = new Article($db);
    $articleCount = $article->countArticles();
    $category = new Category($db);
    $categoryCount = $category->countCategories();
    $tag = new Tag($db);
    $tagCount = $tag->countTags();
    $user = new User($db);
    $userCount = $user->countUsers();

    // affiche top author
    $topAuthors = $article->getTopAuthors();

    // affiche top articles 
    $topArticles = $article->getTopArticlesByViews();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
            <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="home.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-home mr-3"></i>
                Home
            </a>
            
            <?php if ($_SESSION['user']['role'] === 'admin') { ?>
                <!-- Admin-only links -->
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
                <a href="publication.php" class="flex items-center text-white py-4 pl-6 nav-item">
                    <i class="fas fa-file-alt mr-3"></i>
                    publication
                </a>
            <?php } ?>

            <?php if ($_SESSION['user']['role'] === 'author') { ?>
                <a href="article.php" class="flex items-center text-white py-4 pl-6 nav-item">
                    <i class="fas fa-file-alt mr-3"></i>
                    articles
                </a>
            <?php } ?>
        </nav>
        <a href="#" class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
            <i class="fas fa-arrow-circle-up mr-3"></i>
            Upgrade to Pro!
        </a>
    </aside>
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
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
                    <a href="profile.php" class="block px-4 py-2 account-link hover:text-white">Support</a>
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
            <!-- Home link is visible for both admin and author -->
            <a href="home.php" class="flex items-center text-white py-2 pl-4 nav-item">
                <i class="fas fa-home mr-3"></i>
                Home
            </a>

            <?php if ($_SESSION['user']['role'] === 'admin') { ?>
                <!-- Admin-only links -->
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
            <?php } ?>

            <?php if ($_SESSION['user']['role'] === 'author') { ?>
                <!-- Articles link is visible for both admin and author -->
                <a href="article.php" class="flex items-center text-white py-2 pl-4 nav-item">
                    <i class="fas fa-file-alt mr-3"></i>
                    articles
                </a>
            <?php } ?>

            <!-- Support and My Account are always visible -->
            <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fas fa-cogs mr-3"></i>
                Support
            </a>
            <a href="profile.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fas fa-user mr-3"></i>
                My Account
            </a>

            <!-- Sign Out link is always visible -->
            <a href="../../src/users/logoutHandler.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Sign Out
            </a>

            <!-- Upgrade button is always visible -->
            <button class="w-full bg-white cta-btn font-semibold py-2 mt-3 rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-arrow-circle-up mr-3"></i> Upgrade to Pro!
            </button>
        </nav>

            <!-- <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button> -->
        </header>
    
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Statistique :</h1>
                <div class="flex space-x-4 justify-center">
                    <!-- Card 1 -->
                    <div class="flex justify-between items-center w-64 bg-gray-800 text-gray-200 px-6 py-4 rounded-lg shadow-lg">
                        <span class="font-bold text-lg">Articles</span>
                        <span class="text-2xl font-semibold"><?php echo $articleCount; ?></span>
                    </div>

                    <!-- Card 2 -->
                    <div class="flex justify-between items-center w-64 bg-gray-800 text-gray-200 px-6 py-4 rounded-lg shadow-lg">
                        <span class="font-bold text-lg">Users</span>
                        <span class="text-2xl font-semibold"><?php echo $userCount; ?></span>
                    </div>

                    <!-- Card 3 -->
                    <div class="flex justify-between items-center w-64 bg-gray-800 text-gray-200 px-6 py-4 rounded-lg shadow-lg">
                        <span class="font-bold text-lg">Tags</span>
                        <span class="text-2xl font-semibold"><?php echo $tagCount; ?></span>
                    </div>

                    <!-- Card 4 -->
                    <div class="flex justify-between items-center w-64 bg-gray-800 text-gray-200 px-6 py-4 rounded-lg shadow-lg">
                        <span class="font-bold text-lg">Categories</span>
                        <span class="text-2xl font-semibold"><?php echo $categoryCount; ?></span>
                    </div>
                </div>

                <div class="flex justify-between mt-8 gap-5">
                    <!-- Top Authors Card -->
                    <div class="w-11/12 max-w-4xl rounded-lg overflow-hidden shadow-xl bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white">
                        <div class="px-6 py-4">
                            <div class="font-bold text-2xl mb-4 text-center">Top Authors</div>
                            <div class="space-y-4">
                                <?php foreach ($topAuthors as $author): ?>
                                    <div>
                                        <div class="flex items-center justify-between ">
                                            <div class="text-lg font-semibold"><?php echo htmlspecialchars($author['author_name']); ?></div>
                                            <div class="text-sm text-gray-400">Author</div>
                                        </div>
                                        <div class="text-gray-300 text-sm border-b border-gray-700 pb-4 flex gap-3">
                                            <div>Articles: <span class="font-semibold"><?php echo $author['article_count']; ?></span></div>
                                            <div>Views: <span class="font-semibold"><?php echo $author['total_views']; ?></span></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Most Read Articles Card -->
                    <div class="w-11/12 max-w-4xl rounded-lg overflow-hidden shadow-xl bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white">
                        <div class="px-6 py-4">
                            <div class="font-bold text-2xl mb-4 text-center">Most Read Articles</div>
                            <div class="space-y-4">
                                <?php foreach ($topArticles as $article) : ?>
                                    <div class="flex items-center justify-between border-b border-gray-700 pb-4">
                                        <div class="text-lg font-semibold"><?= htmlspecialchars($article['title']) ?></div>
                                        <div class="text-sm text-gray-400">Published on: <?= htmlspecialchars($article['scheduled_date']) ?></div>
                                        <div class="text-gray-300 text-sm">
                                            <div>Views: <span class="font-semibold"><?= htmlspecialchars($article['views']) ?></span></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
            
            <footer class="w-full bg-white text-right p-4">
                Built by <a target="_blank" href="https://www.linkedin.com/in/yahya-afadisse-236b022a9/" class="underline">Yahya Afadisse</a>.
            </footer>
        </div>






    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

    <script>
        var chartOne = document.getElementById('chartOne');
        var myChart = new Chart(chartOne, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var chartTwo = document.getElementById('chartTwo');
        var myLineChart = new Chart(chartTwo, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
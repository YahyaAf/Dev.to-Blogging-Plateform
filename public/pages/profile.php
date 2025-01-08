<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use config\Database;
use Src\users\User;

session_start();

if (!isset($_SESSION['user']['id'])) {
    echo "User not logged in!";
    exit();
}

$userId = $_SESSION['user']['id'];

$database = new Database("dev_blog");
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(strip_tags($_POST['username']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $profile_picture_url = htmlspecialchars(strip_tags($_POST['profile_picture_url']));
    $role = htmlspecialchars(strip_tags($_POST['role']));

    if ($user->update($userId, $username, $email, $profile_picture_url, $role)) {
        header("Location: ../../public/pages/home.php");
        exit();
    } else {
        echo "Failed to update profile.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>
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
        <main class="flex items-center justify-center w-full h-screen p-6">
            <div class="w-full max-w-7xl grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Card for Player's Formation -->
                <div class="bg-gray-800 rounded-xl shadow-lg p-8 flex items-center justify-center">
                    <div class="w-full max-w-xs bg-gray-700 rounded-xl p-6">
                        <h2 class="text-2xl font-extrabold text-center text-gray-100 mb-6">Player Formation</h2>
                        <!-- Player Information Card -->
                        <div class="text-center text-gray-200">
                            <img 
                                src="<?php echo $_SESSION['user']['profile_picture_url']; ?>"
                                alt="Player Image" 
                                class="w-32 h-32 mx-auto rounded-full mb-4 border-4 border-blue-500">
                            <h3 class="text-xl font-bold mb-2"><?php echo $_SESSION['user']['username']; ?></h3>
                            <p class="text-sm"><?php echo $_SESSION['user']['role']; ?></p>
                            <p class="mt-2"><?php echo $_SESSION['user']['email']; ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side: Profile Update Form -->
                <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-lg p-8">
                    <h2 class="text-3xl font-extrabold text-center text-gray-100 mb-6">Update Profile</h2>
                    <form action="profile.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                            <input 
                                value="<?php echo $_SESSION['user']['username'] ?>"
                                type="text" 
                                id="username" 
                                name="username" 
                                class="w-full mt-1 px-4 py-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="Enter your username" 
                                required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                            <input 
                                value="<?php echo $_SESSION['user']['email'] ?>"
                                type="email" 
                                id="email" 
                                name="email" 
                                class="w-full mt-1 px-4 py-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="Enter your email" 
                                required>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300">New Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full mt-1 px-4 py-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="Enter a new password" 
                                required>
                        </div>

                        <!-- Profile Picture -->
                        <div>
                            <label for="profile_picture" class="block text-sm font-medium text-gray-300">Profile Picture</label>
                            <input 
                                value="<?php echo $_SESSION['user']['profile_picture_url'] ?>"
                                type="url" 
                                id="profile_picture"
                                placeholder="Enter a new profile picture"  
                                name="profile_picture" 
                                class="w-full mt-1 px-4 py-3 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg cursor-pointer focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full px-4 py-3 text-white bg-blue-600 hover:bg-blue-700 font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Save Changes
                        </button>
                    </form>
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
    <script src="../assets/js/scripts.js"></script>
</body>
</html>
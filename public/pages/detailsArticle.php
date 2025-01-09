<?php

require_once __DIR__ . '/../../vendor/autoload.php';
    use config\Database;
    use Src\articles\Article;
    use Src\users\User;
    session_start();
    
    $database = new Database("dev_blog");
    $db = $database->getConnection();
    $user = new User($db);


    $articleObj = new Article($db); 

if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    $article = $articleObj->read($articleId);

    if ($article === null) {
        echo "Article not found.";
        exit;
    }
} else {
    echo "Invalid article ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white min-h-screen flex flex-col">

  <!-- Navbar -->
  <nav class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo -->
      <a href="#" class="text-white text-2xl font-bold tracking-wide">
        Dev.to-Blogging-Plateform
      </a>

      <!-- Signup and Login Buttons -->
      <div class="flex space-x-4">
          <?php if ($user->isLoggedIn()): ?>
            <div class="relative">
            <button 
              id="userMenuButton"
              class="flex items-center space-x-2 bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-lg shadow transition duration-300"
            >
              <img 
                src="<?php echo $_SESSION['user']['profile_picture_url'] ?>" 
                alt="User Profile" 
                class="w-8 h-8 rounded-full"
              >
              <span><?php echo $_SESSION['user']['username'] ?></span>
            </button>
            <div 
              id="userMenu"
              class="absolute right-0 mt-2 w-48 bg-gray-800 text-white rounded-lg shadow-lg hidden"
            >
              <a 
                href="pages/account.php" 
                class="block px-4 py-2 hover:bg-gray-700 rounded-t-lg transition duration-300"
              >
                Account
              </a>
              <a 
                href="../src/users/logoutHandler.php" 
                class="block px-4 py-2 hover:bg-gray-700 rounded-b-lg transition duration-300"
              >
                Logout
              </a>
            </div>
          </div>
          <?php else: ?>
              <a href="pages/signup.php" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow transition duration-300">
                Sign Up
              </a>
              <a href="pages/login.php" class="bg-gray-700 hover:bg-gray-800 text-white py-2 px-4 rounded-lg shadow transition duration-300">
                Login
              </a>
          <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Article Detail Section -->
<div class="container mx-auto mt-10 px-6 md:px-0">
  <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black rounded-lg shadow-xl p-6 text-white flex flex-col md:flex-row">
    
    <!-- Article Image -->
    <div class="md:w-1/3 mb-6 md:mb-0">
      <img 
        src="../../src/articles/<?php echo htmlspecialchars($article['featured_image']); ?>" 
        alt="Article Image" 
        class="rounded-lg shadow-lg w-full h-auto object-cover"
      >
    </div>
    
    <!-- Article Content -->
    <div class="md:w-2/3 md:ml-6">
      <h1 class="text-3xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
        <?php echo htmlspecialchars($article['title']); ?>
      </h1>

      <p class="text-sm text-gray-400 mb-4">
        <span class="font-semibold text-gray-300">Published on:</span> <?php echo htmlspecialchars($article['scheduled_date']); ?>
      </p>

      <div class="mb-6">
        <p class="text-gray-300 text-lg"><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
      </div>

      <div class="flex space-x-6">
        <div class="text-gray-400 text-sm">
          <span class="font-semibold text-gray-300">Category:</span> <?php echo htmlspecialchars($article['category_name']); ?>
        </div>
        <div class="text-gray-400 text-sm">
          <span class="font-semibold text-gray-300">Tags:</span> <?php echo htmlspecialchars($article['tags'] ?: 'No tags'); ?>
        </div>
        <div class="text-gray-400 text-sm">
          <span class="font-semibold text-gray-300">Views:</span> <?php echo htmlspecialchars($article['views']); ?>
        </div>
      </div>

      <!-- Go Back Button -->
      <div class="mt-6">
        <a
        href="../index.php"
          class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md font-semibold transition-all duration-300"
        >
          Go Back
          </a>
      </div>
    </div>
  </div>
</div>



  <!-- Footer -->
  <footer class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-6 mt-auto">
    <div class="container mx-auto text-center text-white">
      <div class="flex justify-center space-x-6 mb-4">
        <a href="#" class="hover:text-blue-500 transition duration-300">About Us</a>
        <a href="#" class="hover:text-blue-500 transition duration-300">Privacy Policy</a>
        <a href="#" class="hover:text-blue-500 transition duration-300">Terms of Service</a>
      </div>
      <p class="text-sm text-gray-400">&copy; 2025 Dev.to-Blogging-Platform. All rights reserved.</p>
    </div>
  </footer>

  <script>
    // Dropdown Toggle Script
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');

    userMenuButton.addEventListener('click', () => {
      // Toggle the dropdown visibility
      userMenu.classList.toggle('hidden');
    });

    // Optional: Close dropdown if clicked outside
    document.addEventListener('click', (e) => {
      if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
        userMenu.classList.add('hidden');
      }
    });
  </script>
</body>
</html>

<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use config\Database;
use Src\users\User;

$database = new Database("dev_blog");
$db = $database->getConnection();

$user = new User($db);

if ($user->isLoggedIn()) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Enable Tailwind's Dark Mode
        tailwind.config = {
            darkMode: 'class',
        };
    </script>
</head>
<body class="bg-gray-900 text-gray-200 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-center text-gray-100 mb-6">Welcome Back</h2>
        <form action="../../src/users/loginHandler.php" method="POST" class="space-y-4">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter your email" 
                    required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter your password" 
                    required>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                Log In
            </button>

            <!-- Sign-Up Prompt -->
            <p class="text-sm text-center text-gray-400 mt-4">
                Don’t have an account? 
                <a href="signup.php" class="text-blue-400 hover:underline">Sign Up</a>
            </p>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
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
        <h2 class="text-2xl font-bold text-center text-gray-100 mb-6">Create an Account</h2>
        <form action="../../src/users/signupHandler.php" method="POST" enctype="multipart/form-data" class="space-y-4">

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter your username" 
                    required>
            </div>

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
                <label for="password_hash" class="block text-sm font-medium text-gray-300">Password</label>
                <input 
                    type="password" 
                    id="password_hash" 
                    name="password_hash" 
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-200 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter your password" 
                    required>
            </div>

            <!-- Profile Picture -->
            <div>
                <label for="profile_picture_url" class="block text-sm font-medium text-gray-300">Profile Picture</label>
                <input 
                    type="url" 
                    id="profile_picture_url" 
                    name="profile_picture_url" 
                    placeholder="Enter your profile_picture_url" 
                    class="w-full mt-1 px-4 py-2 bg-gray-700 text-gray-400 border border-gray-600 rounded-lg cursor-pointer focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    required>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                Sign Up
            </button>

            <!-- Already have an account -->
            <p class="text-sm text-center text-gray-400 mt-4">
                Already have an account? 
                <a href="login.php" class="text-blue-400 hover:underline">Log in</a>
            </p>
        </form>
    </div>
</body>
</html>

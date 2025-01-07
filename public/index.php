<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dev.to-Blogging-Platform</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
        <a href="signup.html" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow transition duration-300">
          Sign Up
        </a>
        <a href="login.html" class="bg-gray-700 hover:bg-gray-800 text-white py-2 px-4 rounded-lg shadow transition duration-300">
          Login
        </a>
      </div>
    </div>
  </nav>

  <!-- Card Section -->
  <div class="flex justify-center mt-8">
    <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black rounded-lg shadow-2xl p-8 max-w-4xl text-center text-white">
          <!-- Header -->
          <h1 class="text-4xl font-extrabold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
            Welcome to Dev.to-Blogging-Platform
          </h1>

          <!-- Content Section -->
          <div class="flex flex-col md:flex-row items-center md:items-start justify-between space-y-6 md:space-y-0">
              <!-- Text Section -->
              <div>
                <p class="text-gray-300 text-lg leading-relaxed">
                  Dev.to-Blogging-Platform is your go-to destination for creating and sharing high-quality blogs. 
                  Explore insightful content, connect with a community of passionate writers, and grow your audience!
                </p>
              </div>
          </div>
          <div class="mt-6">
            <a href="signup.html" class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg shadow-md text-lg font-semibold transition duration-300">
              Get Started
            </a>
          </div>
      </div>
  </div>


</body>
</html>

# Dev.to-Blogging-Platform

## Project Overview

**Dev.to-Blogging-Platform** is a full-featured content management system designed for developers to share articles, explore relevant content, and collaborate effectively. The platform offers a seamless user experience on the front office and a powerful admin dashboard for managing users, categories, tags, and articles.

---

## Key Features

### Back Office (Administrators)
- **Category Management:**
  - Create, update, and delete categories.
  - Associate multiple articles with a category.
  - View category statistics with interactive graphs.

- **Tag Management:**
  - Create, update, and delete tags.
  - Associate tags with articles for precise searches.
  - View tag statistics with interactive graphs.

- **User Management:**
  - Manage user profiles.
  - Assign author permissions to users.
  - Suspend or delete users for rule violations.

- **Article Management:**
  - Review, accept, or reject submitted articles.
  - Archive inappropriate articles.
  - View most-read articles.

- **Statistics and Dashboard:**
  - Detailed views of users, articles, categories, and tags.
  - Identify the top 3 authors based on published or read articles.
  - Interactive graphs for categories and tags.
  - View the most popular articles.

- **Detail Pages:**
  - Single article page with complete details.
  - Single profile page for user information.

### Front Office (Users)
- **Registration and Login:**
  - Create an account with basic details (name, email, password).
  - Secure login with redirection based on role (admin or user).

- **Navigation and Search:**
  - Interactive search bar for articles, categories, or tags.
  - Dynamic navigation between articles and categories.

- **Content Display:**
  - Display the latest articles on the homepage or a dedicated section.
  - Showcase recently added or updated categories.
  - Redirect to a unique article page with full content details, associated categories, tags, and author information.

- **Author Space:**
  - Create, update, and delete articles.
  - Assign a single category and multiple tags to an article.
  - Manage published articles from a personal dashboard.

---

## Installation and Usage

### Prerequisites
- PHP 8 or later
- Composer
- MySQL database

### Installation
1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```bash
   cd Dev.to-Blogging-Platform
   ```
3. Install dependencies using Composer:
   ```bash
   composer install
   ```

4. Import the provided SQL file to set up the database.
5. Update the database configuration in `config/Database.php`.

### Running the Project
1. Start the PHP development server:
   ```bash
   php -S localhost:8000
   ```
2. Access the application in your browser at `http://localhost:8000`.

---

## Technologies Used

- **Programming Language:** PHP 8 (Object-Oriented Programming)
- **Database:** MySQL with PDO
- **Frontend:** Tailwind CSS
- **Authentication:** Session-based

---

## License

This project is licensed under the MIT License.

---

## Authors

- **Yahya Afadisse**




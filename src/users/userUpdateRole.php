<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use config\Database;
use Src\users\User;

$database = new Database("dev_blog");
$db = $database->getConnection();

$user = new User($db);

$id = isset($_GET['id']) ? htmlspecialchars(strip_tags($_GET['id'])) : null;

if ($id) {
    // Get the current role for the user by ID
    $sql = "SELECT role FROM users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userDetails) {
        $role = $userDetails['role']; // Récupération du rôle
    } else {
        echo "Utilisateur introuvable.";
        exit();
    }
} else {
    echo "ID de l'utilisateur non spécifié.";
    exit();
}

// Handling the form submission for role update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = htmlspecialchars(strip_tags($_POST['id']));
    $role = htmlspecialchars(strip_tags($_POST['role']));

    if ($user->updateRole($id, $role)) {
        header("Location: ../../public/pages/utilisateur.php");
        exit();
    } else {
        echo "Échec de la mise à jour du rôle.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Modifier le rôle</title>
</head>
<body class=" h-screen flex items-center justify-center">

    <div class="container mx-auto p-6 bg-gray-800 shadow-md rounded-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-white">Modifier le rôle</h1>
        <form action="" method="POST" class="space-y-6">

            <!-- Hidden input to store user ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <!-- Select dropdown for roles -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-400">Rôle</label>
                <select id="role" name="role" 
                        class="w-full bg-gray-700 text-gray-300 border-gray-600 rounded-md shadow-sm focus:ring focus:ring-blue-200 px-4 py-2">
                    <option value="admin" <?php echo isset($role) && $role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="user" <?php echo isset($role) && $role === 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="author" <?php echo isset($role) && $role === 'author' ? 'selected' : ''; ?>>Author</option>
                </select>
            </div>
            
            <!-- Submit button -->
            <div>
                <button type="submit" 
                        class="w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Modifier le rôle
                </button>
            </div>
        </form>
    </div>
    
</body>
</html>



<?php 
require 'vendor/autoload.php';

use App\Models\Category;
use App\Models\Student;
use App\Models\Tag;
use App\Models\Enseignant;
use App\Models\User;

$tag = new Tag();
$category = new Category();
$student = new Student();
$enseignant = new Enseignant();
$user = new User;


$totalEnseignant = $enseignant->countEnseignant();

$totalCategory = $category->countCategory();

$totalStudents = $student->countStudents();

$totalTag = $tag->countTags();



$categories = $category->selectAllCategory();
$tags = $tag->selectAllTags();
//si pour verifier les donnes recuperees
$pendingEnseignants = $enseignant->getPendingEnseignants();
// if (empty($pendingEnseignants)) {
//     echo "<p>Aucun enseignant en attente de validation.</p>";
// } else {
//     echo "<pre>";
//     print_r($pendingEnseignants);
//     echo "</pre>";
// }


$users = $user->selectAllusers();
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    switch ($action) {
        case 'activate':
            $user->activateUser($id);
            break;
        case 'suspended':
            $user->suspendUser($id);
            break;
        case 'delete':
            $user->deleteusers($id);
            break;
    }
    header('Location: index.php' );

    exit();
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <style>

        .hidden {
            display: none;
        }
        .popup {
            position: absolute;
            top: 6rem;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
       

</style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
      
        <aside class="w-64 bg-gray-800 text-white fixed h-full">
            <div class="p-4">
                <h2 class="text-2xl font-semibold text-center mb-6">Administrateur</h2>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="nav-link block px-4 py-2 rounded hover:bg-gray-700 transition" data-section="home">
                                Dashboard Home
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link block px-4 py-2 rounded hover:bg-gray-700 transition" data-section="validation">
                                Validation des comptes
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link block px-4 py-2 rounded hover:bg-gray-700 transition" data-section="users">
                                Gestion des utilisateurs
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link block px-4 py-2 rounded hover:bg-gray-700 transition" data-section="content">
                                Gestion des contenus
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link block px-4 py-2 rounded hover:bg-gray-700 transition" data-section="stats">
                                Statistiques Globales
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-md">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex-1 flex items-center space-x-4">
                        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                        <!-- Search Bar -->
                        <div class="flex-1 max-w-2xl">
                            <div class="relative">
                                <input type="search" 
                                       id="searchBar"
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Search...">
                                <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            <div id="currentUser">User: mhamedaithssaine</div>
                            <div id="currentDateTime">2025-01-16 13:10:10 UTC</div>
                        </div>
                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=mhamedaithssaine" alt="Profile">
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                <!-- Home Section (Statistics Overview) -->
                <section id="home" class="section active">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Total Enseignants</div>
                            <div class="text-2xl font-bold"><?php echo $totalEnseignant; ?></div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Total Students</div>
                            <div class="text-2xl font-bold"><?php echo $totalStudents; ?></div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Tags</div>
                            <div class="text-2xl font-bold"><?php echo $totalTag?></div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Categories</div>
                            <div class="text-2xl font-bold"><?php echo $totalCategory?></div>
                        </div>
                    </div>
                    <!-- Additional Statistics Charts could go here -->
                </section>

                <!-- Other sections (initially hidden) -->
                <section id="validation" class="section hidden">
        <!-- Validation content -->
        <h2 class="text-xl font-semibold mb-4">Validation des comptes enseignants</h2>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nom</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Statut</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($pendingEnseignants)): ?>
                    <?php foreach ($pendingEnseignants as $enseignantData): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo $enseignantData['id']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $enseignantData['fullname']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $enseignantData['email']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $enseignantData['status']; ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="app/admin/manage_enseignants.php?action=validate&id=<?php echo $enseignantData['id']; ?>" class="text-green-500">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                                <a href="app/admin/manage_enseignants.php?action=reject&id=<?php echo $enseignantData['id']; ?>" class="text-red-500">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php else : ?>
                        <tr>
                        <td colspan="5" class="py-2 px-4 border-b text-center">Aucun enseignant en attente de validation.</td>

                        </tr>
                        <?php endif; ?>
                </tbody>
            </table>
        
    </section>


                <section id="users" class="section hidden">
                    <!-- Users management content -->
                    <h2 class="text-xl font-semibold mb-4">Gestion des utilisateurs</h2>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Status</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b"><?php echo $user['id']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $user['fullname']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $user['email']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $user['status']; ?></td>
                                    <td class="py-2 px-4 border-b">
                                    <a href="?action=activate&id=<?php echo $user['id']; ?>" class="text-green-500">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                        <a href="?action=suspended&id=<?php echo $user['id']; ?>" class="text-yellow-500">
                                            <i class="fas fa-pause-circle"></i>
                                        </a>
                                        <a href="?action=delete&id=<?php echo $user['id']; ?>" class="text-red-500">
                                            <i class="fas fa-trash-alt"></i>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>

                <section id="content" class="section hidden">
                    <!-- Content management -->
                    <h2 class="text-xl font-semibold mb-4">Gestion des contenus</h2>
                    <h3 class="text-lg font-semibold mb-4">Categories</h3>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded mb-4" onclick="document.getElementById('addCategoryForm').style.display='block';">
                            <i class="fas fa-plus"></i> Add Category
                        </button>
                        <div id="addCategoryForm" class="popup hidden">
                            <form method="POST" action="app/admin/manage_categories.php" class="mb-4">
                                <input type="text" name="name" placeholder="Category Name" required class="border p-2 mb-2 w-full">
                                <textarea name="description" placeholder="Category Description" required class="border p-2 mb-2 w-full"></textarea>
                                <button type="submit" class="bg-blue-500 text-white p-2">
                                    <i class="fas fa-check"></i> 
                                </button>
                                <button type="button" class="bg-gray-500 text-white p-2 popup-close" onclick="document.getElementById('addCategoryForm').style.display='none';">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">ID</th>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Description</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td class="py-2 px-4 border-b"><?php echo $category['id']; ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo $category['name']; ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo $category['description']; ?></td>
                                        <td class="py-2 px-4 border-b">
                                            <a href="#" onclick="document.getElementById('categoryForm<?php echo $category['id']; ?>').style.display='block';" class="text-blue-500">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="app/admin/manage_categories.php?action=delete&id=<?php echo $category['id']; ?>" class="text-red-500">
                                                <i class="fas fa-trash-alt"> </i>
                                            </a>
                                            <div id="categoryForm<?php echo $category['id']; ?>" class="popup hidden">
                                                <form method="POST" action="app/admin/manage_categories.php" class="mb-4">
                                                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                                    <input type="text" name="name" value="<?php echo $category['name']; ?>" placeholder="Category Name" required class="border p-2 mb-2 w-full">
                                                    <textarea name="description" placeholder="Category Description" required class="border p-2 mb-2 w-full"><?php echo $category['description']; ?></textarea>
                                                    <button type="submit" class="bg-blue-500 text-white p-2">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" class="bg-gray-500 text-white p-2 popup-close" onclick="document.getElementById('categoryForm<?php echo $category['id']; ?>').style.display='none';">
                                                        <i class="fas fa-times"></i> 
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <h3 class="text-lg font-semibold mb-4 mt-8">Tags</h3>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded mb-4" onclick="document.getElementById('addTagForm').style.display='block';">
                            <i class="fas fa-plus"></i> Add Tag
                        </button>
                        <div id="addTagForm" class="popup hidden">
                            <form method="POST" action="app/admin/manage_tags.php" class="mb-4">
                                <input type="text" name="name" placeholder="Tag Name" required class="border p-2 mb-2 w-full">
                                <button type="submit" class="bg-blue-500 text-white p-2">
                                    <i class="fas fa-check"></i> 
                                </button>
                                <button type="button" class="bg-gray-500 text-white p-2 popup-close" onclick="document.getElementById('addTagForm').style.display='none';">
                                    <i class="fas fa-times"></i> 
                                </button>
                            </form>
                        </div>
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">ID</th>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tags as $tag): ?>
                                    <tr>
                                        <td class="py-2 px-4 border-b"><?php echo $tag['id']; ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo $tag['name']; ?></td>
                                        <td class="py-2 px-4 border-b">
                                            <a href="#" onclick="document.getElementById('tagForm<?php echo $tag['id']; ?>').style.display='block';" class="text-blue-500">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="app/admin/manage_tags.php?action=delete&id=<?php echo $tag['id']; ?>" class="text-red-500">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <div id="tagForm<?php echo $tag['id']; ?>" class="popup hidden">
                                                <form method="POST" action="app/admin/manage_tags.php" class="mb-4">
                                                    <input type="hidden" name="id" value="<?php echo $tag['id']; ?>">
                                                    <input type="text" name="name" value="<?php echo $tag['name']; ?>" placeholder="Tag Name" required class="border p-2 mb-2 w-full">
                                                    <button type="submit" class="bg-blue-500 text-white p-2">
                                                        <i class="fas fa-check"></i> 
                                                    </button>
                                                    <button type="button" class="bg-gray-500 text-white p-2 popup-close" onclick="document.getElementById('tagForm<?php echo $tag['id']; ?>').style.display='none';">
                                                        <i class="fas fa-times"></i> 
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    
                </section>

                <section id="stats" class="section hidden">
                    <!-- Detailed statistics -->
                    <h2 class="text-xl font-semibold mb-4">Statistiques Globales</h2>
                    <!-- Add detailed statistics here -->
                </section>
            </main>

            <!-- Footer -->
            <footer class="bg-white shadow-md mt-6">
                <div class="text-center p-4 text-sm text-gray-600">
                    © 2025 Admin Dashboard. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const formatted = now.toISOString().replace('T', ' ').substr(0, 19) + ' UTC';
            document.getElementById('currentDateTime').textContent = formatted;
        }
        
        setInterval(updateDateTime, 1000);

        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('.section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    navLinks.forEach(l => l.classList.remove('bg-gray-700'));
                    
                    this.classList.add('bg-gray-700');
                    
                    sections.forEach(section => section.classList.add('hidden'));
                    
                    const sectionId = this.getAttribute('data-section');
                    document.getElementById(sectionId).classList.remove('hidden');
                });
            });
        });

       

      
    </script>
</body>
</html>
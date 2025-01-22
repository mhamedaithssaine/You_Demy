<?php 
require 'vendor/autoload.php';
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: app/components/login.php');
    exit();
}


use App\Models\Category;
use App\Models\Student;
use App\Models\Tag;
use App\Models\Enseignant;
use App\Models\User;
use App\Models\Cours;
use App\Models\Admin;

$tag = new Tag();
$category = new Category();
$student = new Student();
$enseignant = new Enseignant();
$user = new User;
$cours = new Cours();
$admin = new Admin();

//nombre total de category,Enseignant,Category,Tags,Cours

$totalEnseignant = $enseignant->countEnseignant();

$totalCategory = $category->countCategory();

$totalStudents = $student->countStudents();

$totalTag = $tag->countTags();

$totalCours = $cours->countAllCourses();

// recupere Les categories et les tags

$categories = $category->selectAllCategory();
$tags = $tag->selectAllTags();


//si pour verifier les donnes recuperees

$pendingEnseignants = $enseignant->getPendingEnseignants();

// select all user

$users = $user->selectAllusers();


// recupere tous les cours Créer par le enseignant 

$courses = $cours->selectAllCoursEnsiengant();

// methode pour affiche les statique 

$generalStats=$admin->getGeneralStats();

$statsData = json_encode([
    'labels' => ['Total Enseignants', 'Total Etutiants', 'Active Courses', 'Suspende Courses', 'Total Categories'],
    'datasets' => [[
        'label' => 'General Statistics',
        'data' => [
            $generalStats['total_teachers'],
            $generalStats['total_students'],
            $generalStats['active_courses'],
            $generalStats['pending_courses'],
            $generalStats['total_categories']
        ],
        'backgroundColor' => [
            'rgba(54, 162, 235, 1)', 
            'rgba(255, 206, 86, 1)', 
            'rgba(75, 192, 192, 1)', 
            'rgba(153, 102, 255, 1)', 
            'rgba(255, 159, 64, 1)' 
        ],
        'borderWidth' => 1
    ]]
]);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                <h2 class="text-2xl font-semibold text-center mb-6"><div id="currentUser" class="flex items-center space-x-2">
                                <span>You_demy</span>

                            </h2>
                            <div>
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
                                Gestion des Cours
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
                    <div class="text-sm text-gray-600 flex items-center space-x-4">
                          
                            <a href="app/components/logout.php" class="flex items-center space-x-2 bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600">
                                <i class="fas fa-sign-out-alt"></i>
                                
                            </a>
                            <a href="profile.php" class="flex items-center space-x-2 bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600">
                                <i class="fas fa-user"></i>
                            </a>
                            <h2 class="text-2xl font-semibold text-center mb-2"><div id="currentUser" class="flex items-center space-x-2">
                                <span><?php echo $_SESSION['user_name']; ?></span>

                            </h2><div>
                            
                        </div>
                </div>
                
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                <!-- Home Section (Statistics Overview) -->
                <section id="home" class="section active">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <!-- <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Total Enseignants</div>
                            <div class="text-2xl font-bold"><?php // $totalEnseignant; ?></div>
                        </div> -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Total Cours</div>
                            <div class="text-2xl font-bold"><?=  $totalCours; ?></div>
                        </div>
                        <!-- <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Total Students</div>
                            <div class="text-2xl font-bold"><?php // $totalStudents; ?></div>
                        </div> -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Tags</div>
                            <div class="text-2xl font-bold"><?= $totalTag?></div>
                        </div>
                        <!-- <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Categories</div>
                            <div class="text-2xl font-bold"><?php //$totalCategory ?></div>
                        </div> -->
                    </div>
                    <!-- Additional Statistics Charts could go here -->

                    <div style="width: 50%; margin: auto;">
                    <canvas id="statsChart" width="400" height="400"></canvas>
                </div>
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
                                        <th class="py-2 px-4 border-b">Role</th>
                                        <th class="py-2 px-4 border-b">Validation</th>
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
                            <td class="py-2 px-4 border-b"><?php echo $enseignantData['role']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $enseignantData['valide']; ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="app\admin\manage_enseignants.php?action=validate&id=<?php echo $enseignantData['id']; ?>" class="text-green-500">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                                <a href="app\admin\manage_enseignants.php?action=reject&id=<?php echo $enseignantData['id']; ?>" class="text-red-500">
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
                                <th class="py-2 px-4 border-b">Role</th>
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
                                    <td class="py-2 px-4 border-b"><?php echo $user['role']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $user['status']; ?></td>
                                    <td class="py-2 px-4 border-b">
                                    <a href="app/admin/manage_user.php?action=activate&id=<?php echo $user['id']; ?>" class="text-green-500">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                        <a href="app/admin/manage_user.php?action=suspended&id=<?php echo $user['id']; ?>" class="text-yellow-500">
                                            <i class="fas fa-pause-circle"></i>
                                        </a>
                                        <a onclick="return confirm('Are you sure you want to delete this user?');" href="app/admin/manage_user.php?action=delete&id=<?php echo $user['id']; ?>" class="text-red-500">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
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
                             <h2 class="text-xl font-semibold mb-4">gestion de cours </h2>
                  
                                       <table class="table table-bordered w-full" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Content Type</th>
                            <th class="px-4 py-2">Tags</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($courses) && !empty($courses)): ?>
                            <?php foreach ($courses as $cour): ?>
                                <tr>
                                <td class="px-4 py-2">
                                        <?= htmlspecialchars($cour['id']) ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?= htmlspecialchars($cour['title']) ?>
                                    </td>
                                  
                                    <td class="px-4 py-2">
                                        <?= !empty($cour['content_vedio']) ? 'Video' : 'Document' ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php
                                        $tags = $cours->getCourseTags($cour['id']);
                                        if (!empty($tags)) {
                                            foreach ($tags as $tag) {
                                                echo '<span class="bg-blue-200 text-blue-800 text-sm px-2 py-1 rounded-full mr-2 mb-2">' . htmlspecialchars($tag['name']) . '</span>';
                                            }
                                        } else {
                                            echo '<p class="text-gray-500 mt-2">Aucun tag pour ce cours.</p>';
                                        }
                                        ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?= date('M d, Y H:i', strtotime($cour['created_at'])) ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?= htmlspecialchars($cour['status']) ?>
                                    </td>
                                    <td class="px-4 py-2">
                                    <a href="app\admin\manage_cours.php?action=validate&id=<?php echo $cour['id']; ?>" class="text-green-500">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                    <a href="app\admin\manage_cours.php?action=reject&id=<?php echo $cour['id']; ?>" class="text-yellow-500">
                                        <i class="fas fa-pause-circle"></i>
                                    </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No courses available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                                 </table>
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

        const ctx = document.getElementById('statsChart').getContext('2d');
        const statsData = <?php echo $statsData; ?>;
        const statsChart = new Chart(ctx, {
            type: 'pie',
            data: statsData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
        
       
      
      
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
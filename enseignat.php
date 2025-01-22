<?php 
require 'vendor/autoload.php';

// pour fixe le role de user 
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'enseignant') {
    header('Location: app/components/login.php');
    exit();
}



use App\Models\Cours;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Admin;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$userId = $_SESSION['user_id'];

$cours = new Cours();
$courses = $cours->getCoursesByUserId($userId);





$categoryModel = new Category();
$categories = $categoryModel->selectAllCategory();

$tagModel = new Tag();
$tags = $tagModel->selectAllTags();



// pour les statistique 
$admin = new Admin;   
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
                                home
                        </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link block px-4 py-2 rounded hover:bg-gray-700 transition" data-section="validation">
                               Ajouter Cours
                            </a>
                        </li>
                       
                        <li>
                            <a href="#" class="nav-link block px-4 py-2 rounded hover:bg-gray-700 transition" data-section="content">
                                Gestion des contenus
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
            <section id="home" class="section active">
                   
                    <!-- Additional Statistics Charts could go here -->

                    <div style="width: 50%; margin: auto;">
                    <canvas id="statsChart" width="400" height="400"></canvas>
                </div>
                </section>
                
                </section>
           

                <!-- Other sections (initially hidden) -->
                     <section id="validation" class="section hidden">
            
<!-- add content -->
<div class="card">
    <div class="card-header">
    <h2 class="text-xl font-semibold mb-4">Ajouter Cours </h2>
    </div>
    <div class="card-body p-6 bg-white rounded-lg shadow-md">
        <form method="post" action="app/Enseignant/manager_cours.php">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea id="description" name="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
            </div>
            <div class="mb-4">
                <label for="contenu" class="block text-gray-700 text-sm font-bold mb-2">Contenu:</label>
                <select id="contenu" name="contenu" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">--choisi Contenu de cours--</option>
                    <option value="Video">Video</option>
                    <option value="Document">Document</option>
                </select>
            </div>
            <div id="video" class="hidden mb-4">
                <div>
                    <label for="contenu_video" class="block text-gray-700 text-sm font-bold mb-2">Video URL:</label>
                    <input type="text" id="contenu_video" name="contenu_video" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>
            <div id="document" class="hidden mb-4">
                <div>
                    <label for="contenu_document" class="block text-gray-700 text-sm font-bold mb-2">Document cours:</label>
                    <textarea id="contenu_document" name="contenu_document" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                <select id="category_id" name="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tags:</label>
                <div class="flex flex-wrap">
                    <?php foreach ($tags as $tag): ?>
                        <div class="mb-2 mr-2">
                            <input type="checkbox" id="tag_<?php echo $tag['id']; ?>" name="tags[]" value="<?php echo $tag['id']; ?>" class="form-checkbox h-4 w-4 text-blue-600">
                            <label for="tag_<?php echo $tag['id']; ?>" class="ml-2 text-gray-700"><?php echo htmlspecialchars($tag['name']); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-4">
                <label for="scheduled_date" class="block text-gray-700 text-sm font-bold mb-2">Scheduled Date:</label>
                <input type="datetime-local" id="scheduled_date" name="scheduled_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Cours</button>
            </div>
        </form>
    </div>
</div>
    </section>



<section id="content" class="section hidden">
    <!-- Content management -->
    <h2 class="text-xl font-semibold mb-4">Les cours</h2>
    <div class="card shadow mb-4 bg-white rounded-lg shadow-md">
        <div class="card-body p-6">
            <div class="table-responsive">
                <table class="table table-bordered w-full" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Category</th>
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
                                        <?= htmlspecialchars($cour['title']) ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?= htmlspecialchars($cour['category_name']) ?>
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
                                        <a href="app/Enseignant/update_cours.php?id=<?= $cour['id'] ?>" class="">
                                            <i class="fas fa-edit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"></i> 
                                        </a>
                                        <form method="post" action="app/Enseignant/delet_cours.php" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $cour['id'] ?>">
                                            <button type="submit" class="">
                                                <i class="fas fa-trash bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"></i> 
                                            </button>
                                        </form>
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
            </div>
        </div>
    </div>
</section>



            <div class="hidden" >
     
                </div>
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

       
    document.getElementById('contenu').addEventListener('change', function() {
    const videoDiv = document.getElementById('video');
    const documentDiv = document.getElementById('document');
    if (this.value === 'Video') {
        videoDiv.style.display = 'block';
        documentDiv.style.display = 'none';
    } else if (this.value === 'Document') {
        videoDiv.style.display = 'none';
        documentDiv.style.display = 'block';
    } else {
        videoDiv.style.display = 'none';
        documentDiv.style.display = 'none';
    }
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
</body>
</html>
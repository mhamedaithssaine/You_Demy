<?php 
require 'vendor/autoload.php';

use App\Models\Category;

use App\Models\Tag;
use App\Models\Cours;

$category = new Category();
$categories = $category->selectAllCategory();

$tag = new Tag();
$tags = $tag->selectAllTags();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $contenu = $_POST['contenu'];
    $contenu_video = $_POST['contenu_video'] ?? null;
    $contenu_document = $_POST['contenu_document'] ?? null;
    $category_id = $_POST['category_id'];
    $scheduled_date = $_POST['scheduled_date'];

    $cours = new Cours();

    $cours_id = $cours->addCours([
        'title' => $title,
        'description' => $description,
        'content' => $contenu === 'Document' ? $contenu_document : null,
        'content_vedio' => $contenu === 'Video' ? $contenu_video : null,
        'created_at' => $scheduled_date,
        'category_id' => $category_id,
       
    ]);

    if ($cours_id && isset($_POST['tag_id'])) {
        foreach ($_POST['tag_id'] as $tag_id) {
            $cours->addTag($cours_id, $tag_id);
        }
    }

    header('Location: enseignat.php');
}



//affiche le cours 
include 'app/Enseignant/displayCours.php';











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


</style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
      
        <aside class="w-64 bg-gray-800 text-white fixed h-full">
            <div class="p-4">
                <h2 class="text-2xl font-semibold text-center mb-6">Enseignant</h2>
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
                            <div class="text-2xl font-bold"><?php?></div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Total Students</div>
                            <div class="text-2xl font-bold"><?php  ?></div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Tags</div>
                            <div class="text-2xl font-bold"><?php ?></div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="text-gray-500 text-sm">Categories</div>
                            <div class="text-2xl font-bold"><?php ?></div>
                        </div>
                    </div>
                    <!-- Additional Statistics Charts could go here -->
                </section>

                <!-- Other sections (initially hidden) -->
    <section id="validation" class="section hidden">
             <!-- add content -->
        <div class="card">
                <div class="card-header">
                     <h1>Ajouter un cours </h1>
                </div>
            <div class="card-body p-6 bg-white rounded-lg shadow-md">
                <form method="post">
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
                                        <input type="checkbox" id="tag_<?php echo $tag['id']; ?>" name="tag_id[]" value="<?php echo $tag['id']; ?>" class="form-checkbox h-4 w-4 text-blue-600">
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
                                    <tfoot>
                                        <tr>
                                            <th class="px-4 py-2">Title</th>
                                            <th class="px-4 py-2">Category</th>
                                            <th class="px-4 py-2">Content Type</th>
                                            <th class="px-4 py-2">Tags</th>
                                            <th class="px-4 py-2">Created At</th>
                                            <th class="px-4 py-2">Status</th>
                                            <th class="px-4 py-2">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php if (isset($courses) && !empty($courses)): ?>
                                        <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td class="px-4 py-2">
                                                    <?= htmlspecialchars($course['title']) ?>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <?= htmlspecialchars($course['category_name']) ?>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <?= htmlspecialchars($course['content_type']) ?>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <?php
                                                    if ($course['tag_names']) {
                                                        $tags = explode(',', $course['tag_names']);
                                                        foreach ($tags as $tag) {
                                                            echo '<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">' . htmlspecialchars($tag) . '</span>';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td class="px-4 py-2" data-order="<?= strtotime($course['created_at']) ?>">
                                                    <?= date('M d, Y H:i', strtotime($course['created_at'])) ?>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <?= htmlspecialchars($course['status']) ?>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <form method="post" action="update-cours.php?id=<?= $course['id'] ?>" style="display:inline;">
                                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                            <i class="fas fa-edit"></i> Update
                                                        </button>
                                                    </form>
                                                    <form method="post" action="delete-cours.php" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?= $course['id'] ?>">
                                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                            <i class="fas fa-trash"></i> Delete
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


                <!--      <section id="stats" class="section hidden">
                     Detailed statistics 
                    <h2 class="text-xl font-semibold mb-4">Statistiques Globales</h2>
                     Add detailed statistics here 
                </section> -->
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

      
    </script>
</body>
</html>
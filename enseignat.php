<?php 
require 'vendor/autoload.php';

use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use App\Models\Cours;

$category = new Category();
$categories = $category->selectAllCategory();

$user = new User();
$authors = $user->selectAllUsers();

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
                        <h2>Add Cours</h2>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="contenu">Contenu:</label>
                                <select class="form-control" id="contenu" name="contenu" required>
                                    <option value="">--choisi Contenu de cours--</option>
                                    <option value="Video">Video</option>
                                    <option value="Document">Document</option>
                                </select>
                            </div>
                            <div id="video" style="display:none;">
                                <div class="form-group">
                                    <label for="contenu_video">Video URL:</label>
                                    <input type="text" class="form-control" id="contenu_video" name="contenu_video">
                                </div>
                            </div>
                            <div id="document" style="display:none;">
                                <div class="form-group">
                                    <label for="contenu_document">Document cours:</label>
                                    <textarea class="form-control" id="contenu_document" name="contenu_document" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category:</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tags :</label>
                                <div class="form-check">
                                    <?php foreach ($tags as $tag): ?>
                                        <div class="mb-2">
                                            <input class="form-check-input" type="checkbox"
                                                   id="tag_<?php echo $tag['id']; ?>"
                                                   name="tag_id[]"
                                                   value="<?php echo $tag['id']; ?>">
                                            <label class="form-check-label" for="tag<?php echo $tag['id']; ?>">
                                                <?php echo htmlspecialchars($tag['name']); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="scheduled_date">Scheduled Date:</label>
                                <input type="datetime-local" class="form-control" id="scheduled_date" name="scheduled_date">
                            </div>
                           
                            <button type="submit" class="btn btn-primary">Add Cours</button>
                        </form>
                    </div>
                </div>
                </section>

                <section id="content" class="section hidden">
                    <!-- Content management -->
                    <h2 class="text-xl font-semibold mb-4">Gestion des contenus</h2>
                   
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
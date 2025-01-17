<?php 
require 'vendor/autoload.php';


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
                 <h2 class="text-xl font-semibold mb-4">Ajouter Cours </h2>
 <form action="../app/Enseignant/manager_cours.php" method="POST" class="mb-4">

    <div>
        <label for="title">Title</label>
        <input class="border p-2 mb-2 w-full" type="text" id="title" name="title" placeholder="Enter title de cours" required>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea class="border p-2 mb-2 w-full" name="description" rows="4" placeholder="Enter description de cours"  required></textarea>
    </div>
    <div>
        <label for="contenu">Contenu</label>
        <select id="contenu" name="contenu" required>
            <option value="">--choisi Contenu de cours--</option>
            <option value="Video">Video</option>
            <option value="Document">Document</option>
        </select>
    </div>
    <div id="video">
        <label for="contenu_video">Video URL</label>
        <input class="border p-2 mb-2 w-full" type="url" id="content_vedio" name="contenu_video" placeholder="Enter video URL">
    </div>
    <div id="document" style="display:none;">
        <label for="contenu_document"> Document cours</label>
        <textarea class="border p-2 mb-2 w-full" id="contenu_document" name="content" rows="4" placeholder="Enter course document"></textarea>
    </div>
           <div>
                <label for="category_id">Catégorie</label>
                <select class="border p-2 mb-2 w-full" id="category_id" name="category_id" required>
                    <option value="" disabled selected>Choisir une catégorie</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    <div class="tags-container">
                <label style="color:black;">Tags</label>
                <?php foreach ($tags as $tag): ?>
                    <div>
                <table>
                       <td> <label for="tag_<?= $tag['id'] ?>"><?= htmlspecialchars($tag['name']) ?></label></td>
                       <td> <input type="checkbox" id="tag_<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>"></td>
                       
                </table>
                    </div>
                <?php endforeach; ?>
                </div>
    
    <div>
        <label for="scheduled_date">Scheduled Date</label>
        <input class="border p-2 mb-2 w-full" type="date" id="scheduled_date" name="created_at" required>
    </div>
    <button class="bg-gray-500 text-white p-2 popup-close" type="submit" name="action" value="create">Ajouter Course</button>
</form>
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

       

      
    </script>
</body>
</html>
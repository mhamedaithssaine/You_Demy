<?php
require 'vendor/autoload.php';

use App\Models\Cours;

$cours = new Cours();

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $courses = $cours->searchCourses($searchTerm);
} else {
    $courses = $cours->getCoursesWithPagination();
}


// var_dump($courses);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>YOU_demy - Accueil</title>
</head>
<body class="bg-gray-100">

<!-- Navigation -->
<nav class="bg-white shadow">
    <div class="container mx-auto flex justify-between items-center p-4">
        <a class="text-xl font-bold" href="#">YOU_demy</a>
        <div class="flex-grow mx-4">
            <form action="" methode="GET"class="flex items-center max-w-sm mx-auto">   
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                
                    <input type="text" id="simple-search" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search branch name..." required />
                </div>
                <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                        <span class="sr-only">Search</span>
                </button>
            </form>
        </div>
        <div>
            <a href="app/components/login.php" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Sign in</a>
            <a href="app/components/registre.php" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Sign up</a>
        </div>
    </div>
</nav>

<section class="relative text-white py-20">
    <div class="absolute inset-0">
        <img src="app/image/news_background.jpg" alt="Learning Image" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-blue-500 opacity-10"></div>
    </div>
    <div class="relative container mx-auto text-center">
        <h1 class="text-4xl font-bold mb-4">Bienvenue sur YOU_demy</h1>
        <p class="text-xl mb-8">Apprenez de nouvelles compétences en ligne avec les meilleurs cours.</p>
        <a href="app/components/login.php" class="bg-white text-blue-500 px-6 py-3 rounded-full font-bold">Explorer les cours</a>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">Cours en vedette</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($courses as $index => $cour): ?>
        <div class="course-slide bg-white p-4 rounded-lg shadow <?php echo $index >= 2 ? 'hidden' : ''; ?>">
                <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($cour['title']); ?></h3>
                <p class="text-gray-700 mb-2"><?php echo htmlspecialchars($cour['description']); ?></p>
                <p class="text-gray-500 mb-2">Catégorie: <?php echo htmlspecialchars($cour['category_name']); ?></p>
                <p class="text-gray-500 mb-2">Enseignant: <?php echo htmlspecialchars($cour['enseignant_name']); ?></p>
                <p class="text-gray-500 mb-2">Tags: <?php echo htmlspecialchars($cour['tag_names']); ?></p>
                <a href="app/components/login.php" class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors duration-300">
                    Voir le cours
                </a>
                <a href="app/components/login.php" class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors duration-300">
                    S'inscrire
                </a>
            </div>
        <?php endforeach; ?>
       
    </div>
    <div class="flex justify-between mt-4">
            <button id="prev-btn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded"><<</button>
            <button id="next-btn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">>></button>
        </div>
    
</section>

<!-- Features Section -->
<section class="relative text-white py-20 mt-10">
    <div class="absolute inset-0">
        <img src="app/image/event_1.jpg" alt="Background Image" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
    </div>
    <div class="relative container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8">Pourquoi choisir YOU_demy ?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <i class="fas fa-chalkboard-teacher text-5xl text-blue-500 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Enseignants qualifiés</h3>
                <p>Apprenez avec des experts dans leur domaine.</p>
            </div>
            <div>
                <i class="fas fa-laptop-code text-5xl text-blue-500 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Cours en ligne</h3>
                <p>Accédez à des cours en ligne à tout moment, n'importe où.</p>
            </div>
            <div>
                <i class="fas fa-certificate text-5xl text-blue-500 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Certifications</h3>
                <p>Obtenez des certifications reconnues pour vos compétences.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-white shadow mt-10">
    <div class="container mx-auto text-center p-4 text-sm text-gray-600">
        © 2025 YOU_demy. Tous droits réservés.
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.course-slide');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        let currentPage = 0;
        const itemsPerPage = 3;

        function showPage(page) {
            slides.forEach((slide, index) => {
                slide.classList.add('hidden');
                if (index >= page * itemsPerPage && index < (page + 1) * itemsPerPage) {
                    slide.classList.remove('hidden');
                }
            });
        }

        prevBtn.addEventListener('click', function () {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        });

        nextBtn.addEventListener('click', function () {
            if ((currentPage + 1) * itemsPerPage < slides.length) {
                currentPage++;
                showPage(currentPage);
            }
        });

        showPage(currentPage);
    });
</script>
</body>
</html>
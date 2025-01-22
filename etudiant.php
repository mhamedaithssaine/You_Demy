<?php
require 'vendor/autoload.php';

use App\Models\Cours;


session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'etudiant') {
    header('Location: app/components/login.php');
    exit();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: app/components/login.php');
    exit;
}

$cours = new Cours();


if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $courses = $cours->searchCourses($searchTerm);
} else {
    $courses = $cours->getCoursesWithPagination();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Catalogue des Cours</title>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow">
    <div class="container mx-auto flex justify-between items-center p-4">
    <a class="text-xl font-bold" href="#">YOU_demy</a>
     
        <div class="bg-blue-500 w-40 text-center py-2">
            <a class="text-white font-bold text-lg " href="app/Etudiant/cours_inscre.php">
                Mes Cours
            </a>
        </div>  
        <div>
        
        <a class="text-xl font-bold" href="#"><?php echo $_SESSION['user_name']; ?> <i class="fas fa-user mr-2">&nbsp;&nbsp;</i></a> 
       
         <form method="POST" action="app/components/logout.php" style="display:inline;">
                <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-500 focus:outline-none dark:focus:ring-red-800">Logout</button>
            </form>
            </div>
    </div>
</nav>

<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold text-center mb-4">Catalogue des Cours</h1>
    <?php if (isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>
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

    <div class="container mx-auto mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($courses as $course): ?>
        <div class="bg-white shadow-md rounded-lg p-4">
            
            <h5 class="font-bold text-lg"><?= htmlspecialchars($course['title']) ?></h5>
            <p class="text-gray-700"><?= htmlspecialchars($course['description']) ?></p>
            <small class=""><span class="font-bold text-lg">Catégorie :</span> <?= htmlspecialchars($course['category_name']) ?></small>
            <br>
            <small class=""><span class="font-bold text-lg">Enseignant :</span> <?= htmlspecialchars($course['enseignant_name']) ?></small>

            <div class="mt-4">

          
                <form method="POST" action="app/Etudiant/inscription.php" class="inline-block">
                    <input type="hidden" name="cours_id" value="<?= $course['id'] ?>">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">S'inscrire</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>


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
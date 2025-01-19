<?php
require 'vendor/autoload.php';

use App\Models\Cours;


session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'etudiant') {
    header('Location: etudiant.php');
    exit();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: app/components/login.php');
    exit;
}

$c = new Cours();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$courses = [];
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $courses = $c->searchCourses($keyword);
} else {
    $courses = $c->getCoursesWithPagination($limit, $offset);
}

$totalCourses = $c->countAllCourses();
$totalPages = ceil($totalCourses / $limit);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Catalogue des Cours</title>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow">
    <div class="container mx-auto flex justify-between items-center p-4">
        <a class="text-xl font-bold" href="#"><?php echo $_SESSION['user_name']; ?></a>
     
        <div class="bg-blue-500 w-40 text-center py-2">
            <a class="text-white font-bold text-lg " href="app/Etudiant/cours_inscre.php">
                Mes Cours
            </a>
        </div>         
         <form method="POST" action="app/components/logout.php" style="display:inline;">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Déconnexion</button>
            </form>
        
    </div>
</nav>

<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold text-center mb-4">Catalogue des Cours</h1>

    <form method="GET" class="mb-4">
        <div class="flex">
            <input type="text" name="search" class="border rounded-l-lg px-4 py-2 w-full" placeholder="Rechercher un cours" value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>">
            <button class="bg-blue-500 text-white rounded-r-lg px-4 py-2" type="submit">Rechercher</button>
        </div>
    </form>

    <div class="container mx-auto mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($courses as $course): ?>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h5 class="font-bold text-lg"><?= htmlspecialchars($course['title']) ?></h5>
            <p class="text-gray-700"><?= htmlspecialchars($course['description']) ?></p>
            <small class="text-gray-500">Catégorie : <?= htmlspecialchars($course['category_name']) ?></small>
            <div class="mt-4">
                <form method="POST" action="app/Etudiant/inscription.php" class="inline-block">
                    <input type="hidden" name="cours_id" value="<?= $course['id'] ?>">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">S'inscrire</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>


    <nav aria-label="Page navigation" class="mt-4">
        <ul class="flex justify-center space-x-2">
            <li>
                <a class="px-4 py-2 border rounded <?= $page <= 1 ? 'bg-gray-300' : 'bg-blue-500 text-white' ?>" href="?page=<?= $page - 1 ?>" <?= $page <= 1 ? 'disabled' : '' ?>>Précédent</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li>
                    <a class="px-4 py-2 border rounded <?= $i === $page ? 'bg-blue-500 text-white' : 'bg-white' ?>" href="?page=<?= $i ?><?= isset($keyword) ? '&search=' . htmlspecialchars($keyword) : '' ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li>
                <a class="px-4 py-2 border rounded <?= $page >= $totalPages ? 'bg-gray-300' : 'bg-blue-500 text-white' ?>" href="?page=<?= $page + 1 ?>" <?= $page >= $totalPages ? 'disabled' : '' ?>>Suivant</a>
            </li>
        </ul>
    </nav>
</div>

</body>
</html>
<?php
require '../../vendor/autoload.php';

use App\Models\Cours;
use App\Models\Student;

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../components/login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: ../../etudiant.php');
    exit;
}

$coursId = $_GET['id'];

$student = new Cours();
$courses = $student->getInscribedCourses($_SESSION['user_id']);

$courseDetails = null;
foreach ($courses as $course) {
    if ($course['id'] == $coursId) {
        $courseDetails = $course;
        break;
    }
}

if (!$courseDetails) {
    header('Location: ../../etudiant.php?error=Cours non trouve');
    exit;
}

$coursModel = new Cours();
$tags = $coursModel->getCourseTags($coursId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Détails du Cours</title>
</head>
<body class="bg-gray-100">

<!-- Topbar -->
<nav class="bg-white shadow">
    <div class="container mx-auto flex justify-between items-center p-4">
        <a class="text-xl font-bold" href="#">Espace Étudiant</a>
        <div class="flex-grow text-center py-4">
            <a class="text-blue-500 font-bold text-lg hover:underline" href="cours_inscre.php">Mes Cours</a>
        </div>
        <div class="flex items-center">
            <form method="POST" action="../components/logout.php" style="display:inline;">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mx-auto mt-5">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold text-center mb-4"><?= htmlspecialchars($courseDetails['title']) ?></h1>
        <div class="mt-6">
            <h2 class="text-xl font-bold flex items-center"><i class="fas fa-folder-open mr-2"></i> Catégorie</h2>
            <p class="text-gray-700 mt-2"><?= htmlspecialchars($courseDetails['category_name']) ?></p>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-bold flex items-center"><i class="fas fa-align-left mr-2"></i> Description</h2>
            <p class="text-gray-700 mt-2"><?= nl2br(htmlspecialchars($courseDetails['description'])) ?></p>
        </div>
        <div class="mt-6">
            
            <?php if (!empty($courseDetails['content'])): ?>
                <h2 class="text-xl font-bold flex items-center"><i class="fas fa-book mr-2"></i> Contenu du Cours</h2>
                <p class="text-gray-600 mt-2"><?= nl2br(htmlspecialchars($courseDetails['content'])) ?></p>
            <?php elseif (!empty($courseDetails['content_vedio'])): ?>
                <div class="mt-4">
                    <h2 class="text-xl font-bold flex items-center"><i class="fas fa-video mr-2"></i> Vidéo du Cours</h2>
                    <iframe class="mt-2 w-full h-64" src="<?= htmlspecialchars($courseDetails['content_vedio']) ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            <?php else: ?>
                <p class="text-gray-600 mt-2">Aucun contenu disponible pour ce cours.</p>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold flex items-center"><i class="fas fa-tags mr-2"></i> Tags</h2>
            <div class="flex flex-wrap mt-2">
                <?php if (!empty($tags)): ?>
                    <?php foreach ($tags as $tag): ?>
                        <span class="bg-blue-200 text-blue-800 text-sm px-2 py-1 rounded-full mr-2 mb-2"><?= htmlspecialchars($tag['name']) ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 mt-2">Aucun tag pour ce cours.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-6 text-center">
            <form method="POST" action="../Etudiant/delet_inscription.php" class="inline-block">
                <input type="hidden" name="cours_id" value="<?= $courseDetails['id'] ?>">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Se désinscrire</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

<?php
require '../../vendor/autoload.php';

use App\Models\Cours;


session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../login.php');
    exit;
}

$student = new Cours();

$courses = $student->getInscribedCourses($_SESSION['user_id']); 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <title>Mes Cours</title>
</head>
<body class="bg-gray-100">

<!-- Topbar -->
<nav class="bg-white shadow">
    <div class="container mx-auto flex justify-between items-center p-4">
    <a class="text-xl font-bold" href="#">YOU_demy</a>
        <div class="flex-grow text-center py-4">
            <a class="text-blue-500 font-bold text-lg hover:underline" href="../../etudiant.php">Home</a>
        </div>
        <div class="flex items-center">
        <a class="text-xl font-bold" href="#"><?php echo $_SESSION['user_name']; ?> <i class="fas fa-user mr-2">&nbsp;&nbsp;</i></a> 
            <form method="POST" action="../components/logout.php" style="display:inline;">
                <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold text-center mb-4">Mes Cours Inscrits</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if (empty($courses)): ?>
            <p class="text-center text-gray-500">Vous n'êtes inscrit à aucun cours.</p>
        <?php else: ?>
            <?php foreach ($courses as $course): ?>
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h5 class="font-bold text-lg"><?= htmlspecialchars($course['title']) ?></h5>
                  
                    <h3 class="text-gray-700 mt-2"><?= htmlspecialchars($course['category_name']) ?></h3>
                    <div class="mt-4">
                    

                    <a href="cours_details.php?id=<?= $course['id'] ?>" class="text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-500 focus:outline-none dark:focus:ring-green-800">Voir les détails</a>
                        
                        <form method="POST" action="delet_inscription.php" class="inline-block">
                            <input type="hidden" name="cours_id" value="<?= $course['id'] ?>">
                            <button type="submit" class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-500 focus:outline-none dark:focus:ring-red-800">Se désinscrire</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
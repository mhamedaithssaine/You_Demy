<?php
require_once '../../vendor/autoload.php';

use App\Models\Cours;
use App\Models\Tag;
use App\Models\Category;

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'enseignant') {
    header('Location: ../../login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$courseId = $_GET['id'] ?? null;
$courseModel = new Cours();

if (!$courseId) {
    die('Invalid course ID');
}

$course = $courseModel->selectCours($courseId);

if (!$course) {
    die('Course not found');
}
$categoryModel = new Category();
$categories = $categoryModel->selectAllCategory();

$tagModel = new Tag();
$tags = $tagModel->selectAllTags();

$courseTags = $courseModel->getCourseTags($courseId);

$course = $course[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'content' => $_POST['content_type'] === 'Document' ? $_POST['content_document'] : null,
        'content_vedio' => $_POST['content_type'] === 'Video' ? $_POST['content_video'] : null,
        'created_at' => $_POST['created_at'],
        'category_id' => $_POST['category_id'],
        'enseignant_id' => $_POST['userId']
    ];

    $courseModel->updateCours($data, $courseId);
    if (isset($_POST['tags']) && is_array($_POST['tags'])) {
        foreach ($_POST['tags'] as $tagId) {
            $courseModel->addTag($courseId, $tagId);
        }
    }
    header('Location: ../../enseignat.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-64 bg-gray-800 text-white fixed h-full">
            <div class="p-4">
                <h2 class="text-2xl font-semibold text-center mb-6">
                    <div id="currentUser" class="flex items-center space-x-2">
                        <span>You_demy</span>
                    </div>
                </h2>
                <div>
                    <nav>
                        <ul class="space-y-2">
                           
                            <li>
                                <a href="#" class="nav-link block px-4 py-2 rounded hover:bg-gray-700 transition" data-section="validation">
                                    Modifier le  Cours
                                </a>
                            </li>
                         
                        </ul>
                    </nav>
                </div>
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
                                <input type="search" id="searchBar" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search...">
                                <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 flex items-center space-x-4">
                        <a href="../../enseignat.php" class="flex items-center space-x-2 bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                        <a href="#" class="flex items-center space-x-2 bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600">
                            <i class="fas fa-user"></i>
                        </a>
                        <h2 class="text-2xl font-semibold text-center mb-2">
                            <div id="currentUser" class="flex items-center space-x-2">
                                <span><?php echo $_SESSION['user_name']; ?></span>
                            </div>
                        </h2>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                <section id="home" class="section active">
                <div class="card-body p-6 bg-white rounded-lg shadow-md">
                        <form method="post" action="">
                            <input type="hidden" name="userId" value="<?php echo $userId ?>">
                            <div class="mb-6">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                                <input type="text" id="title" name="title" value="<?= htmlspecialchars($course['title']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-6">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                <textarea id="description" name="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?= htmlspecialchars($course['description']) ?></textarea>
                            </div>
                            <div class="mb-6">
                                <label for="content_type" class="block text-gray-700 text-sm font-bold mb-2">Content Type</label>
                                <select id="content_type" name="content_type" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="Document" <?= !empty($course['content']) ? 'selected' : '' ?>>Document</option>
                                    <option value="Video" <?= !empty($course['content_vedio']) ? 'selected' : '' ?>>Video</option>
                                </select>
                            </div>
                            <div id="content_document_field" class="mb-6" style="<?= !empty($course['content']) ? '' : 'display:none;' ?>">
                                <label for="content_document" class="block text-gray-700 text-sm font-bold mb-2">Document Content</label>
                                <textarea id="content_document" name="content_document" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?= htmlspecialchars($course['content']) ?></textarea>
                            </div>
                            <div id="content_video_field" class="mb-6" style="<?= !empty($course['content_vedio']) ? '' : 'display:none;' ?>">
                                <label for="content_video" class="block text-gray-700 text-sm font-bold mb-2">Video Content</label>
                                <input type="text" id="content_video" name="content_video" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= htmlspecialchars($course['content_vedio']) ?>">
                            </div>
                            <div class="mb-6">
                                <label for="created_at" class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                                <input type="datetime-local" id="created_at" name="created_at" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($course['created_at']))) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-6">
                                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                                <select id="category_id" name="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tags</label>
                                <div class="flex flex-wrap">
                                    <?php foreach ($tags as $tag): ?>
                                        <div class="mb-2 mr-2">
                                            <input type="checkbox" id="tag_<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>" class="form-checkbox h-4 w-4 text-blue-600">
                                            <label for="tag_<?= $tag['id'] ?>" class="ml-2 text-gray-700"><?= htmlspecialchars($tag['name']) ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="mb-6">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
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
        document.getElementById('content_type').addEventListener('change', function() {
            var contentType = this.value;
            document.getElementById('content_document_field').style.display = contentType === 'Document' ? 'block' : 'none';
            document.getElementById('content_video_field').style.display = contentType === 'Video' ? 'block' : 'none';
        });
    </script>
</body>
</html>

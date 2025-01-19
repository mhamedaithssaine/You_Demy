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
        'title' => $title,
        'description' => $description,
        'content' => $contenu === 'Document' ? $contenu_document : null,
        'content_vedio' => $contenu === 'Video' ? $contenu_video : null,
        'created_at' => $scheduled_date,
        'category_id' => $category_id,
        'enseignant_id' => $userId
    ];

    $courseModel->updateCours($data, $courseId);
    $courseModel->deleteCourseTags($courseId);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container mx-auto p-4">
        <h2 class="text-xl font-semibold mb-4">Update Course</h2>
        <form method="post" action="">
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($course['title']) ?>" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" class="form-textarea mt-1 block w-full"><?= htmlspecialchars($course['description']) ?></textarea>
            </div>
            <div class="mb-4">
                <label for="content_type" class="block text-gray-700">Content Type</label>
                <select id="content_type" name="content_type" class="form-select mt-1 block w-full">
                    <option value="Document" <?= !empty($course['content']) ? 'selected' : '' ?>>Document</option>
                    <option value="Video" <?= !empty($course['content_vedio']) ? 'selected' : '' ?>>Video</option>
                </select>
            </div>
            <div class="mb-4" id="content_document_field" style="<?= !empty($course['content']) ? '' : 'display:none;' ?>">
                <label for="content_document" class="block text-gray-700">Document Content</label>
                <textarea id="content_document" name="content_document" class="form-textarea mt-1 block w-full"><?= htmlspecialchars($course['content']) ?></textarea>
            </div>
            <div class="mb-4" id="content_video_field" style="<?= !empty($course['content_vedio']) ? '' : 'display:none;' ?>">
                <label for="content_video" class="block text-gray-700">Video Content</label>
                <textarea id="content_video" name="content_video" class="form-textarea mt-1 block w-full"><?= htmlspecialchars($course['content_vedio']) ?></textarea>
            </div>
            <div class="mb-4">
                <label for="created_at" class="block text-gray-700">Created At</label>
                <input type="datetime-local" id="created_at" name="created_at" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($course['created_at']))) ?>" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Category</label>
                <select id="category_id" name="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex flex-wrap">
                <?php foreach ($tags as $tag): ?>
                    <div class="mb-2 mr-2">
                        <input type="checkbox" id="tag_<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>" class="form-checkbox h-4 w-4 text-blue-600" <?= in_array($tag['id'], explode(',', $courseTags)) ? 'checked' : '' ?>>
                        <label for="tag_<?= $tag['id'] ?>" class="ml-2 text-gray-700"><?= htmlspecialchars($tag['name']) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
           
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </form>
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

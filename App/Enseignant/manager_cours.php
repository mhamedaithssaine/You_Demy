<?php
require '../../vendor/autoload.php';

session_start();

use App\Models\Cours;
use App\Models\Category;
use App\Models\Tag;

$userId = $_SESSION['user_id'];

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
        'enseignant_id' => $userId
    ]);

    if (isset($_POST['tags'])) {
        $tags = $_POST['tags'];
        foreach ($tags as $tag_id) {
            $cours->addTag($cours_id, $tag_id);
        }
    }
    header('Location: ../../enseignat.php');
    exit();
}
?>

<?php
require '../../vendor/autoload.php';
use App\Models\Tag;

$tag = new Tag();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $tagId = intval($_GET['id']);

    if ($action === 'delete') {
        $tag->deleteTag($tagId);
    }
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   

    if (isset($_POST['id'])) {
       
        $tagId = intval($_POST['id']);

        $data = [
            'name' => $_POST['name']
        ];

        $tag->updateTag($data, $tagId);
    } else {
         $data = [
            'name' => $_POST['name']
        ];
        $tag->addTag($data);
    }
    header("Location: ../../index.php");
    exit();
}

$tags = $tag->selectAllTags();

?>

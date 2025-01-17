<?php
require '../../vendor/autoload.php';
use App\Models\Category;

$category = new Category();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $categoryId = intval($_GET['id']);

    if ($action === 'delete') {
        $category->deleteCategory($categoryId);
    }
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $categoryId = intval($_POST['id']);
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ];
        $category->updateCategory($data, $categoryId);
    } else {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ];
        $category->addCategory($data);
    }
    header("Location: ../../index.php");
    exit();
}

$categories = $category->selectAllCategory();
?>

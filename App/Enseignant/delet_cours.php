<?php
require '../../vendor/autoload.php';

session_start();

use App\Models\Cours;

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['id'];

    $cours = new Cours();
    $cours->deleteCours($courseId);

    header('Location: ../../enseignat.php');
    exit();
}
?>

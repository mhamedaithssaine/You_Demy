<?php
require '../../vendor/autoload.php';

use App\Models\Cours;

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$student = new Cours();

if (isset($_POST['cours_id'])) {
    $coursId = $_POST['cours_id'];
    $etudiantId = $_SESSION['user_id']; 
    $message = $student->inscrireEtudiant($etudiantId, $coursId);
    if ($message === "Inscription réussie.") {
        header('Location: ../../etudiant.php?success=' .urldecode($message));
    } else {
        header('Location: ../../etudiant.php?error=' . urlencode($message));
    }
} else {
    header('Location: ../../etudiant.php');
    exit();
}
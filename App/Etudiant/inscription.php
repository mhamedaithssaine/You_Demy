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

    if ($student->inscrireEtudiant($etudiantId, $coursId)) {
        header('Location: ../../etudiant.php?success=Inscription réussie');
    } else {
        header('Location: ../../etudiant.php?error=Erreur lors de l\'inscription');
    }
} else {
    header('Location: ../../etudiant.php');
}
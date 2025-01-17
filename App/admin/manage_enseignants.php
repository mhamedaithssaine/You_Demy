<?php
require '../../vendor/autoload.php';
use App\Models\Enseignant;

$enseignant = new Enseignant();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $enseignantId = intval($_GET['id']); 
  
    if ($action === 'validate') {
        $enseignant->validateEnseignant($enseignantId);
    } elseif ($action === 'reject') {
        $enseignant->rejectEnseignant($enseignantId);
    }
    header("Location: ../index.php");
    exit();
}

$pendingEnseignants = $enseignant->getPendingEnseignants();
?>

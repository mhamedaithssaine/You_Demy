<?php
require '../../vendor/autoload.php';

use App\Models\Admin;


$admin = new Admin();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']); 
  
    if ($action === 'validate') {
        $admin->validateEnseignant($id);
    } elseif ($action === 'reject') {
        $admin->rejectEnseignant($id);
    }
    header("Location: ../../index.php");
    exit();
}


?>

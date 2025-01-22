
<?php
require '../../vendor/autoload.php';

use App\Models\Cours;


$admin = new Cours();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']); 
  
    if ($action === 'validate') {
        $admin->publeshedCours($id);
    } elseif ($action === 'reject') {
        $admin->draftCours($id);
    }
    header("Location: ../../index.php");
    exit();
}


?>


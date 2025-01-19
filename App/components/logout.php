<?php
require '../../vendor/autoload.php';
use App\Models\User;

$User = new User();
$User->deconnecte();

header('Location: login.php');
exit();
?>
<?php
require '../../vendor/autoload.php';
use App\Models\Admin;

$admin = new Admin();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']);

    if ($action === 'activate') {
        $admin->validateUser($id);
    } elseif ($action === 'suspended') {
        $admin->suspendedUser($id);
    } elseif ($action === 'delete') {
        $admin->rejectUser($id);
    }

    header('Location: ../../index.php');
    exit();
}
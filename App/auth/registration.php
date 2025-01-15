<?php 
namespace Auth\Register;
  use Models\User;


if ($_SERVER["REQUIST_METHOD"]=="POST" &&  $_POST['submit']){
    $fullname=htmlspecialchars($_POST['fullname']);
    $email=htmlspecialchars($_POST['email']);
    $phone=htmlspecialchars($_POST['phone']);
    $password=htmlspecialchars($_POST['password']);
    $bio=htmlspecialchars($_POST['bio']);
    $profil_img_url=htmlspecialchars($_POST['profil_img_url']);
    $role=htmlspecialchars($_POST['role']);

    $password_hach = password_hash($password,PASSWORD_DEFAULT);
    
    $data = [
        'fullname' => $fullname,
        'email' => $email,
        'phone' => $phone,
        'password' => $hashed_password,
        'bio' => $bio,
        'profil_img_url' => $profil_img_url,
        'role' => $role
    ];
    $user = new User();
    if($user->create($data)){
        header('location:../components/login.php');
        exit();
    }


}   





?>
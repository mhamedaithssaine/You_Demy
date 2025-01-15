<?php 
namespace App\Models;
use App\Models\User;
use PDO;

class Enseignant extends User {
    public function __construct(PDO $pdo){
        parent::__construct($pdo);
    }

    public function getRole(){
        return 'enseignant';
    }
}



?>
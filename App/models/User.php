<?php
namespace App\Models;
use App\Models\Crud;
use PDO;
abstract class User extends Crud {
   
public function __construct(PDO $pdo){
parent::__construct($pdo,'users');
}

abstract public function getRole();

}


?>
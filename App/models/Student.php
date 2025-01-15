<?php
namespace App\Models;

use PDO;

class Student extends User {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo);
    }
  
      public function getRole(){
        return 'etudiants';
      }
}
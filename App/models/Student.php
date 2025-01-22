<?php
namespace App\Models;

use App\Models\User;
use PDO;

class Student extends User {

    protected $table='users';
    public function __construct() {
       
    }
  
      
     
      public function countStudents(){
        $result = $this->selectRecords($this->table,'COUNT(*) as total_student','role="etudiant"');
        return $result[0]['total_student'];
      }

   
}
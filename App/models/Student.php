<?php
namespace App\Models;



class Student extends User {

    protected $table='users';
    public function __construct() {
       
    }
  
      public function getRole(){
        return 'etudiants';
      }
     
      public function countStudents(){
        $result = $this->selectRecords($this->table,'COUNT(*) as total_student','role="etudiant"');
        return $result[0]['total_student'];
      }

}
<?php 
namespace App\Models;
use App\Models\User;
use PDO;

class Enseignant extends User {

    protected $table = 'users';
    public function __construct(){
     parent::__construct();
    }

    public function getRole(){
        return 'enseignant';
    }
    public function countEnseignant(){
        $result = $this->selectRecords($this->table,'COUNT(*) as total_enseignant','role="enseignant"');
        return $result[0]['total_enseignant'];
      }
      public function getPendingEnseignants() {
        return $this->selectRecords($this->table, '*', 'role="enseignant" AND valide="Non valide"');

      }
        
           
}



?>
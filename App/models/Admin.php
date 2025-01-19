<?php
namespace App\Models;

use App\Models\User;

class Admin extends User {
    public function __construct() {
        parent::__construct();
    }
    
    public function validateUser($id) {
        return $this->updateRecord($this->table, ['status' => 'active'], $id);
    }
    public function suspendedUser($id) {
        return $this->updateRecord($this->table, ['status' => 'suspended'], $id);
    }

    public function rejectUser($id) {
        return $this->deleteusers($id);
    }
    

    public function validateEnseignant(int  $id) {
        return $this->updateRecord($this->table, ['role' => 'enseignant', 'valide' => 'valide'], $id);
    }

    public function rejectEnseignant(int $id) {
        return $this->updateRecord($this->table, ['role' => 'etudiant' ,'valide' => 'valide'], $id);
    }

}
?>
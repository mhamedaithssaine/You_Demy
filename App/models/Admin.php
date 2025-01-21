<?php
namespace App\Models;

use App\Models\User;
use PDO;

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

    public function getGeneralStats() {
        $query = "
            SELECT
                (SELECT COUNT(*) FROM users WHERE role = 'enseignant' AND status = 'active') AS total_teachers,
                (SELECT COUNT(*) FROM users WHERE role = 'etudiant' AND status = 'active') AS total_students,
                (SELECT COUNT(*) FROM cours WHERE status = 'published') AS active_courses,
                (SELECT COUNT(*) FROM cours WHERE status = 'draft') AS pending_courses,
                (SELECT COUNT(*) FROM categories) AS total_categories
        ";

        $stmt = self::$conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
   
    
    

}
?>
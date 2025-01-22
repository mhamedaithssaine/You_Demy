<?php

namespace App\Models;

use App\Models\Crud;
use PDO;

class Cours extends Crud {
    private $table = 'cours';

    public function __construct() {
        parent::__construct();
    }

    public function selectAllCours() {
        return $this->selectRecords($this->table);
    }
    
  public function selectAllCoursEnsiengant(){
            $sql = "SELECT cours.*, categories.name  as category_name,  GROUP_CONCAT(tags.name SEPARATOR ', ') as tag_names, users.fullname AS enseignant_name
            FROM cours 
            JOIN categories ON cours.category_id = categories.id
            JOIN cours_tags ON cours.id = cours_tags.cours_id
            JOIN tags ON cours_tags.tag_id = tags.id
            JOIN users ON cours.enseignant_id = users.id
            WHERE users.role = 'enseignant'
            GROUP BY cours.id,categories.name, users.fullname";
            $stmt = parent::$conn->prepare($sql);
            $stmt->execute();

            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $courses;
  }

    public function selectCours($id) {
        return $this->selectRecords($this->table, '*', 'id = ' . $id);
    }

    public function addCours(array $data) {
        return $this->insertRecord($this->table, $data);
    }

    public function updateCours(array $data, int $id) {
        return $this->updateRecord($this->table, $data, $id);
    }

    public function deleteCours(int $id) {
        return $this->deleteRecord($this->table, $id);
    }

    public function publeshedCours(int  $id) {
        return $this->updateRecord($this->table, ['status' => 'published'], $id);
    }

    public function draftCours(int $id) {
        return $this->updateRecord($this->table, ['status' => 'draft'], $id);
    }
   
    public function getCoursesByUserId($userId) {
        $sql = "SELECT cours.*, categories.name  as category_name,  GROUP_CONCAT(tags.name SEPARATOR ', ') as tag_names
                FROM cours 
                JOIN categories ON cours.category_id = categories.id
                JOIN cours_tags ON cours.id = cours_tags.cours_id
                JOIN tags ON cours_tags.tag_id = tags.id
                WHERE cours.enseignant_id = :userId
                GROUP BY cours.id";
    
        $stmt = parent::$conn->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courses;
    }


    public static function addTag($coursId, $tagId) {
        return parent::insertRecord('cours_tags', ['cours_id' => $coursId, 'tag_id' => $tagId]);
    }

   
    public function getCourseTags($coursId) {
       
        $sql = "SELECT  t.name 
            FROM tags t 
            JOIN cours_tags ct ON t.id = ct.tag_id 
            WHERE ct.cours_id = ?";
    
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([$coursId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function deleteCourseTags($coursId) {
        $sql = "DELETE FROM cours_tags WHERE cours_id = :coursId";
        $stmt = parent::$conn->prepare($sql);
        $stmt->bindParam(':coursId', $coursId, PDO::PARAM_INT);
        return $stmt->execute();
    }
     

    public function getCoursesWithPagination() {
        $sql = "SELECT cours.*, categories.name as category_name, GROUP_CONCAT(tags.name SEPARATOR ', ') as tag_names, users.fullname AS enseignant_name
        FROM cours 
        JOIN categories ON cours.category_id = categories.id
        JOIN cours_tags ON cours.id = cours_tags.cours_id
        JOIN tags ON cours_tags.tag_id = tags.id
        JOIN users ON cours.enseignant_id = users.id
        WHERE cours.status = 'published'
        GROUP BY cours.id, categories.name, users.fullname";
      

                $stmt = parent::$conn->prepare($sql);
              
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countAllCourses() {
        $result = $this->selectRecords($this->table, 'COUNT(*) as total');
        return $result[0]['total'];
    }

  // pour chercher un cours par title 
    public function searchCourses($searchTerm) {
           $sql = "SELECT cours.*, categories.name as category_name, GROUP_CONCAT(tags.name SEPARATOR ', ') as tag_names, users.fullname AS enseignant_name
        FROM cours 
        JOIN categories ON cours.category_id = categories.id
        JOIN cours_tags ON cours.id = cours_tags.cours_id
        JOIN tags ON cours_tags.tag_id = tags.id
        JOIN users ON cours.enseignant_id = users.id
        WHERE cours.status = 'published' AND  title LIKE :searchTerm OR categories.name LIKE :searchTerm OR tags.name LIKE :searchTerm OR users.fullname  LIKE :searchTerm
        GROUP BY cours.id, categories.name, users.fullname";
        $stmt = parent::$conn->prepare($sql);
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// pour verifier l'inscription 

    public function isAlreadyInscribed($etudiantId, $coursId) {
        $sql = "SELECT COUNT(*) as count FROM inscription WHERE etudiant_id = :etudiantId AND cours_id = :coursId";
        $stmt = parent::$conn->prepare($sql);
        $stmt->bindParam(':etudiantId', $etudiantId, PDO::PARAM_INT);
        $stmt->bindParam(':coursId', $coursId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // pour faire l'inscription de cours 
    public function inscrireEtudiant($etudiantId, $coursId) {
        if ($this->isAlreadyInscribed($etudiantId, $coursId)) {

            return "Vous êtes déjà inscrit à ce cours.";
        }
        $sql = "INSERT INTO inscription (etudiant_id, cours_id) VALUES (:etudiantId, :coursId)";
        $stmt = parent::$conn->prepare($sql);
        $stmt->bindParam(':etudiantId', $etudiantId, PDO::PARAM_INT);
        $stmt->bindParam(':coursId', $coursId, PDO::PARAM_INT);
        if  ($stmt->execute()){
            return "Inscription réussie.";
        }else {
            return "Erreur lors de l'inscription.";
        }
    }


    public function getInscribedCourses($etudiantId) {
        $sql = "SELECT cours.*, categories.name as category_name 
                FROM inscription
                JOIN cours ON inscription.cours_id = cours.id
                JOIN categories ON cours.category_id = categories.id
                WHERE inscription.etudiant_id = :etudiantId";
    
        $stmt = parent::$conn->prepare($sql);
        $stmt->bindParam(':etudiantId', $etudiantId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteInscription($etudiantId, $coursId) {
            $sql = "DELETE FROM inscription WHERE etudiant_id = :etudiantId AND cours_id = :coursId";
            $stmt = parent::$conn->prepare($sql);
            $stmt->bindParam(':etudiantId', $etudiantId, PDO::PARAM_INT);
            $stmt->bindParam(':coursId', $coursId, PDO::PARAM_INT);
            return $stmt->execute();
    }

   
}


?>
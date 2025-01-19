<?php

namespace App\Models;

use App\Models\Crud;
use PDO;

class Cours extends Crud {
    private $table = 'cours';

    public function __construct() {
        parent::__construct();
    }

    public function selectAllCours($table) {
        return $this->selectRecords($this->table);
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

    public function countCours() {
        $result = $this->selectRecords($this->table, 'COUNT(*) as total');
        return $result[0]['total'];
    }

   
    public function getCoursesByUserId($userId) {
        $sql = "SELECT cours.*, categories.name as category_name
                FROM cours
                JOIN categories ON cours.category_id = categories.id
                -- LEFT JOIN cours_tags ON cours.id = cours_tags.cours_id
                -- LEFT JOIN tags ON cours_tags.tag_id = tags.id
                WHERE cours.enseignant_id = :userId";
    
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
        // $sql = "SELECT tags.name as name
        //         FROM cours_tags
        //         JOIN tags ON cours_tags.tag_id = tags.id
        //         WHERE cours_tags.cours_id = :coursId";
    
        // $stmt = parent::$conn->prepare($sql);
        // $stmt->bindParam(':coursId', $coursId, PDO::PARAM_INT);
        // $stmt->execute();
    
        // $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
        // return  $tags;
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
     
    public function getCoursesWithPagination($limit, $offset) {
        $sql = "SELECT cours.*, categories.name as category_name
                FROM cours
                JOIN categories ON cours.category_id = categories.id
                LIMIT :limit OFFSET :offset";

        $stmt = parent::$conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countAllCourses() {
        $result = $this->selectRecords($this->table, 'COUNT(*) as total');
        return $result[0]['total'];
    }
    public function searchCourses($keyword) {
        $sql = "SELECT cours.*, categories.name as category_name
                FROM cours
                JOIN categories ON cours.category_id = categories.id
                WHERE cours.title LIKE :keyword OR cours.description LIKE :keyword";

        $stmt = parent::$conn->prepare($sql);
        $keyword = "%$keyword%"; 
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function inscrireEtudiant($etudiantId, $coursId) {
        $sql = "INSERT INTO inscription (etudiant_id, cours_id) VALUES (:etudiantId, :coursId)";
        $stmt = parent::$conn->prepare($sql);
        $stmt->bindParam(':etudiantId', $etudiantId, PDO::PARAM_INT);
        $stmt->bindParam(':coursId', $coursId, PDO::PARAM_INT);
        return $stmt->execute();
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
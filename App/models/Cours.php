<?php

namespace App\Models;

use App\Models\Crud;

class Cours extends Crud {
    private $table = 'cours';

    public function __construct() {
        parent::__construct();
    }

    public function selectAllCours() {
        return $this->displayCours();
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

    public static function displayCours() {
        return parent::selectRecords('cours');
    }

    public static function getTopCours($limit = 5) {
        return parent::selectRecords('cours', '*', null, [], $limit);
    }

    public static function addTag($coursId, $tagId) {
        return parent::insertRecord('cours_tags', ['cours_id' => $coursId, 'tag_id' => $tagId]);
    }

   

    public static function getTags($coursId) {
        return parent::selectRecords('cours_tags', '*', 'cours_id = ' . $coursId);
    }
}
?>
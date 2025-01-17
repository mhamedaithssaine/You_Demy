<?php

namespace App\Models;

use App\Models\Crud;


class Tag extends Crud {

    private $table = 'tags';

    public function __construct(){
        parent::__construct();
    }

    public function selectAllTags(){
        return $this->selectRecords($this->table);
    }

    public function selectTag($id){
        return $this->selectRecords($this->table, '*', 'id = ' . $id);
    }

    public function addTag(array $data){
        $existingTag = $this->selectRecords($this->table, '*', 'name = ?', [$data['name']]);
        if (!empty($existingTag)) {
            return false;
        }
        return $this->insertRecord($this->table, $data);
    }

    public function updateTag(array $data, int $id){
        return $this->updateRecord($this->table, $data, $id);
    }

    public function deleteTag(int $id){
        return $this->deleteRecord($this->table, $id);
    }

    public function countTags(){
        $result = $this->selectRecords($this->table, 'COUNT(*) as total');
        return $result[0]['total'];
    }

     // Insertion en masse de tags pour gagner en efficacité.

    // public function insertTags(array $tags) {
    //     foreach ($tags as $tagData) {
    //         $this->addTag($tagData);
    //     }
    // }
}

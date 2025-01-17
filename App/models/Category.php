<?php

namespace App\Models;

use App\Models\Crud;
use PDO;
class Category extends crud
{
    protected static $conn;
    private $table = 'categories';

    public function __construct(){
        parent::__construct();
        
    }

    public function selectAllCategory(){
        return $this->selectRecords($this->table);
    }

    public function selectCategory($id){
        return $this->selectRecords($this->table, '*', 'id = ' . $id);
    }

    public function addCategory(array $data){
        return $this->insertRecord($this->table, $data);
    }

    public function updateCategory(array $data, int $id){
        return $this->updateRecord($this->table, $data, $id);
    }

    public function deleteCategory(int $id){
        return $this->deleteRecord($this->table, $id);
    }

    public function countCategory(){
        $result = $this->selectRecords($this->table, 'COUNT(*) as total');
        return $result[0]['total'];
    }
}
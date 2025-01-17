<?php
namespace App\Models;

use App\Models\Crud;
use PDO;
 class User extends Crud {
 
   private $table = 'users';

   public function __construct(){
       parent::__construct();
   }

   public function selectAllusers(){
       return $this->selectRecords($this->table);
   }

   public function selectusers($id){
       return $this->selectRecords($this->table, '*', 'id = ' . $id);
   }

   public function addusers(array $data){
       return $this->insertRecord($this->table, $data);
   }

   public function updateusers( array $data, int $id){
       return $this->updateRecord($this->table, $data, $id);
   }

   public function deleteusers(int $id){
       return $this->deleteRecord($this->table, $id);
   }

   public function activateUser($id){
    return $this->updateRecord($this->table,['status'=>'active'],$id);
   }
   public function suspendUser($id){
    return $this->updateRecord($this->table, ['status' => 'suspended'], $id);
   }
   
 }

?>
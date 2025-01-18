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

   public function registre($data) {
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    if ($data['role'] === 'enseignant') {
        $data['status'] = 'suspended';
    } else {
        $data['status'] = 'active';
    }
    return $this->addusers($data);
}
      public function authenticate($email, $password) {
            $user = $this->selectRecords($this->table, '*', 'email = ?', [$email]);
            
          if (!empty($user) && password_verify($password, $user[0]['password'])) {
           return $user[0];
         }
            return false;
        }
    public function connecte($email, $password) {
            $authenticatedUser = $this->authenticate($email, $password);
            if ($authenticatedUser) {
                session_start();
                $_SESSION['user_id'] = $authenticatedUser['id'];
                $_SESSION['user_role'] = $authenticatedUser['role'];
                $_SESSION['user_name'] = $authenticatedUser['fullname'];
                return true;
            }
            return false;
        }
     public function deconnecte() {
            session_start();
            session_unset();
            session_destroy();
        }

   public function activateUser($id){
    return $this->updateRecord($this->table,['status'=>'active'],$id);
   }
   public function suspendUser($id){
    return $this->updateRecord($this->table, ['status' => 'suspended'], $id);
   }
   
 }

?>
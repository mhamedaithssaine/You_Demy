<?php
namespace App\Models;

use App\Models\Crud;
use PDO;
 class User extends Crud {
 
   protected $table = 'users';


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
        $data['valide'] = 'Non valide';
    } 
    return $this->addusers($data);
}
      public function authenticate($email, $password) {
            $users = $this->selectAllusers();

            foreach($users as $user){
                if ($user['email'] == $email && password_verify($password, $user['password'])){
                    return $user;
                }
            }
           return false;
        }
    public function connecte($email, $password) {
            $authenticatedUser = $this->authenticate($email, $password);
            if ($authenticatedUser) {

                //Verifier validation par admin

                if($authenticatedUser['role']== 'enseignant' && $authenticatedUser['status'] !== 'active' ){
                    return false;
                }
                session_start();
                $_SESSION['user_id'] = $authenticatedUser['id'];
                $_SESSION['user_role'] = $authenticatedUser['role'];
                $_SESSION['user_name'] = $authenticatedUser['fullname'];
                $_SESSION['user_image'] = $authenticatedUser['profil_img_url'];
                if($authenticatedUser['role']=="enseignant"){

                    if($authenticatedUser['valide']=="Non valide"){
  
                          header('Location: ../components/login.php');
                        exit();}
                        if($authenticatedUser['status']=="suspended"){
  
                            header('Location: ../components/login.php');
                          exit();}
                        }
                        if($authenticatedUser['role']=="etudiant"){

                                if($authenticatedUser['status']=="suspended"){
          
                                    header('Location: ../components/login.php');
                                  exit();}
                                }

                return true;
            }
            return false;
        }
     public function deconnecte() {
            session_start();
            session_unset();
            session_destroy();
        }

 }

?>
<?php
namespace App\Database;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class Connection {

    private static $conn;

    public function __construct(){
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();

        $host = $_ENV['host'];
        $dbname = $_ENV['db_name'];
        $username = $_ENV['username'];
        $password = $_ENV['password'];
        // echo "Database: $dbname<br>";
        // echo "Username: $username<br>";
        // echo "Password: $password<br>";
        try {
            self::$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "success  '$dbname'.";
        } catch (PDOException $e) {
            die ("Connection error: " . $e->getMessage());
        }
    }

    public static function getPDO() {
      if(self::$conn===null){
         new self();
      }
        return self::$conn;
    }
}

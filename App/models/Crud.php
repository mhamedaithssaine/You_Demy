<?php

namespace App\Models;

use App\Database\Connection;

use PDO;

class Crud extends Connection{

   
    protected static $conn;
    public function __construct(){
        self::$conn = Connection::getPDO();
        if (self::$conn === null) {
            die("Database connection failed.");
        }

    }

    public static function selectRecords(string $table, string $columns = "*", string $where = null, array $params=[])
    {
        if (self::$conn === null) {
            die("Database connection failed.");
        }


        $sql = "SELECT $columns FROM $table ";

        if ($where !== null) {
            $sql .= " WHERE $where";
        }
        $stmt = self::$conn->prepare($sql);

       
        if(!$stmt){
            die("Error in prepared statement: " . self::$conn->errorInfo()[2]);
        }
        if (!empty($params)) {
            foreach ($params as $key => &$value) {
                $stmt->bindParam($key + 1, $value);
            }
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function insertRecord(string $table, array $data)
    {
        
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = self::$conn->prepare($sql);

        if (!$stmt) {
            die("Error in prepared statement: " . self::$conn->errorInfo()[2]);
        }

        $i = 1;
        foreach ($data as $key => &$value) {
            $stmt->bindParam($i, $value);
            $i++;
        }
        if ($stmt->execute()) {
            $lastInsertId = self::$conn->lastInsertId();
            return $lastInsertId;
        } else {
            return false;
        }
    }

 public static function updateRecord(string $table, array $data, int $id)
    {      if (self::$conn === null) {
        die("Database connection failed.");
    }
    
        $args = array();

        foreach ($data as $key => $value) {
            $args[] = "$key = :$key";
        }

        $sql = "UPDATE $table SET " . implode(',', $args) . " WHERE id = :id";

        $stmt = self::$conn->prepare($sql);

        if (!$stmt) {
            die("Error in prepared statement: " . self::$conn->errorInfo()[2]);
        }

        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error in execution: " . self::$conn->errorInfo()[2]; // Débogage
            return false;
        }
}


    public static function deleteRecord(string $table, int $id) {
        $sql = "DELETE FROM $table WHERE id = ?";

        $stmt = self::$conn->prepare($sql);

        if (!$stmt) {
            die("Error in prepared statement: " . self::$conn->errorInfo()[2]);
        }

        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    


}




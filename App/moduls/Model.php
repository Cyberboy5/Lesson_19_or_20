<?php

namespace App\moduls;

USE  App\database\Database;
USE PDO;

class Model extends Database{
   
    public static function getAll(){
        $sql = "SELECT * FROM " . static::$table;
        $stmt = self::getConnection()->query($sql);
        return $stmt->fetchAll(PDO :: FETCH_ASSOC); 
    }

    public static function create($data){
        $columns = implode(',', array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
    
        $query = "INSERT INTO " . static::$table . " ($columns) VALUES ($values)";
        $stmt = self::getConnection()->prepare($query);
    
        return $stmt->execute(); 
    }

    public static function show(int $id){
        if (isset($id)) {
            $query = 'SELECT * FROM ' . static::$table . " WHERE id = :id";
            $stmt = self::getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
    }

    public static function delete(int $id){
        if (isset($id)) {
            $query = 'DELETE FROM ' . static::$table . " WHERE id = :id";
            $stmt = self::getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }

    public static function update($data, $id) {
        $columns = "";
        foreach ($data as $key => $value) {
            $columns .= "$key = :$key, "; 
        }
        $columns = rtrim($columns, ", "); 

        $query = "UPDATE " . static::$table . " SET {$columns} WHERE id = :id";
        $stmt = self::getConnection()->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        return $stmt->execute(); 
    }

    public static function where($col, $key, $val){
        $allowedColumns = ['name', 'price', 'id'];  
        if (!in_array($col, $allowedColumns)) {
            throw new Exception('Invalid column name');
        }
    
        $allowedKeys = ['=', '>', '<', '<=', '>='];
        if (!in_array($key, $allowedKeys)) {
            throw new Exception('Invalid operator');
        }
    
        $sql = "SELECT * FROM " . static::$table . " WHERE {$col} {$key} :val";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindValue(':val', $val);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    

    public static function whereLIKE($col, $val){
        $allowedColumns = ['name', 'id','price'];  
        if (!in_array($col, $allowedColumns)) {
            throw new Exception('Invalid column name');
        }
    
        $sql = "SELECT * FROM " . static::$table . " WHERE {$col} LIKE :val";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindValue(':val', "%{$val}%");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    

    public static function getTotalCount() {
        $query = "SELECT COUNT(*) as total FROM " . static::$table;
        $stmt = self::getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function pagination($content_per_page, $curr_page){
        $start = ($curr_page - 1) * $content_per_page;

        $query = "SELECT * FROM " . static::$table . " LIMIT :start, :limit";
        $stmt = self::getConnection()->prepare($query);

        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $content_per_page, PDO::PARAM_INT);
        $stmt->execute();
        
        $contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalContent = self::getTotalCount();
        $totalPages = ceil($totalContent / $content_per_page);

        return [
            'contents' => $contents,
            'total_pages' => $totalPages,
            'current_page' => $curr_page,
        ];
    }
}
?>

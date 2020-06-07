<?php
    function registerUser($c) {
        $db = connectDb();
        $stmt = $db->prepare("INSERT INTO userTable (username, password_hash, warehouse_id)
                            VALUES (:username, :password_hash, :warehouse_id)"
        );
        $stmt->bindValue(":username", $c["username"], PDO::PARAM_STR);
        $password_hash = password_hash($c["password"], PASSWORD_BCRYPT, ["cost" => 10]);
        $stmt->bindValue(":password_hash", $password_hash, PDO::PARAM_STR);
        $stmt->bindValue(":warehouse_id", $c["warehouse"], PDO::PARAM_STR);
        $success = $stmt->execute(); // return boolean value (echos as 0 or 1)
        $stmt->closeCursor();
    
        return $success;
    }

    function authenticateUser($c){
        $db = connectDb();
        $stmt = $db->prepare("SELECT user_id, password_hash, warehouse_id
                              FROM userTable
                              WHERE username=:username"
        );
        $stmt->bindValue(":username", $c["username"], PDO::PARAM_STR);
        $success = $stmt->execute(); 
        $result = $stmt->fetch();
        $stmt->closeCursor();
      
        if (password_verify($c["password"], $result["password_hash"])) {
          session_start();
          $_SESSION["user_id"] = $result["user_id"];
          $_SESSION["username"] = $c["username"];
          $_SESSION["warehouse"] = $result["warehouse_id"];      
          return true;
        } else {
          return false;
        }
    }
    function addItem($i){

    }
    function removeItem($i){

    }


?>
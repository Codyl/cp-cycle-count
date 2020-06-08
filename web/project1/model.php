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
        echo $result["warehouse_id"];
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
    //Need to work on getting these working
function addNewCount($qoh,$qtyCounted, $writeQtyIO,$item){
  /*
  item_id int NOT NULL,
  count_date DATE NOT NULL,
  qty_start int NOT NULL,
  qty_end int NOT NULL,
  exceedsLimit boolean NOT NULL,
  warehouse_id int NOT NULL,*/
  $q1 = $db->query("INSERT INTO counts (item_id,count_date, qty_start, qty_end,warehouse_id)
  VALUES ({$item['item_id']},GETDATE(), {$qoh}, {$qtyCounted},{$item['warehouse_id']})");
  $q2 = $db->query("UPDATE counts WHERE {$writeQtyIO} > 1400
  SET exceedsLimit = true)");
  $q2 = $db->query("SELECT count_id FROM counts WHERE item_id = {$item['item_id']} AND count_date = GETDATE()");
  $countId = $q2->fetch();
  $q1 = $db->query("INSERT INTO countHistory (count_id,item_id,warehouse_id)
  VALUES ({$countId}, {$item['item_id']},{$item['warehouse_id']})");
  $q3 = $db->query("UPDATE inventory SET qoh={$qtyCounted}");
}
function addItemToBin($item,$bin,$whse,$qty){
// $q4 = $db->query("SELECT * FROM itemsWarehouse WHERE item_id = {$item} AND warehouse_id={$bin}");
//   $binExists = $q4->fetch();
//   if($binExists != null) {
      require_once "../dbAccess.php";
      $db = connectDB();
      $q1 = $db->query("INSERT INTO itemBins (item_id, bin_id, quantity, warehouse_id)
      VALUES  ({$item},{$bin}, {$qty}, {$whse})");
      $q2 = $db->query("SELECT item_id FROM itemsWarehouse WHERE item_id = {$item}");
      $inWhse = $q2->fetch();
      if($inWhse == null)
      {
        $q1 = $db->query("INSERT INTO itemsWarehouse (item_id, warehouse_id)
      VALUES  ({$item}, {$whse})");
      //echo "UPDATE inventory SET qoh = (SELECT qoh FROM inventory WHERE item_id = {$item}) + {$qty} WHERE item_id = {$item} AND inventory.warehouse_id = {$whse}";
      $q1 = $db->query("UPDATE inventory SET qoh = (SELECT qoh FROM inventory WHERE item_id = {$item} AND inventory.warehouse_id = {$whse}) + {$qty} WHERE item_id = {$item} AND inventory.warehouse_id = {$whse}");
      }
      echo "success: added item:{$item}, bin:{$bin}, Qty:{$qty}, warehouse:{$whse}";
  // }
}
function removeItemFromBin($item_id){
$q1 = $db->query("DELETE * FROM itemsList{$whse} AS il WHERE il.item_id={$item_id}");
}
function addItemToOrder(){
  //create order for each item
  //add orders to itemsOrders
  $q1 = $db->query("INSERT INTO orders (customer_id) VALUES ({$_POST['customers']})");
  // $q2 = $db->query("SELECT count_id FROM counts WHERE item_id = {$item['item_id']} AND count_date = GETDATE()");
  // $countId = $q2->fetch();

}
function addCustomer() {
  require_once "../dbAccess.php";
  $db = connectDB();
  $q1 = $db->query("INSERT INTO customers (name, email, phone, company, str_address, country, state, zip, city)
      VALUES  ('{$_POST['name']}','{$_POST['email']}',{$_POST['phone']},'{$_POST['company']}','{$_POST['str_address']}','{$_POST['country']}','{$_POST['state']}','{$_POST['zip']}','{$_POST['city']}')");
}


?>
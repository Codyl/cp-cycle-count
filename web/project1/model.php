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
function addNewCount($qoh,$qtyCounted, $writeQtyIO){
  $q1 = $db->query("INSERT INTO counts{$whse} (count_date, qty_start, qty_end)
  VALUES (GETDATE(), {$qoh}, {$qtyCounted})");
  $q2 = $db->query("UPDATE counts{$whse} WHERE {$writeQtyIO} > 1400
  SET exceedsLimit = true)");
  $q3 = $db->query("UPDATE item{$whse} SET qoh={$newAmount}");
}
function addItemToBin($item,$bin){
// $q4 = $db->query("SELECT * FROM itemsWarehouse WHERE item_id = {$item} AND warehouse_id={$bin}");
//   $binExists = $q4->fetch();
//   if($binExists != null) {
      $q1 = $db->prepare("INSERT INTO itemsBins (item_id, bin_id, quantity, warehouse_id)
      VALUES  ({$item},{$bin_id}, 1, 1)");
      $q1->execute();
      echo "success";
  // }
}
function removeItemFromBin($item_id){
$q1 = $db->query("DELETE * FROM itemsList{$whse} AS il WHERE il.item_id={$item_id}");
}
//For each item at the warehouse: display the row data
function fillTableData($i,$whse){
  $db = connectDB();
  //echo '<pre>'; var_dump($i); echo '</pre>';
  //Bins with this item at specified warehouse:id,item_id, bin_id
  $qGetItem = $db->query("SELECT * FROM itemBins WHERE item_id = {$i['item_id']}");
  $itemLoc = $qGetItem->fetchAll();

  //Gets information about the item:
  $q4 = $db->query("SELECT i.name, ib.qoh, ib.qty_avail, i.case_qty, i.case_lyr, i.item_id,i.cases_per_plt, i.cost  FROM items AS i JOIN itemBins AS ib ON ib.item_id = {$i['item_id']} WHERE i.item_id = {$i['item_id']} AND ib.warehouse_id = {$whse}");
  $itemDetails = $q4->fetchAll();

  //Test the data with var dump
  //echo var_dump($itemLoc);echo "\n";echo $itemLoc[0]["bin_id"];
  $countQty = 0;
  $writeQtyIO = 0;
  $totalCost = 0;
  //Test to ensure there is a existing item count otherwise default to 0's
  if($i['counts_id'] != NULL)
  {
      //Get count details
      $q3 = $db->query("SELECT * FROM counts{$whse} WHERE counts_id = {$i['counts_id']}");
      $count = $q3->fetchAll();
      //$writeQtyIO = $count[0]['qty_end']-$count[0]['qty_start'];
      //$totalCost = number_format($itemDetails[0]['cost']*$writeQtyIO,2);
      //$countQty = 0;//$count[0]['qty_end'];
      $lastCounted = $count[0]['count_date'];
  }
  else {
      $lastCounted = "Never been counted";
  }
      echo "<tr id='{$itemDetails[0]['name']}'>
          <td>{$itemDetails[0]['name']}</td>
          <td><textarea name='comment' id=''></textarea></td>
          <td id='qoh_{$itemDetails[0]['name']}'>{$itemDetails[0]['qoh']}</td>
          <td>{$itemDetails[0]['qty_avail']}</td>
          <td>{$itemDetails[0]['case_qty']}</td>
          <td>{$itemDetails[0]['case_lyr']}</td>
          <td><br>";
          //Pick bin
          $q4 = $db->query("SELECT b.name,il.item_id FROM bins{$whse} AS b JOIN itemList{$whse} AS il 
          ON il.bin_id = b.bin_id JOIN items{$whse} AS iw ON iw.item_id = il.item_id WHERE is_pick_bin=true");
          $binDetails = $q4->fetchAll();
          if($i["item_id"] == $binDetails[0]["item_id"])
              echo "<span id='pickCount_{$itemDetails[0]['name']}'>{$binDetails[0]['name']}</span>";
          else 
              echo "<span id='pickCount_{$itemDetails[0]['name']}' value='0'>0</span>";
          echo "<br><input type='number' class='inputData' name='pick' placeholder='Pieces' id='pickBin' onblur='changeDisplayedPickCount(\"{$itemDetails[0]['name']}\",this, \"{$itemDetails[0]['cost']}\",$i)'><br>";
          echo "</td>
          <td>";
          //Display all Whse bins with this item
          $q4 = $db->query("SELECT b.name,items.item_id,b.area FROM bins{$whse} AS b JOIN itemList{$whse} AS il ON il.bin_id = b.bin_id
          JOIN items ON items.item_id=il.item_id WHERE is_pick_bin = false");
          $binDetails = $q4->fetchAll();
          for($index = 0;$index < sizeof($binDetails);$index++){
              if($i["item_id"]==$binDetails[$index]["item_id"]){
                  echo "{$binDetails[$index]['name']}";
                  if($binDetails[$index]["area"] == 'A')
                      echo "<br><input type='number' class='inputData' name='cases' placeholder='Cases' onchange='changeDisplayedCaseCount(\"{$itemDetails[0]['name']}\",this,\"{$itemDetails[0]['case_qty']}\", \"{$itemDetails[0]['cost']}\")'><br>";
                  else
                      echo "<br><input type='number' class='inputData' name='cases' placeholder='Pallets' onchange='changeDisplayedPalletCount(\"{$itemDetails[0]['name']}\",this,\"{$itemDetails[0]['case_qty']}\",\"{$itemDetails[0]['cases_per_plt']}\", \"{$itemDetails[0]['cost']}\")'><br>";
              }
          }
          //$trName = $itemDetails[0]['name'];//echo $trName;
          echo "</td>
          <td><span id='count_{$itemDetails[0]['name']}'>{$countQty}</span> pc</td>
          <td><span id='writeIO_{$itemDetails[0]['name']}'>{$writeQtyIO}</span> pc</td>
          <td>$<span id='totalCost_{$itemDetails[0]['name']}'>$totalCost</span></td>
          <td><button type='submit' value='Update' id='update' onclick='removetr({$itemDetails[0]['name']})'>Update</button></td>
          <td>$lastCounted<br>";
          if($lastCounted != "Never been counted")
          echo "<button type='button' value='Count History' id='countButton'>View Count History</button></td>
      </tr>";
}


?>
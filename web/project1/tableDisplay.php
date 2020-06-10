<?php

  session_start();
  if ( ! isset($_SESSION["user_id"])) {
    header("Location: /project1/?action=sign-in");
    die();
  }
?>
<?php
function displayTable($numToCount){
    require_once "../dbAccess.php";
    $db = connectDB();
    //Identifiess warehouse abbrev. for psql tables
    $whse = "";

    
    $q = $db->query("SELECT * FROM countHistory");
    $countHistory = $q->fetchAll();
$q = $db->query("SELECT * FROM itemsWarehouse WHERE warehouse_id = {$_POST['warehouse']}");
    $itemList = $q->fetchAll();
    $q->closeCursor();

    $numCountsComplete = sizeof($countHistory);

    $numItems = sizeof($itemList);

    //Table display
    echo "<span id='totalCount'>{$numCountsComplete} of {$numItems} counted</span>";
    echo "<br><div id='numToCount'>Next {$numToCount} items to Count</div>";
    echo "<table id='itemsTable'>";
    echo "<tr>
            <th>Item</th>
            <th>Comment</th>
            <th>QOH</th>
            <th>Qty Avail</th>
            <th>Case</th>
            <th>Case Lyr</th>
            <th>Pick Bin</th>
            <th>WH Bin(s)</th>
            <th>Count</th>
            <th>Write In/Out</th>
            <th>Cost</th>
            <th>Update</th>
            <th>Last counted</th>
          </tr>";
        //Identify items to be displayed *warehouse, oldest count, 
    $q = $db->query("SELECT i.warehouse_id, it.item_id, c.count_date, c.count_date, c.counts_id, it.case_qty  FROM itemsWarehouse i 
    JOIN items it ON it.item_id=i.item_id
LEFT JOIN counts c ON c.item_id=i.item_id WHERE i.warehouse_id={$_POST['warehouse']}");
    $itemsByLoc = $q->fetchAll();
    $index = 0;
    foreach($itemsByLoc as $i){
        fillTableData($i,$_POST['warehouse']);
    }
    echo "</table>";
}
//Displays a single item 
function itemDisplay(){
    require_once "../dbAccess.php";
    $whse = "";
    if($_POST['warehouse'] == 1) {$whse = "Ky";}
    elseif($_POST['warehouse'] == 2) {$whse = "Idaho";}
    else{echo "Invalid warehouse";}
    $db = connectDB();
    $q3 = $db->query("SELECT * FROM counts");
    $countList = $q3->fetchAll();
    $q3 = $db->query("SELECT * FROM itemsWarehouse");
    $itemList = $q3->fetchAll();
    
    $numCountsComplete = sizeof($countList);
    $numItems = sizeof($itemList);

    try{
    $q = $db->query("SELECT itemsWarehouse.item_id,counts.counts_id, itemsWarehouse.warehouse_id FROM itemsWarehouse 
                    JOIN items ON items.item_id=itemsWarehouse.item_id 
                    LEFT JOIN counts ON counts.item_id=items.item_id
                    WHERE items.name='{$_POST['viewCount']}'");
    $item = $q->fetchAll();
    if(!empty($item)){
        echo "<h1>{$_POST['viewCount']}</h1>";
        echo "<span id='totalCount'>{$numCountsComplete} of {$numItems} counted</span>";
        echo "<br><div id='numToCount'>Count on {$_POST['viewCount']}</div>";
        echo "<table id='itemsTable'>";
        echo "<tr>
            <th>Name</th>
            <th>Comment</th>
            <th>QOH</th>
            <th>Qty Avail</th>
            <th>Case</th>
            <th>Case Lyr</th>
            <th>Pick Bin</th>
            <th>WH Bin(s)</th>
            <th>Count</th>
            <th>Write In/Out</th>
            <th>Cost</th>
            <th>Update</th>
            <th>Recent counts</th>
          </tr>";
        fillTableData($item[0],$whse);
        }
        else{echo "<script type='text/javascript'>alert('Invalid item name for {$_POST['warehouse']}');</script>";}
    }
    catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}
//For each item at the warehouse: display the row data
function fillTableData($i,$whse){
    $db = connectDB();
    $qGetItem = $db->query("SELECT * FROM itemBins WHERE item_id = {$i['item_id']}");
    $itemLoc = $qGetItem->fetchAll();
  
    //Gets information about the item:
    $q4 = $db->query("SELECT i.name, inv.qoh, inv.qty_avail, i.case_qty, i.case_lyr, i.item_id,i.case_plt, i.cost  FROM items AS i 
    JOIN itemBins AS ib ON ib.item_id = {$i['item_id']} 
    JOIN inventory AS inv ON inv.item_id= {$i['item_id']}
    WHERE i.item_id = {$i['item_id']} AND ib.warehouse_id = {$i['warehouse_id']}");
    $itemDetails = $q4->fetchAll();
  
    //Test the data with var dump
    $countQty = 0;
    $writeQtyIO = 0;
    $totalCost = 0;
    //Test to ensure there is a existing item count otherwise default to 0's
    if($i['counts_id'] != NULL)
    {
        //Get count details
        // $q3 = $db->query("SELECT * FROM counts{$whse} WHERE counts_id = {$i['counts_id']}");
        // $count = $q3->fetchAll();
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
            $q4 = $db->query("SELECT b.name,iw.item_id FROM bins AS b 
            JOIN itemBins AS ib ON ib.bin_id = b.bin_id 
            JOIN itemsWarehouse AS iw ON iw.item_id = ib.item_id 
            WHERE b.is_pick_bin=true AND b.warehouse_id='{$i['warehouse_id']}'");
            $binDetails = $q4->fetchAll();
            // echo '<pre>'; var_dump($binDetails); echo '</pre>';
            //if($binDetails["item_id"])
            if($i["item_id"] == $binDetails[0]["item_id"])
                echo "<span id='pickCount_{$itemDetails[0]['name']}'>{$binDetails[0]['name']}</span>";
            else 
                echo "<span id='pickCount_{$itemDetails[0]['name']}' value='0'>0</span>";
            echo "<br><input type='number' min=0 class='inputData' name='pick' placeholder='Pieces' id='pickBin_{$itemDetails[0]['name']}' onblur='changeDisplayedPickCount(";
            echo json_encode($itemDetails[0]);echo ")'><br>";
            echo "</td>
            <td>";
            //Display all Whse bins with this item
            $q5 = $db->query("SELECT b.name,iw.item_id,b.area FROM bins b 
            JOIN itemBins ib ON ib.bin_id = b.bin_id
            JOIN itemsWarehouse iw ON iw.item_id=ib.item_id
            WHERE b.is_pick_bin=false AND ib.warehouse_id={$i['warehouse_id']}");
            $binDetails = $q5->fetchAll();
            for($index = 0;$index < sizeof($binDetails);$index++){
                if($i["item_id"]==$binDetails[$index]["item_id"]){
                    echo "{$binDetails[$index]['name']}";
                    if($binDetails[$index]["area"] == 'A'){
                        echo "<br><input type='number' min=0 class='inputData caseCount_{$itemDetails[$index]['name']}' name='cases' placeholder='Cases' onblur='changeDisplayedCaseCount(";
                        echo json_encode($itemDetails[0]);echo ")'><br>";
                    }
                        
                    else {
                        echo "<br><input type='number' min=0 class='inputData pltCount_{$itemDetails[$index]['name']}' name='cases' placeholder='Pallets' onblur='changeDisplayedPickCount(";
                        echo json_encode($itemDetails[0]);echo ")'><br>";
                    }
                        
                }
            }
            require_once "model.php";
            echo "</td>
            <td><span id='count_{$itemDetails[0]['name']}'>{$countQty}</span> pc</td>
            <td><span id='writeIO_{$itemDetails[0]['name']}'>{$writeQtyIO}</span> pc</td>
            <td>$<span id='totalCost_{$itemDetails[0]['name']}'>$totalCost</span></td>
            <td><button type='submit' value='Update' id='update' onclick='addNewCount1({$itemDetails[0]['qoh']},{$countQty}.{$writeQtyIO},";echo json_encode($itemDetails[0]);echo ");removetr({$itemDetails[0]['name']})'>Update</button></td>
            <td>$lastCounted<br>";
            if($lastCounted != "Never been counted")
            echo "<button type='button' value='Count History' id='countButton'>View Count History</button></td>
        </tr>";
  }

?>
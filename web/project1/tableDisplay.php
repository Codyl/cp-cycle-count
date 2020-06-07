<?php
function displayTable($numToCount){
    require_once "../dbAccess.php";
    $db = connectDB();
    //Identifiess warehouse abbrev. for psql tables
    $whse = "";
    if($_POST['warehouse'] == "Kentucky") {
        $whse = 1;
    }
    else{
        $whse = 2;
    }
    
    $q = $db->query("SELECT * FROM countHistory");
    $countHistory = $q->fetchAll();
$q = $db->query("SELECT * FROM itemsWarehouse WHERE warehouse_id = {$whse}");
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
        $q = $db->query("SELECT itemsWarehouse.item_id,counts.counts_id FROM itemsWarehouse
         JOIN counts ON itemsWarehouse.item_id=counts.item_id WHERE counts.warehouse_id={$whse} ORDER BY counts.count_date ASC LIMIT {$numToCount}");
        $itemsByLoc = $q->fetchAll();
        $index = 0;
    foreach($itemsByLoc as $i){
        fillTableData($i,$whse);
    }
    echo "</table>";
}
//Displays a single item 
function itemDisplay(){
    require_once "../dbAccess.php";
    $whse = "";
    if($_POST['warehouse'] == "Kentucky") {$whse = "Ky";}
    elseif($_POST['warehouse'] == "Idaho") {$whse = "Idaho";}
    else{echo "Invalid warehouse";}
    $db = connectDB();
    $q3 = $db->query("SELECT * FROM counts{$whse}");
    $countList = $q3->fetchAll();
    $q3 = $db->query("SELECT * FROM items{$whse}");
    $itemList = $q3->fetchAll();
    
    $numCountsComplete = sizeof($countList);
    $numItems = sizeof($itemList);

    try{
    $q = $db->query("SELECT items{$whse}.id,items{$whse}.item_id,items{$whse}.counts_id FROM items{$whse} 
                    JOIN items ON items.item_id=items{$whse}.item_id WHERE items.name='{$_POST['viewCount']}'");
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
//Need to work on getting these working
function addNewCount($qoh,$qtyCounted, $writeQtyIO){
    $q1 = $db->query("INSERT INTO counts{$whse} (count_date, qty_start, qty_end)
    VALUES (GETDATE(), {$qoh}, {$qtyCounted})");
    $q2 = $db->query("UPDATE counts{$whse} WHERE {$writeQtyIO} > 1400
    SET exceedsLimit = true)");
    $q3 = $db->query("UPDATE item{$whse} SET qoh={$newAmount}");
}
function addItemToBin($i){
    echo "worked!";
    //search to see if the bin exists in the database
    //add this as a new bin in the bins{$whse}
    $q4 = $db->query("SELECT * FROM bins{$whse} WHERE item_id = {$i['item_id']}");
    $binExists = $q4->fetch();
    if($binExists != null) {
        $q1 = $db->query("INSERT INTO bins{$whse} (is_pick_bin, area, row, rack, shelf_lvl)
        VALUES  (false, 'A', 1, 1, 1),");
    }
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
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
    $q3 = $db->query("SELECT * FROM counts");
    $countList = $q3->fetchAll();
    $q3 = $db->query("SELECT * FROM items");
    $itemList = $q3->fetchAll();
    
    $numCountsComplete = sizeof($countList);
    $numItems = sizeof($itemList);

    try{
    $q = $db->query("SELECT itemsWarehouse.item_id,itemsWarehouse.counts_id FROM itemsWarehouse 
                    JOIN items ON items.item_id=itemsWarehouse.item_id WHERE items.name='{$_POST['viewCount']}'");
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


?>
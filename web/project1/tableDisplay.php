<?php
    function displayTable($numToCount){
    require_once "dbAccess.php";
    $db = connectDB();
    $whse = "";
    if($_POST['warehouse'] == "Kentucky") {$whse = "Ky";}
    elseif($_POST['warehouse'] == "Idaho") {$whse = "Idaho";}
    else{echo "Invalid warehouse";}
    
    

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
    //Identify details for each item
//     //Columns for items by warehouse:  item_id serial8 NOT NULL,
//   name varchar(100) NOT NULL UNIQUE,
//   cost float8 NOT NULL,
//   description varchar(100),
//   qoh int NOT NULL,
//   qty_avail int NOT NULL,
//   case_qty int NOT NULL,
//   case_lyr int NOT NULL,
        $q = $db->query("SELECT * FROM items{$whse} ORDER BY item_id ASC LIMIT {$numToCount}");
        $itemsByLoc = $q->fetchAll();
    foreach($itemsByLoc as $i){
        //Queries to be used to find item details
        
        //Columns for itemsList by warehouse per bin(multiple bins per item):id,item_id, bin_id
        $qGetItem = $db->query("SELECT * FROM itemList{$whse} WHERE item_id = {$i['item_id']}");
        $itemLoc = $qGetItem->fetchAll();
        //Columns for bins by warehouse:
//             bin_id serial8,
//   name varchar(12),
//   is_pick_bin boolean,
//   area varchar(1),
//   row int,
//   rack int,
//   shelf_lvl int,
        $q2 = $db->query("SELECT * FROM bins{$whse} WHERE bin_id = {$itemLoc[0]['bin_id']}");
        $bin = $q2->fetchAll();
        //Columns for all items in existence at c&p:
        $q4 = $db->query("SELECT * FROM items WHERE item_id = {$itemLoc[0]['item_id']}");
        $itemDetails = $q4->fetchAll();
        //Test the data with var dump
        //echo var_dump($itemLoc);echo "\n";echo $itemLoc[0]["bin_id"];
        
        //Test to ensure there is a existing item count otherwise default to 0's
        if($i['counts_id'] != NULL)
        {
            
            $q3 = $db->query("SELECT * FROM counts{$whse} WHERE counts_id = {$i['counts_id']}");
            $count = $q3->fetchAll();
            $writeQtyIO = $count[0]['qty_end']-$count[0]['qty_start'];
            $totalCost = number_format($itemDetails[0]['cost']*$writeQtyIO,2);
            $countQty = $count[0]['qty_end'];
            $lastCounted = $count[0]['count_date'];
        }
        else
        {
            $countQty = 0;
            $lastCounted = "Never been counted";
            $writeQtyIO = 0;
            $totalCost = 0;
        }
            echo "<tr>
                <td>{$itemDetails[0]['name']}</td>
                <td><textarea name='comment' id=''></textarea></td>
                <td>{$itemDetails[0]['qoh']}</td>
                <td>{$itemDetails[0]['qty_avail']}</td>
                <td>{$itemDetails[0]['case_qty']}</td>
                <td>{$itemDetails[0]['case_lyr']}</td>
                <td><br><input type='text' class='inputData' name='pick' placeholder='Pieces'></td>
                <td>";
                    foreach($bin as $b){
                        echo "{$b[3]}:{$b[4]}:{$b[5]}:{$b[6]}";
                        echo "<br><input type='text' class='inputData' name='cases' placeholder='Cases'></td>";
                    }
                echo "<td>$countQty pc</td>
                <td>$writeQtyIO pc</td>
                <td>$$totalCost</td>
                <td><button type='submit' value='Update' id='update'>Update</button></td>
                <td>$lastCounted</td>
        </tr>";
    }
    echo "</table>";
}
?>
<script>
    function sortByTh(th){
        // switch(th){
        //     case "item":
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
        //         break;
        //     case "qoh"://case 1: cannot sort by comments, not a valid sort
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY qoh DESC");
        //     case "qty avail":
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY qty_avail DESC");
        //         break;
        //     case "case":
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY case_qty DESC");
        //         break;
        //     case "case lyr":
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY case_lyr DESC");
        //         break;
        //     case "pick bin":
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY pick DESC");
        //         break;
        //     case 0:
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY whbin DESC");
        //         break;
        //     case 0:
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY count DESC");
        //         break;
        //     case 0:
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY writein DESC");
        //         break;
        //     case 0:
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY cost DESC");
        //         break;
        //     case 0:
        //         $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY last_counted DESC");
        //         break;
        //     default:
        //         echo "Unexpected error on attempted sorting method.";
        // }
    }
</script>
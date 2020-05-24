<?php
    function displayTable($numToCount){
    require_once "dbAccess.php";
    $db = connectDB();
    $q = $db->query("SELECT * FROM items ORDER BY name ASC LIMIT {$numToCount}");
    $items = $q->fetchAll();

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
    foreach($items as $i){
    $q2 = $db->query("SELECT * FROM bins WHERE bin_id = {$i['bin_id']}");
    $bin = $q2->fetchAll();
    if($i['counts_id'] != NULL)
    {
        $q3 = $db->query("SELECT * FROM counts WHERE counts_id = {$i['counts_id']}");
        $count = $q3->fetchAll();
        $writeQtyIO = $count[0]['qty_end']-$count[0]['qty_start'];
        $totalCost = number_format($i['cost']*$writeQtyIO,2);
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
            <td>{$i['name']}</td>
            <td><textarea name='comment' id=''></textarea></td>
            <td>{$i['qoh']}</td>
            <td>{$i['qty_avail']}</td>
            <td>{$i['case_qty']}</td>
            <td>{$i['case_lyr']}</td>
            <td><br><input type='text' class='inputData' name='pick' placeholder='Pieces'></td>
            <td>{$bin[0][3]}:{$bin[0][4]}:{$bin[0][5]}:{$bin[0][6]}:{$bin[0][7]}<br><input type='text' class='inputData' name='cases' placeholder='Cases'></td>
            <td>$countQty pc</td>
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
        switch(th){
            case "item":
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case "qoh"://case 1: cannot sort by comments, not a valid sort
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name qoh");
            case "qty avail":
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case "case":
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case "case lyr":
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case "pick bin":
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case 0:
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case 0:
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case 0:
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case 0:
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            case 0:
                $sortedQuery = $db->query("SELECT * FROM items LIMIT {$numToCount} ORDER BY name DESC");
                break;
            default:
                echo "Unexpected error on attempted sorting method.";
        }
    }
</script>
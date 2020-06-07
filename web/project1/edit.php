<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="async.js">setWarehouse(1);</script>
    <script src="model.php"></script>
</head>
<body>
<h1>Admin: add item page</h1>
    <form>
        <select name="warehouse" id="warehouse" onchange=''>
            <option value=""></option>
            <?php
                require_once "../dbAccess.php";
                $db = connectDB();
                $q = $db->query("SELECT name FROM warehouses");
                $warehouses = $q->fetchAll();
                for($i = 0; $i < sizeof($warehouses);$i++) {
                    echo "<option value='{$i}'>{$warehouses[$i]['name']}</option>";
                    
                }
            ?>
        </select>
        <select name="item" id="">
        <option value=""></option>
        <?php
                require_once "../dbAccess.php";
                $db = connectDB();
                $q = $db->query("SELECT name FROM items");
                $items = $q->fetchAll();
                foreach($items as $item) {
                    echo "<option>{$item["name"]}</option>";
                }
            ?>
        </select>
        <select name="bin" id="">
        <option value=""></option>
        <?php
            
                require_once "../dbAccess.php";
                $db = connectDB();
            $q = $db->query("SELECT name FROM bins WHERE bins.warehouse_id =1");
                $warehouses = $q->fetchAll();
                foreach($warehouses as $warehouse) {
                    echo "<option>{$warehouse[0]}</option>";
                }
            ?>
        </select>
        <button type="submit" onsubmit="addItemToBin(document.getElementById('warehouse').selectedIndex, document.getElementById('bin').selectedIndex)">Add item</button>
    </form>
</body>
</html>
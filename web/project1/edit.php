<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="async.js"></script>
</head>
<body>
<h1>Admin: add item page</h1>
    <form onload="setWarehouse(<?php echo $_SESSION['warehouse'];?>)">
        <select name="warehouse" id="warehouse" onchange='this.form.submit()'>
        <option value=""></option>
            <?php
                require_once "../dbAccess.php";
                $db = connectDB();
                $q = $db->query("SELECT name FROM warehouses");
                $warehouses = $q->fetchAll();
                foreach($warehouses as $warehouse) {
                    echo "<option>{$warehouse["name"]}</option>";
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
            $q = $db->query("SELECT name FROM bins WHERE bins.warehouse_id ={$_POST['warehouseSelect']}");
                $warehouses = $q->fetchAll();
                foreach($warehouses as $warehouse) {
                    echo "<option>{$warehouse[0]}</option>";
                }
            ?>
        </select>
        <button type="submit">Add item</button>
    </form>
</body>
</html>
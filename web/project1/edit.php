<?php

  session_start();
  if ( ! isset($_SESSION["user_id"]) || $_SESSION["user_id"] != 1) {
    header("Location: /project1/?action=sign-in");
    die();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit warehouse</title>
    <script src="async.js">setWarehouse(1);</script>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body onload="setWarehouse(<?php echo $_SESSION['warehouse'];?>)">
<nav>
    <img src="logo.svg" alt="C&P Logo" id="logo">
    <a href="sign-in.php"><div class="right buttonBox">Sign out</div></a>
    <a href="countPage.php"><div class="right buttonBox">Count Page</div></a>
</nav>
<h1>Add item to warehouse</h1>
<?php
//If all parts of form are filled
if($_POST['bin'] && $_POST['qty'] && $_POST['warehouse'] && $_POST['item']) {
    require_once 'model.php';
    addItemToBin($_POST['item'], $_POST['bin'],$_POST['warehouse'],$_POST['qty']);
}//if warehouse has been chosen keep its value in the form
else if($_POST['warehouse']){
    echo "<input type='hidden' id='hidden' value='{$_POST['warehouse']}' >";
}
?>

    <form action='#' method='POST'>
        <label for="warehouse">warehouse: </label>
        <select name="warehouse" id="warehouse" onchange="this.form.submit()">
            <option value=""></option>
            <?php
                require_once "../dbAccess.php";
                $db = connectDB();
                $q = $db->query("SELECT name FROM warehouses");
                $warehouses = $q->fetchAll();
                for($i = 0; $i < sizeof($warehouses);$i++) {
                    $num = $i+1;
                    echo "<option value='{$num}'>{$warehouses[$i]['name']}</option>";
                    
                }
            ?>
        </select>
        <label for="item">item: </label>
        <select name="item" id="">
        <option value=""></option>
        <?php
            require_once "../dbAccess.php";
            $db = connectDB();
            $q = $db->query("SELECT name, item_id FROM items ORDER BY item_id");
            $items = $q->fetchAll();
            foreach($items as $item) {
                echo "<option value = '{$item['item_id']}'>{$item["name"]}</option>";
            }
        ?>
        </select>
        <label for="bin">Bin: </label>
        <select name="bin" id="bin">
        <option value=""></option>
        <?php
            
            require_once "../dbAccess.php";
            $db = connectDB();
            $id = 0;
            if(empty($_SESSION['set_warehouse']))
                $id = $_POST['warehouse'];
            else
                $id = $_SESSION['set_warehouse'];
            $q = $db->query("SELECT name, bin_id FROM bins WHERE bins.warehouse_id={$id} ORDER BY bin_id");
            $warehouses = $q->fetchAll();
            foreach($warehouses as $warehouse) {
                echo "<option value = '{$warehouse['bin_id']}'>{$warehouse[0]}</option>";
            }
        ?>
        </select><br>
        <label for="qty">Enter Quantity
            <input type="number" name="qty" id="qty">
        </label>
        <button type="submit" onsubmit="">Add item</button>
    </form>
    <script>if(document.getElementById('hidden'))document.getElementById('warehouse').selectedIndex=document.getElementById('hidden').value;</script>
</body>
</html>
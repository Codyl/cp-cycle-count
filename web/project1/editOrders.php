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
    <title>Edit Orders</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="async.js"></script>
</head>
<body>
    <nav>
        <img src="logo.svg" alt="C&P Logo" id="logo">
        <a href="sign-in.php"><div class="right buttonBox">Sign out</div></a>
        <a href="edit.php"><div class="right buttonBox">Edit database</div></a>
        <a href="countPage.php"><div class="right buttonBox">Count Page</div></a>
        <a onclick='alert("increasing orders: will decrease qty available. Increasing items will add more to the count list. Items with the oldest count display last in the table. Bins should not display more than once. A bin is where an item is located in the warehouse.")'><div class="right buttonBox">. ? .</div></a>
        <a href="addCustomer.php"><div class="right buttonBox">Add customer</div></a>
    </nav>
    <h1>Edit Orders</h1>
    <summary>Insert the following information:</summary>
    <form action="" method="post">
        <div id="orderForm">
            <div id='itemDiv1'>
                <label for="customers">Customer: </label>
                <select name="customers">
                    <option value=""></option>
                    <?php
                        require_once "../dbAccess.php";
                        $db = connectDB();
                        $q = $db->query("SELECT name FROM customers ORDER BY name");
                        $customers = $q->fetchAll();
                        foreach($customers as $customer) {
                            echo "<option value = '{$customer['customer_id']}'>{$customer["name"]}</option>";
                        }
                        if(sizeof($customers) == 0){ echo "You need to create a customer before continuing";}
                    ?>
                </select>
                <label for="item">Please select an item: </label>
                <select name="item" id="">
                <option value=""></option>
                <?php
                    require_once "../dbAccess.php";
                    $db = connectDB();
                    $q = $db->query("SELECT name, item_id FROM itemsWarehouse ORDER BY item_id");
                    $items = $q->fetchAll();
                    foreach($items as $item) {
                        echo "<option value = '{$item['item_id']}'>{$item["name"]}</option>";
                    }
                ?>
                </select>
                <label for="qty">Enter Quantity
                    <input type="number" name="qty" id="qty">
                </label>
                <br>
            </div>
        </div>
        <div class="left buttonBox" onclick='addItemToOrder()'>+Add item</div>
        <br><br><input type="submit" value="Complete order">
    </form>
    
</body>
</html>
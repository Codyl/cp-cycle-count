<!--
    TO DO:
    1. finish sorting func
    2. Update database with submitted form
    3. animation
    4. be able to add orders
-->
<?php

  session_start();
  if ( ! isset($_SESSION["user_id"])) {
    header("Location: /project1/?action=sign-in");
    die();
  }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Item Count</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="async.js"></script>
    </head>
    <body onload="setWarehouse(<?php echo $_SESSION['warehouse'];?>)">
        <nav>
            <img src="logo.svg" alt="C&P Logo" id="logo">
            <a href="/project1/?action=sign-out"><div class="right buttonBox">Sign out</div></a>
            <?php 
            echo "id:{$_SESSION['user_id']} end";
            if($_SESSION["user_id"] == 1){
                echo "<a href='edit.php'><div class='right buttonBox'>Edit database</div></a><a href='editOrders.php'><div class='right buttonBox'>Edit orders</div></a>";
            }
            echo "x";
            ?>
            
            <a onclick='alert("increasing orders: will decrease qty available. Increasing items will add more to the count list. Items with the oldest count display last in the table. Bins should not display more than once. A bin is where an item is located in the warehouse.")'><div class="right buttonBox" style='padding-left:10px;padding-right:10px'>?</div></a>
        </nav>
        <h1>Item Count</h1>
        <form action="/project1/?action=countPage" method="post" id="myForm" name="inventory">
            <label for="warehouse">Warehouse</label>
            <select name="warehouse" id="warehouse">
                <option value=""></option>
                <?php
                    require_once "../dbAccess.php";
                    $db = connectDB();
                    $q = $db->query("SELECT name FROM warehouses");
                    $warehouses = $q->fetchAll();
                    foreach($warehouses as $warehouse) {
                        echo "<option>{$warehouse['name']}</option>";
                    }
                ?>
            </select>
            
            <label for="recordCount">Record count</label>
            <select name="recordCount" id="recordCount" onchange="this.form.submit()">
                <option value=""></option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <span>or</span>
            <label for="viewCount">Count specified item: </label>
            <input type="text" name="viewCount" id="viewCount" placeholder='item name' onblur="itemDisplay()">
        </form>
        <div id='countHistory'></div>
        <!-- After form is filled next section appears -->
        <?php
            require_once "../dbAccess.php";
            require_once "tableDisplay.php";
            if(!empty($_POST))
            {
                if(!empty($_POST['recordCount'])){
                    echo "<h2 id='warehouseTitle'>Item count for {$_POST['warehouse']}</h2>";
                    displayTable($_POST['recordCount']);
                }
                elseif(isset($_POST['viewCount'])){
                    itemDisplay();
                }
            }
        ?>
    </body>
</html>
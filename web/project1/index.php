<!--
    TO DO:
    1. finish sorting func
    2. Update database with submitted form
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Item Count</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="async.js"></script>
    </head>
    <body>
        <nav>
            <img src="logo.svg" alt="C&P Logo" id="logo">
        </nav>
        <h1>Item Count</h1>
        <form action="index.php" method="post" id="myForm" name="inventory">
            <label for="warehouse">Warehouse</label>
            <select name="warehouse" id="warehouse" onchange="showRCOpt()">
                <option value=""></option>
                <option value="Kentucky">Kentucky</option>
                <option value="Idaho">Idaho</option>
            </select>
            
            <label for="recordCount">Record count</label>
            <select name="recordCount" id="recordCount" disabled onchange="this.form.submit()">
                <option value=""></option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <span>or</span>
            <label for="viewCount">Count specified item: </label>
            <input type="text" name="viewCount" id="viewCount" placeholder='item name' disabled onblur="itemDisplay()">
        </form>
        <div id='countHistory'></div>
        <!-- After form is filled next section appears -->
        <?php
            require_once "dbAccess.php";
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
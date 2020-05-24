<!--
    TO DO:
    //1. resolve notices/bug
    2. seperate warehouses(items, counts, bins)
    3. item page
    4. finish sorting func
    5.5. Allow for many warehouse bins
    5. Update database with submitted form
    6. Hide row after update
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <nav>
        <img src="logo.svg" alt="C&P Logo" id="logo">
    </nav>
    <h1>Item Count</h1>
    <form action="index.php" method="post" id="myForm">
        <label for="warehouse">Warehouse</label>
        <select name="warehouse" id="warehouse" onchange="showRCOpt()">
            <option value=""></option>
            <option value="Kentucky">Kentucky</option>
            <option value="Idaho">Idaho</option>
        </select>
        <script>
            if(typeof $_POST !== 'undefined'){
                document.getElementbyId("warehouse").value=$_POST["warehouse"];
            }
        </script>
        
        <label for="recordCount">Record count</label>
        <select name="recordCount" id="recordCount" disabled onchange="this.form.submit()">
            <option value=""></option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
        </select>
        <script>
            if(typeof $_POST !== 'undefined'){
                showRCOpt();document.getElementbyId("recordCount").value=$_POST["recordCount"];
            }
        </script>
        <span>Or</span>
        <label for="viewCount">View existing count</label>
        <input type="text" name="viewCount" id="viewCount" placeholder='item name' onblur="goToItemView()">
    </form>
    <!-- After php forn filled next section appears -->
    <?php
        require_once "dbAccess.php";
        require_once "tableDisplay.php";
        if(!empty($_POST))
        {
            // $db = connectDB();
            // $q = $db->query("SELECT * FROM items");
            // $warehouses = $q->fetchAll();
            echo "<h2 id='warehouseTitle'>Item count for {$_POST['warehouse']}</h2>";
            echo "<span id='totalCount'>{} of {} counted</span>";
            displayTable($_POST['recordCount']);
        }
    ?>
    <script>
        function showRCOpt(){
            document.getElementById("recordCount").disabled = false;
        }
        function goToItemView(){
            // var db = connectDB();
            // var item = document.getElementById('viewCount').value;
            // var q = db->query("SELECT name FROM items WHERE name = {$item}");
            // var name = q->fetchAll();
            // if(name != NULL){
                document.getElementById('myForm').action = 'viewItem.php';
                document.getElementById('myForm').submit();
            // }
            // else{
            //     alert("Error: Invalid item.");
            // }
            
        }
    </script>
</body>
</html>
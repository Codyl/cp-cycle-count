<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav>
        <img src="logo.svg" alt="C&P Logo">
    </nav>
    <form action="index.php" method="post">
    <label for="warehouse">warehouse</label>
    <select name="warehouse" id="warehouse" onchange=showRCOpt()>
        <option value=""></option>
        <option value="Kentucky">Kentucky</option>
        <option value="Idaho">Idaho</option>
    </select>
    <br>
    <label for="record count">record count</label>
    <select name="record count" id="record count" disabled onchange="this.form.submit()">
        <option value=""></option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
    </select>
    </form>
    <!-- After php forn filled next section appears -->
    <?php
        require_once "dbAccess.php";
        $db = connectDB();
        $q = $db->query("SELECT * FROM warehouses");
        $warehouses = $q->fetchAll();

        // var_dump($scriptures);
        foreach($warehouses as $w){
            echo "<p><b>{$w['name']}</b></p>";
        }
        echo "<h2>Item count for {$_POST['warehouse']}</h2>";
        echo "{}of{}counted";
    ?>
    
    <table>
    <tr>
        <th></th>
    </tr>
    </table>
    <script>
        function showRCOpt(){
            document.getElementById("record count").disabled = false;
        }
    </script>
</body>
</html>
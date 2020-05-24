<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item view</title>
</head>
<body>
</body>
</html>
<?php
    require_once "dbAccess.php";
    $db = connectDB();
    echo $_POST['viewCount'];
    $q = $db->query("SELECT * FROM items WHERE items.name = {$_POST['viewCount']}");
    $item = $q->fetchAll();
    var_dump($item);
    echo "<h1>{$_POST['viewCount']}</h1>";
    echo "<span>info from database</span>";
    echo "<table>
        <tr></tr>
        <tr>
            <td>{$item[0][0]}</td>
        </tr>
    </table>";
    
?>
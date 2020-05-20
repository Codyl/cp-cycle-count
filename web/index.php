<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Scripture Resources</h1>

    <?php
        require_once "dbAccess.php";
        $db = connectDB();
        $q = $db->query("SELECT * FROM scriptures");
        $scriptures = $q->fetchAll();

        // var_dump($scriptures);
        foreach($scriptures as $s){
            //var_dump($s['book']);
            echo "<p><b>{$s['book']} {$s['chapter']}:{$s['verse']}</b> - \"{$s['content']}\"</p>";
        }
    ?>
</body>
</html>
<!DOCTYPE html>
<!--
    Teacher: Brother Porter
    Name: Cody Lillywhite
    Class: cs341
    Summary: This is my home page for cs341.
-->
<html>
    <head>
    <meta charset="utf-8" />
        <meta name="description" content="Web assignment">
        <meta name="keywords" content="HTML">
        <meta name="author" content="Cody Lillywhite">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
        <title>CHL CS341 Homepage</title>
    </head>
    <body>
        
        <img src=""/>
        <form action="index.php" method="post">
            
            Enter your name!: <input name="data" type="text"/>
            <input type="submit" onclick="testText()"/>
        </form>
        <?php
            
            $age = 21 + 1;
            $name = "Cody";
            $visitor = $_POST["data"];
            $interests = array("woodworking", "drawing", "making crafts", "playing Dungeons and dragons with friends");
            echo "<p1><b>". $name . " Homepage" . "</b></p1>";
            echo "Hello ". $visitor .", my name is " . $name . ". I am " . $age . ".\n My interests are ...";
            echo '<pre>'; 
            for($i = 0; $i < count($interests);$i++)
            {
                if($i < count($interests) - 1)
                {echo $interests[$i] . ", ";}
                else
                {echo $interests;}
            } echo '</pre>';
            echo "<p id='demo'> ???</p>";
            echo "<table><tr><th>Assignment Name</th><th>Link to assignment</th><th>Comments</th></tr></table>";
        ?>
    </body>
</html>

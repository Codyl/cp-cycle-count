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
        <script src="https://kit.fontawesome.com/yourcode.js"></script>
        <link rel = "icon" href = "https://fontawesome.com/icons/laptop-code?style=solid" type = "image/x-icon">
    </head>
    <body>
        <?php 
        $name = "Cody";
        echo "<p1><b>". $name . " Homepage" . "</b></p1>";
        ?>
        <img id="photo" src="myPhoto.jpeg"/>
        <form name="formSec" action="index.php" method="post">
            
            Enter your name!: <input name="data" type="text"/>
            <input type="submit" onclick="testText()"/>
        </form>
        <div id="bioSec">
        <?php
            
            $age = 21 + 1;
            $visitor = $_POST["data"];
            $interests = array("woodworking", "drawing", "making crafts", "playing Dungeons and dragons with friends");
            echo "<p2>About me</p2>";
            echo "<summary>";
            echo "Hello ". $visitor .", my name is " . $name . ". I am " . $age . ".\n My interests are ...";
            echo '<pre>'; 
            for($i = 0; $i < count($interests);$i++)
            {
                if($i < count($interests) - 1)
                {echo $interests[$i] . ", ";}
                else
                {echo "and " . $interests[$i] . ". ";}
            } echo '</pre>';
            echo "</summary>";
        ?>
        </div>
        </br>
        <div id="assignSec">
        <?php
            $assignments = array(
                array("hello php world!", "<a href='https://sleepy-brushlands-64789.herokuapp.com/hello.html'>Click here</a>", "took a while to figure out what heroku is vs github."),
                array("assignment 2", "link 2", "none")
            );
            echo "<table><tr><th>Assignment Name</th><th>Link to assignment</th><th>Comments</th></tr>";
            foreach($assignments as $assignment)
            {
                echo "<tr><td>".$assignment[0]."</td>";
                echo "<td>".$assignment[1]."</td>";
                echo "<td>".$assignment[2]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
        </div>
    </body>
</html>

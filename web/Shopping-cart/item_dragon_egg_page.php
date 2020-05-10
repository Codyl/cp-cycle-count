
<html>
    <head>
            <meta charset="utf-8" />
            <meta name="description" content="Web assignment">
            <meta name="keywords" content="HTML">
            <meta name="author" content="Cody Lillywhite">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="browse_style.css">
            <title>CHL CS341 shoppingCart assignment</title>
    </head>
    <body>
        <?php include('nav.php');?>
        <h2>Dragon egg</h2>
        <img class="item_page_image" alt="item" src="item_dragon_egg.jpg">
        <br>
        <i class="star"></i>
        
        <form method="post" action="browse.php">
            <label>Cost: $</label><i name="cost">9.99</i>
            <label>Quantity</label>
            <select id="cars" name="quantity">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <input type="submit" value="order">
        </form>
        <div>
            <h4>Comments</h4>
            <input type="text" class="comment">
            <div>Comments</div>
        </div>
    </body>
    
<?php 
session_start();
    $_SESSION["cost"] = 9.99;
    $_SESSION["item"] = "DragonEgg";
    $_SESSION["image"] = "item_dragon_egg.jpg";
?>
</html>
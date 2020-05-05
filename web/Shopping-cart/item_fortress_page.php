
<html>
    <head>
            <meta charset="utf-8" />
            <meta name="description" content="Web assignment">
            <meta name="keywords" content="HTML">
            <meta name="author" content="Cody Lillywhite">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="browse_style.css">
            <script src="script.js"></script>
            <title>CHL CS341 shoppingCart assignment</title>
            <script src="https://kit.fontawesome.com/yourcode.js"></script>
            <link rel = "icon" href = "https://fontawesome.com/icons/laptop-code?style=solid" type = "image/x-icon">
    </head>
    <body>
        <h2>Fortress</h2>
        <img class="item_page_image" alt="item" src="item_dnd_fortress.jpg">
        <br>
        <i class="star"></i>
        
        <form method="post" action="browse.php">
            <label>Cost: $</label><i name="cost">6.34</i>
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
    $_SESSION["cost"] = 6.34;
    $_SESSION["item"] = "Fortress";
    $_SESSION["image"] = "item_dnd_fortress.jpg";
?>
</html>
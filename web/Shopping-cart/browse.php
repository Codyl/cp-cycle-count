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
            <link rel="stylesheet" href="browse_style.css">
            <title>DN browse</title>
    </head>
    <body>
        <!-- Notifies the user when an item has been added to their cart. -->
        <?php 
            session_start();
            if(!empty($_POST["quantity"])){
                $totalCost = $_POST["quantity"] * $_SESSION["cost"];
                $cart = fopen("cart.txt", "a");
                if(!(empty(file_get_contents("cart.txt"))))
                {
                    $itemLine = "\n".$_SESSION["item"] . " " . $_POST["quantity"] . " " . $_SESSION["cost"] . " " . $_SESSION["image"];
                }
                else
                {
                    $itemLine = $_SESSION["item"] . " " . $_POST["quantity"] . " " . $_SESSION["cost"] . " " . $_SESSION["image"];
                }
                fwrite($cart, $itemLine);
                //echo "<script type='text/javascript'>alert('Added item to cart!');</script>";
            }
            $_SESSION["nav"] = "nav.php";
        ?>
        <?php include('nav.php');?>
        
        <div id="items_list">
            <h3>Arts & Crafts</h3>
            <h4>Paintings</h4>
            <hr>
            <div class="item">
                <div class="rank_index"></div>
                <a class="a-link-normal" href="item_fortress_page.php">
                    <div class="a-section a-spacing-mini">
                        <img class="item_image" alt="item" src="item_dnd_fortress.jpg">
                    </div>
                    <div class="item_title" aria-hidden="true" data-rows="5">Fortress</div>
                </a>
                    
                <div class="a-icon-row a-spacing-none">
                    <a class="a-link-normal" title="4.8 out of 5 stars" href="">
                        <i class="star"><span class="a-icon-alt">X out of 5 stars</span></i>
                    </a>
                    <a class="a-size-small a-link-normal" href="">0</a>
                </div>
            </div>
            <div class="item">
                <div class="rank_index"></div>
                <a class="a-link-normal" href="">
                    <div class="a-section a-spacing-mini">
                        <img class="item_image" alt="item" src="item_dragon_egg.jpg">
                    </div>
                    <div class="item_title" aria-hidden="true" data-rows="5">Item name</div>
                </a>
                    
                <div class="a-icon-row a-spacing-none">
                    <a class="a-link-normal" title="4.8 out of 5 stars" href="">
                        <i class="star"><span class="a-icon-alt">X out of 5 stars</span></i>
                    </a>
                    <a class="a-size-small a-link-normal" href="">0</a>
                </div>
            </div>
            <div class="item">
                <div class="rank_index"></div>
                <a class="a-link-normal" href="">
                    <div class="a-section a-spacing-mini">
                        <img class="item_image" alt="item" src="item_dragon_family.jpg">
                    </div>
                    <div class="item_title" aria-hidden="true" data-rows="5">Item name</div>
                </a>
                    
                <div class="a-icon-row a-spacing-none">
                    <a class="a-link-normal" title="4.8 out of 5 stars" href="">
                        <i class="star"><span class="a-icon-alt">X out of 5 stars</span></i>
                    </a>
                    <a class="a-size-small a-link-normal" href="">0</a>
                </div>
            </div>
            <hr>
        </div>
    </body>
</html>
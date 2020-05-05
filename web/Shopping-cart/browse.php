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
            <script src="script.js"></script>
            <title>CHL CS341 shoppingCart assignment</title>
            <script src="https://kit.fontawesome.com/yourcode.js"></script>
            <link rel = "icon" href = "https://fontawesome.com/icons/laptop-code?style=solid" type = "image/x-icon">
    </head>
    <body>
        <div class="title">
            <h6>Welcome to the</h6>
            <h1>Dragons Nest</h1>
            <h5 id="store_type">Arts and Crafts store</h5>
        </div>
        <div class="nav">
            <form>
                <div class="button">About us</div>
                <div class="button">Contact us</div>
                <div class="button">Donate</div>
                <a href="view-cart.php"><div class="button">View cart</div></a>
            </form>
        </div>
        <?php 
            if(isset($_POST["submit"])){
            $quantity = $_POST["quantity"];
            $cost = $_POST["cost"];
            $totalCost = $quantity * $cost;
            $total = $totalCost;
            $note = "Added ".$_SERVER["item"]." to cart!";
            alert($note);
            }
        ?>
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
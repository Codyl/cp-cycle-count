<div class="title">
    <h6>Welcome to the</h6>
    <h1>Dragons Nest</h1>
    <h5 id="store_type">Arts and Crafts store</h5>
</div>
<div class="nav">
    <nav>
        <a href="browse.php"><div class="button">Browse Store</div></a>
        <div class="button">About us</div>
        <div class="button">Contact us</div>
        <div class="button">Donate</div>
        <a href="view-cart.php"><div class="button">
            <?php 
            $_SESSION["cartSize"] = count(file("cart.txt"));
            //session_start(); 
            if($_SESSION["cartSize"] != 0)
            {echo "View Cart(".$_SESSION["cartSize"].")";}
            else
            {echo "View Cart";}
            
            
            ?>
        </div></a>
    </nav>
</div>
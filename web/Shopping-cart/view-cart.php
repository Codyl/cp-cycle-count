<html>
    <head>
            <meta charset="utf-8" />
            <meta name="description" content="Web assignment">
            <meta name="keywords" content="HTML">
            <meta name="author" content="Cody Lillywhite">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="browse_style.css">
            <title>DN Shopping Cart</title>
            <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <?php include("nav.php");?><br><br>
        <table>
            <tr>
                <th>Index</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Total</th>
                <th>Image</th>
                <th></th>
            </tr>
            <!-- For each line in the txt separate out the data and display it with a delete option -->
            <?php
                $file = fopen("cart.txt","r");
                $lineIndex = 0;
                if(!empty($_SESSION["trim"]))
                    {
                        file_put_contents("cart.txt", $trimmed);
                    }
                    echo "<form>";
                while(! feof($file))
                {
                    $line = fgets($file);
                    $lineOriginal = $line;
                    //parse the data
                    $lineIndex++;
                    $itemName = strtok($line,  ' ');
                    $line = str_replace($itemName, "", $line);
                    $quantity = strtok($line,  ' ');
                    $line = str_replace($quantity, "", $line);
                    $cost = strtok($line,  ' ');
                    $line = str_replace($cost, "", $line);
                    $total = $cost * $quantity;
                    $image = strtok($line,  ' ');
                    
                    echo "<tr>\n\t<td>".$lineIndex."</td>\n\t<td>".$itemName."</td>\n";
                    echo "\t<td>".$quantity."</td>\n";
                    echo "\t<td>".$cost."</td>\n";
                    echo "\t<td>".$total."</td>\n";
                    echo "\t<td>".$image."</td>\n";
                    //removal button
                    echo "\t<td><input type='button' value='Remove from cart' onclick=remove($lineIndex)>";
                    echo "</td>\n</tr>\n";
                }
                echo "</form>";
                fclose($file);
            ?>
        </table>
        <form method="post" action="checkout.php">
            <input type="submit" value="checkout">
        </form>
        

        
    </body>
</html>
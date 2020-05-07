<html>
    <head>
            <meta charset="utf-8" />
            <meta name="description" content="Web assignment">
            <meta name="keywords" content="HTML">
            <meta name="author" content="Cody Lillywhite">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="browse_style.css">
            <title>DN Shopping Cart</title>
    </head>
    <body>
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
                
                while(! feof($file))
                {
                    $lineIndex++;

                    $line = fgets($file);
                    $lineOriginal = $line;
                    $itemName = strtok($line,  ' ');
                    $line = str_replace($itemName, "", $line);
                    $quantity = strtok($line,  ' ');
                    $line = str_replace($quantity, "", $line);
                    $cost = strtok($line,  ' ');
                    $line = str_replace($cost, "", $line);
                    $total = 0;
                    $image = strtok($line,  ' ');
                    $trimmed = str_replace($line, "", file_get_contents("cart.txt"));
                    echo "<tr>\n\t<td>".$lineIndex."</td>\n\t<td>".$itemName."</td>\n";
                    echo "\t<td>".$quantity."</td>\n";
                    echo "\t<td>".$cost."</td>\n";
                    echo "\t<td>".$total."</td>\n";
                    echo "\t<td>".$image."</td>\n";
                    echo "\t<td><input type='button' value='Remove from cart' onclick='file_put_contents('cart.txt',".$trimmed.")'></td>\n</tr>\n";
                }
                fclose($file);
            ?>
        </table>
        <form method="post" action="checkout.php">
            <input type="submit" value="checkout">
        </form>
        

        <script type="text/javascript" src="script.js"></script>
    </body>
</html>
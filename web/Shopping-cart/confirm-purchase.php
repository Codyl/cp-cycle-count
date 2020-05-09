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
        <title>Dragons Nest checkout</title>>
    </head>
    <body>
        <?php session_start(); include("nav.php");?><br>
        <h2>Confirmed Purchase</h2>
        <h5>Thank you for your purchase <?php echo htmlspecialchars($_POST["name"])?>!</h5>
        <p>You purchased: </p>
        <table>
            <tr>
                <th>Index</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Total</th>
                <th>Image</th>
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
                    $total = $cost * $quantity;
                    $image = strtok($line,  ' ');
                    $trimmed = str_replace($line, "", file_get_contents("cart.txt"));
                    echo "<tr>\n\t<td>".$lineIndex."</td>\n\t<td>".$itemName."</td>\n";
                    echo "\t<td>".$quantity."</td>\n";
                    echo "\t<td>".$cost."</td>\n";
                    echo "\t<td>".$total."</td>\n";
                    echo "\t<td>".$image."</td>\n";
                    echo "</tr>\n";
                }
                fclose($file);
                echo "Your package(s) will arrive at ".htmlspecialchars($_POST["address"])." within 3 days!";
                file_put_contents("cart.txt", "");
            ?>
        </table>
        <input type="submit" value="print confirmation">
        <h5>Related Items</h5>
    </body>
</html>
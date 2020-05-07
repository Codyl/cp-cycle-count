<html>
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="Web assignment">
        <meta name="keywords" content="HTML">
        <meta name="author" content="Cody Lillywhite">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="browse_style.css">
        <title>Dragons Nest checkout</title>
    </head>
    <body>
        <form method="post" action="confirm-purchase.php" name="orderForm" onsubmit="return validateForm()">
            <label class="formLabel" for="name">Name: <input type="text" name="name" required></label><br>
            <label class="formLabel" for="phone">Phone: <input type="text" name="phone"></label><br>
            <label class="formLabel" for="email">Email: <input type="text" name="email"></label><br>
            <label class="formLabel" for="address">Address: <input type="text" name="address" required></label><br>
            <input type="submit" value="Finalize purchase">
        </form>
        <script src="script.js" type="text/javascript"></script>
    </body>
</html>
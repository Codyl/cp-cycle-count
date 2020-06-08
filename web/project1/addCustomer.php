<?php

  session_start();
  if ( ! isset($_SESSION["user_id"])) {
    header("Location: /project1/?action=sign-in");
    die();
  }
?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once "model.php";
    if(!empty($_POST)) {
        addCustomer();
    }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add customer</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <nav>
        <img src="logo.svg" alt="C&P Logo" id="logo">
        <a href="sign-in.php"><div class="right buttonBox">Sign out</div></a>
        <a href="edit.php"><div class="right buttonBox">Edit database</div></a>
        <a href="editOrders.php"><div class="right buttonBox">Edit orders</div></a>
        <a onclick='alert("Increasing orders: will decrease qty available. Increasing items will add more to the count list. Items with the oldest count display last in the table. Bins should not display more than once. A bin is where an item is located in the warehouse.")'><div class="right buttonBox" style='padding-left:10px;padding-right:10px'>?</div></a>
    </nav>
    <h1>Add Customer</h1>
    <form action="#" method="post">
        <label for="name">Name: <input type="text" name="name" id="name" require></label><br>
        <label for="">Email: <input type="email" name="email" id="email" require></label><br>
        <label for="phone">Phone: <input type="tel" name="phone" id="phone"></label><br>
        <label for="company">Company: <input type="text" name="company" id="company" require></label><br>
        <label for="str_address">street address: <input type="text" name="str_address" id="str_address" require></label><br>
        <label for="country">Country: <input type="text" name="country" id="country" require></label><br>
        <label for="state">State: <input type="text" name="state" id="state" require></label><br>
        <label for="zip">Zip: <input type="text" name="zip" id="zip" require></label><br>
        <label for="city">City: <input type="text" name="city" id="city" require></label><br>
        <input type="submit" value="Add customer">
    </form>
</body>
</html>
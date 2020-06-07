<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>C&P Sign-in Page</h1>
    <?php
        if(isset($message)) {
            echo $message;
        }
    ?>
    <form action="/cs313-php/web/project1/?action=authenticate" method="post">
        <label for="username">Username: 
            <input type="text" name="username" id="username">
        </label><br>
        <label for="password">Password: 
            <input type="password" name="password" id="password">
        </label><br>
        <input type="submit" value="Sign in">
    </form>
</body>
</html>
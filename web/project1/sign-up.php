<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function verifyMatch() {
      if (document.register.password.value === document.register.password2.value &&
          document.register.password.value.match(/(?=.*\d).{7,}/) &&
          document.register.password2.value.match(/(?=.*\d).{7,}/)) {
        document.getElementById("submit").removeAttribute("disabled");
      } else {
        document.getElementById("submit").setAttribute("disabled", true);
      }
    }
  </script>
</head>
<body>

  <header></header>

  <h1>Sign Up</h1>

  <?php
    if (isset($message)) {
      echo $message;
    }
  ?>

  <form name="register" action="/cs313-php/web/project1/?action=register" method="post">
    <label for="username">Username
      <input type="text" name="username" id="username" required autofocus>
    </label>
    <br>

    <label for="password">Enter Password
      <input type="password" name="password" id="password" 
          pattern="(?=.*\d).{7,}" required oninput="verifyMatch()">
      <?php
        if (isset($passwordAlert)) {
          echo " <span style='color: red'> * </span> ";
        }
      ?>
    </label>
    <span>Password must contain at least 7 characters, including at least 1 number.</span>
    <br>

    <label for="password2">Re-enter Password
      <input type="password" name="password2" id="password2" 
          pattern="(?=.*\d).{7,}" required oninput="verifyMatch()">
      <?php
        if (isset($passwordAlert)) {
          echo " <span style='color: red'>*</span>";
        }
      ?>
    </label>
    <br>
    <label for="warehouse">Please choose which warehouse you work at: 
    <select name="warehouse" id="warehouse">
      <option value=""></option>
      <?php
          require_once "../dbAccess.php";
          $db = connectDB();
          $q = $db->query("SELECT name FROM warehouses");
          $warehouses = $q->fetchAll();
          for($i = 0; $i < sizeof($warehouses);$i++) {
              echo "<option value='{$i}'>{$warehouses[$i]['name']}</option>";
          }
      ?>
    </select>
    </label>
    <br>

    <input type="submit" id="submit" value="Sign Up" disabled>
  </form>
  
</body>
</html>

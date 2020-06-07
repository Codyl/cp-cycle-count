<?php
require_once "../dbAccess.php";
require_once "model.php";
    $action = filter_input(INPUT_POST, "action");
    if ($action == NULL) {
        $action = filter_input(INPUT_GET, "action");
      }
      echo $action;
    switch($action) {
        case "sign-in":
            include "sign-in.php";
            break;
        
        case "authenticate":            $filters = [
                "username" => ["filter" => FILTER_SANITIZE_STRING],
                "password" => ["filter" => FILTER_SANITIZE_STRING]
              ];
              $credentials = filter_input_array(INPUT_POST, $filters);
          
              if (authenticateUser($credentials)) {
                include "countPage.php";
              } else {
                $message = "<p class='err'>The credentials you entered do not match our records.<p>";
                include "sign-in.php";
              }
              break;
              
        case "sign-up":
            include "sign-up.php";
            break;

        case "register":
            $filters = [
                "username" => ["filter" => FILTER_SANITIZE_STRING],
                "password" => ["filter" => FILTER_SANITIZE_STRING],
                "password2" => ["filter" => FILTER_SANITIZE_STRING],
                "warehouse" => ["filter" => FILTER_SANITIZE_STRING]
            ];
            $credentials = filter_input_array(INPUT_POST, $filters);
        
            if (empty($credentials["username"]) || empty($credentials["password"]) ||
                empty($credentials["password2"])) {
                // IF any empty fields
                $message = "<p class='err'>Please complete all fields.<p>";
                $passwordAlert = true;
                include "sign-up.php";
                
            } else if ($credentials["password"] !== $credentials["password2"]) {
                // IF both passwords don't match
                $message = "<p class='err'>The passwords you entered did not match.
                                Please try again.<p>";
                $passwordAlert = true;
                include "sign-up.php";
        
            } else if ( ! preg_match("/(?=.*\d).{7,}/", $credentials["password"])) {
                // IF passwords don't meet minimum complexity criteria
                $message = "<p class='err'>The passwords must be at least 7 characters and contain a number.
                                Please try again.<p>";
                $passwordAlert = true;
                include "sign-up.php";
        
            } else if (registerUser($credentials)) {
                // IF registerUser() succeeds
                $message = "<p class='success'>You have been registered!  You may now sign in.</p>";
                include "sign-in.php";
        
            } else {
                $message = "<p class='err'>There was a problem with your registration.
                                Please try again.<p>";
                include "sign-up.php";
            }
            break;

        case "countPage":
            include "countPage.php";
            break;
        
            /*
            * sign-out
            */
            case "sign-out":
            session_start();
            unset($_SESSION["id"]);
            include "sign-in.php";
            break;
        
            /*
            * landing
            */
            default:
            include "sign-in.php";
    }

?>

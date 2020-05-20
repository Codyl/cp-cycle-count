<?php
    function connectDB()
    {
        try
        {
          $dbUrl = getenv('DATABASE_URL');
          echo "env: ".getenv('DATABASE_URL');
          $dbOpts = parse_url($dbUrl);
        
          $dbHost = $dbOpts["host"];
          $dbPort = $dbOpts["port"];
          $dbUser = $dbOpts["user"];
          $dbPassword = $dbOpts["pass"];
          $dbName = ltrim($dbOpts["path"],'/');
        
          $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
        
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if(is_object($db)){
                echo "connected to DB";    
            }

          return $db;

        }
        catch (PDOException $ex)
        {
          echo 'Error!: ' . $ex->getMessage();
          die();
        }  
    }
    //connectDB();
?>
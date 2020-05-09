<?php
    //echo "it worked!".$_GET["line"];
    //file_put_contents("cartTemp.txt","");
    $file = fopen("cartTemp.txt","w");
    $file2 = fopen("cart.txt", "r");
    $lineIndex = 0;
    $target= $_GET["line"];
    while(!feof($file))
    {
        $line = fgets($file);
        $lineIndex++;
       
            fwrite($file2,$line);
        
    }
    fclose($file);
    fclose($file2);
    file_put_contents("cart.txt",file_get_contents("cartTemp.txt","r"));
    
    //echo file_get_contents("cart.txt");
?>
<?php
error_reporting(0);
    if(isset($_POST["barcode"]))
    {
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            die();
        }
        
        $mysqli = new mysqli('localhost','aossmed','XXXXXXXXX','barcodes');
        if ($mysqli->connect_error){
            die('Could not connect to database!');
        }
        
        
        $barcode = filter_var($_POST["barcode"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
        
        $infoArray = explode(",",$barcode);
        
        $itemNum = $infoArray[0];
        
        $lotNum = $infoArray[1];
        
        $expDate = $infoArray[2];
        
        $batchNum = $infoArray[3];
        
        $statement = $mysqli->prepare("INSERT INTO barcodetable VALUES (?, ?, ?, ?, ?)");
        
        $statement->bind_param('sssss',$barcode,$itemNum,$lotNum,$expDate,$batchNum);
         
        $success = $statement->execute();
        
        
        
        if($success) 
        {
            
            echo '<script>';
            echo 'printLabelSuccess()';
            echo '</script>';
        }
        else
        {
            echo '<script>';
            echo 'printLabelFail()';
            echo '</script>';
        }
        
        
    }
?>
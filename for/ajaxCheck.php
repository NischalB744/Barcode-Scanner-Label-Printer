<?php

    if(isset($_POST["barcode"]))
    {
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
        {
            
            die();
        
        }
        
        $mysqli = new mysqli('127.0.0.1','root','','scannertest');
        
        if ($mysqli->connect_error)
        {
            
            die('Could not connect to database!');
        
        }
        
        $barcode = filter_var($_POST["barcode"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
        
        $statement = $mysqli->prepare("SELECT itemno,lotno,expdate,batchno FROM aossitem WHERE barcode=?");
        
        $statement->bind_param('s', $barcode);
         
        $statement->execute();
         
        $statement->bind_result($itemno,$lotno,$expdate,$batchno);
        
        while ($statement->fetch())
        {
        
            echo '<script>';
        
            echo 'var itemno = '.json_encode($itemno) . ';';
            
            echo 'var lotno = '.json_encode($lotno) . ';';
            
            echo 'var expdate = '.json_encode($expdate) . ';';
            
            if($batchno != '')
            {
            
                echo 'var batchno = '.json_encode($batchno) . ';';
            
            }
            
            else 
            {
                
                echo 'var batchno = '.json_encode('').';';
            
            }
            
            echo 'printLabel()';
            
            echo '</script>';
            
        }   
    }

?>
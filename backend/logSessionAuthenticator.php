<?php
    include 'dbManager.php';
    $sql = "SELECT `uid` FROM `log` WHERE `logSession` LIKE '{$_POST['logSession']}' AND `uid` LIKE '{$_POST['uid']}';";  
    $result = mysqli_query($conn,$sql);
    if ($result->num_rows > 0){
        echo 'true';    
    }else{
        echo 'false';
    }
?>
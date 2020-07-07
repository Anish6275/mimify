<?php
    include 'dbManager.php';
    $sql = "SELECT `uid` FROM `user` WHERE `code` LIKE '" . $_POST['id'] . "';";  
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0){
        echo 'true';
    }else{
        echo 'false';
    }
    mysqli_close($conn);
?>
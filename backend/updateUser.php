<?php
    include 'dbManager.php';
    $sql="UPDATE `user` SET `name` = '{$_POST['name']}', `status` = '{$_POST['status']}' WHERE `uid` LIKE '{$_POST['uid']}';";
    if(mysqli_query($conn, $sql)){
        $sql="INSERT INTO `notification` (`slno`, `whome`, `where`, `what`, `when`) VALUES (NULL, '{$_POST['uid']}', '{$_POST['uid']}', 'Updated Profile', NOW());";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }else{
        mysqli_close($conn);    
    }
    
?>
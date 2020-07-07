<?php
    include 'dbManager.php';
    $sql = "DELETE FROM `post` WHERE `id` LIKE '{$_POST['id']}';";
    if(mysqli_query($conn, $sql)){
        $sql="INSERT INTO `notification` (`slno`, `whome`, `where`, `what`, `when`) VALUES (NULL, '{$_POST['uid']}', '{$_POST['uid']}', 'Deleted a Post!!', NOW());";
        mysqli_query($conn, $sql);
    }
    echo $post;
?>
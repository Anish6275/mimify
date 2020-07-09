<?php
    include 'dbManager.php';
    $sql = "UPDATE `post` SET `save` = concat(`save`, '{$_POST['uid']},') WHERE `id` LIKE '{$_POST['id']}'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
?>
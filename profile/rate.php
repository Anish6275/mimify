<?php
    include 'dbManager.php';
    $sql = "UPDATE `post` SET `rate`= `rate` + {$_POST['n']} , `rateid` = concat(`rateid`, '{$_POST['uid']},') WHERE `id` LIKE '{$_POST['id']}'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
?>
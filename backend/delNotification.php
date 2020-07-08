<?php
    include 'dbManager.php';
    $sql = "DELETE FROM `notification` WHERE `slno`='{$_POST['id']}';";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
?>
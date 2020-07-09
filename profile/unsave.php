<?php
    include 'dbManager.php';
    $sql = "SELECT `save` FROM `post` WHERE `id` LIKE '{$_POST['id']}' LIMIT 1;";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $update = str_replace($_POST['uid'].',', '', $row['save']);
        $sql = "UPDATE `post` SET `save` = '{$update}' WHERE `id` LIKE '{$_POST['id']}'";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
?>
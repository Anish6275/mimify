<?php
    include 'dbManager.php';
    $post = "";
    $sql = "SELECT `id`, `link` FROM `post` WHERE `uid` LIKE '{$_POST['uid']}' ORDER BY `id` DESC;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    while($res = mysqli_fetch_array($result)){
        $post .= "<div class='imgbtn' id='div{$res[0]}'><img src='{$res[1]}' onclick='show({$res[0]})' /><button class='btn but{$res[0]}' onclick='deletePost({$res[0]})'>delete</button></div>";          
    }
    echo $post;
?>
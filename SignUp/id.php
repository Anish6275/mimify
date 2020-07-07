<?php
    include 'dbManager.php';
	$sql = "SELECT `uid` FROM `user` WHERE `uid` LIKE '{$_POST['uid']}%' LIMIT 1;";
    $result = mysqli_query($conn, $sql);
    
    while($res = mysqli_fetch_array($result)){
        echo $res[0];
        echo '|';
    }
?>
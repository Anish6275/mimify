<?php
    include 'dbManager.php';
    $p = password_hash($_POST["pass"], PASSWORD_BCRYPT);
    $sql = "UPDATE `log` SET `pass` = '{$p}' WHERE `gid` LIKE '{$_POST['id']}';";
    if((mysqli_query($conn, $sql))){
        $sql = "UPDATE `user` SET `pass` = '{$_POST['pass']}' WHERE `code` LIKE '{$_POST['id']}';";
        if((mysqli_query($conn, $sql))){
            $sql = "SELECT `uid` FROM `user` WHERE `code` LIKE '" . $_POST['id'] . "'";
            $result = mysqli_query($conn,$sql);
            if ($result->num_rows > 0){
				$row = $result->fetch_assoc();
                $sql = "INSERT INTO `notification` (`slno`, `whome`, `where`, `what`, `when`) VALUES (NULL, '{$row['uid']}', '{$row['uid']}', 'Changed Password!', NOW());";
                mysqli_query($conn, $sql);
                mysqli_close("$conn");
            }
            mysqli_close("$conn");
            echo 'true';
        }else{
            mysqli_close("$conn");
            echo 'false';
        }
    }else{
        echo 'false';
    }
    mysqli_close("$conn");
?>
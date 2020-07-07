<?php
    include 'dbManager.php';
    $sql = "UPDATE `post` SET `likes`= `likes` + 1 , `likeid` = concat(`likeid`, '{$_POST['uid']},') WHERE `id` LIKE '{$_POST['id']}'";
    if(mysqli_query($conn, $sql)){
        $sql = "SELECT `uid` FROM `post` WHERE `id` LIKE '{$_POST['id']}' LIMIT 1;";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $sql = "SELECT `slno` FROM notification WHERE `whome` = '{$row['uid']}' AND `where` = '{$_POST['uid']}' AND
            `what`= '".'Liked your <a style=\"color: #039be5;\"href=\"profile.php#a'. $_POST['id'] .'\">this</a> post!'. "' 
            LIMIT 1;";
            
        	$result = mysqli_query($conn,$sql);
            if (!($result->num_rows > 0)){
    		    $sql = 'INSERT INTO `notification` (`slno`, `whome`, `where`, `what`, `when`) VALUES (NULL, "'.$row['uid'].'", "'.$_POST['uid'].'", "Liked your <a style=\"color: #039be5;\"href=\"profile.php#a'. $_POST['id'] .'\">this</a> post!", NOW());';
                mysqli_query($conn, $sql);
            }
        }
    }
    mysqli_close($conn);
?>
<?php    
    include 'dbManager.php';
    $sql = "SELECT `subsid` FROM `follow` WHERE `uid` LIKE '{$_POST['uid']}' AND `subsid` LIKE '%{$_POST['id']}%'LIMIT 1;";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0){
	    $row = $result->fetch_assoc();
	    //$update = chop($row['subsid'],$_POST['id'].',');
	    $chop = $_POST['id'] . ",";
	    $update = str_replace($chop,"",$row['subsid']);
		$sql = "UPDATE `follow` SET `subsid`= '{$update}'  WHERE `uid` LIKE '{$_POST['uid']}';";
    	if(mysqli_query($conn, $sql)){
    	    echo "FOLLOW";
    	    mysqli_close($conn);
    	}
	}else{
    	$sql = "UPDATE `follow` SET `subsid`= concat(`subsid`,'{$_POST['id']},') WHERE `uid` LIKE '{$_POST['uid']}'";
    	if(mysqli_query($conn, $sql)){
    	    echo "FOLLOWED";
    	    $sql = "SELECT `slno` FROM notification WHERE `whome` = '{$_POST['id']}' AND `where` = '{$_POST['uid']}' AND `what`='Started following You!!' LIMIT 1;";
    	     $result = mysqli_query($conn,$sql);
             if (!($result->num_rows > 0)){
                 $sql = "INSERT INTO `notification` (`slno`, `whome`, `where`, `what`, `when`) VALUES (NULL, '{$_POST['id']}', '{$_POST['uid']}', 'Started following You!!', NOW());";
    	         mysqli_query($conn, $sql);
             }
    	    mysqli_close($conn);
    	}
	}
?>
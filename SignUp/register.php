<?php 
    
    include 'dbManager.php';

    $sql = "SELECT `email` FROM `user` WHERE `email` LIKE '{$_POST['gmail']}' ;";  
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows <= 0){		
        $nm = ($_POST['name'] == '')? $_POST['Gname'] : $_POST['name'];		   		
		$sql = "INSERT INTO `user` (`slno`, `uid`, `pass`, `name`, `image`, `dob`, `pno`, `email`, `status`, `code`)";
		$sql = $sql . "VALUES (NULL, '{$_POST['uid']}', '{$_POST['pass']}', '{$nm}', '{$_POST['image']}','{$_POST['dob']}'";
		$sql = $sql . ", '{$_POST['phone']}', '{$_POST['gmail']}', ' ', '{$_POST['Gid']}');";  
        $p = password_hash($_POST["pass"], PASSWORD_BCRYPT);
        $sqll = "INSERT INTO `log` (`uid`, `pass`, `gid`, `logSession`) VALUES ('{$_POST['uid']}', '{$p}', '{$_POST['Gid']}', NULL);";
        $sqlll = "INSERT INTO `follow` (`uid`, `subsid`, `cpost`) VALUES ('{$_POST['uid']}', 'mimify,', '0');";
        if((mysqli_query($conn, $sql)) && (mysqli_query($conn, $sqll)) && (mysqli_query($conn, $sqlll))){
            $sql = "INSERT INTO `notification` (`slno`, `whome`, `where`, `what`, `when`) VALUES (NULL, '{$_POST['uid']}', 'mimify', 'Welcome to mimify!!', NOW());";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            $message = "Account Successfully Created!";
            echo '<script language="javascript">';
            echo 'alert("'.$message.'");';
            echo "window.location='https://mimify.ml/Login';";
            echo '</script>'; 
	    }else{
            mysqli_close($conn);
            $message = $sql;//"Some Error occured, Please try again later!";
            echo '<script language="javascript">';
            echo 'alert("'.$message.'");';
            echo "window.location='https://mimify.ml/SignUp/';";
            echo '</script>'; 
        }
    }else{
        mysqli_close($conn);
        $message = "This Gmail is already registered, Try with another Gmail!";
        echo '<script language="javascript">';
        echo 'alert("'.$message.'");';
        echo "window.location='https://mimify.ml/SignUp/';";
        echo '</script>'; 
    }
    mysqli_close($conn);
    
// $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-=_+~abcdefghijklmnopqrstuvwxyz124567890'; 
// $verificationCode = substr(str_shuffle($str_result), 0, 55);
?>
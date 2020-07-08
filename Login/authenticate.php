<?php  
    session_start();
    if(isset($_SESSION["admin_name"])){
        header("location:https://mimify.ml/index.php");
    }

    include 'dbManager.php';

    if(!empty($_POST["member_name"]) && !empty($_POST["member_password"])){        
        $name = $_POST["member_name"];//mysqli_real_escape_string($connect, $_POST["member_name"]);
        $password = $_POST["member_password"];//md5(mysqli_real_escape_string($connect, $_POST["member_password"]));
        $sql = "SELECT `uid`, `pass` FROM `log` WHERE `uid` LIKE '" . $name . "'";  
        $result = mysqli_query($conn,$sql);
        if ($result->num_rows > 0)
				$row = $result->fetch_assoc();
        if($name === $row['uid'] && password_verify($password, $row['pass'])){
            $log = uniqid();
            $sql = "UPDATE `log` SET `logsession` = '{$log}' WHERE `uid` LIKE '{$row['uid']}'";  
            if(mysqli_query($conn,$sql)){
                if(!empty($_POST["remember"])){  
                    setcookie ("member_login",$name,time()+ (10 * 365 * 24 * 60 * 60));  
                    setcookie ("member_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
                    $_SESSION["user"] = $row['uid'];
                    $_SESSION["logsession"] = $log;
                }else{  
                    $_SESSION["user"] = $row['uid'];
                    $_SESSION["logsession"] = $log;
                    if(isset($_COOKIE["member_login"])){ 
                        setcookie ("member_login","");  
                    }  
                    if(isset($_COOKIE["member_password"])){
                        setcookie ("member_password","");  
                    }  
                }
            }
            mysqli_close($conn);
            header("location: https://mimify.ml/index.php"); 
        }else{  
            $message = "Invalid Login";
            echo '<script language="javascript">';
            echo 'alert("'.$message.'");';
            echo 'window.location="https://mimify.ml/Login/index.php";';
            echo '</script>';  
        } 
    }else{
        $message = "Both are Required Fields";
        echo '<script language="javascript">';
        echo 'alert("'.$message.'");';
        echo 'window.location="https://mimify.ml/Login/index.php";';
        echo '</script>';
    }
    mysqli_close($conn);
    /*LOGOUT
    <?php
    session_start();
    unset($_SESSION["user"]);
    header("location:index.php");
    ?>*/
 ?>



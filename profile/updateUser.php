<?php
    if ($_FILES['file']['size'] != 0 && $_FILES['file']['error'] == 0){
        
       if(isset($_POST['submit'])){    
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileLocation = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        
        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 500000){
                    $uniq = uniqid();
                    $ftp_server = "files.000webhost.com";
                    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                    $login = ftp_login($ftp_conn, 'post-handler', 'Anish6275');
                    $serverSource = "public_html/profile/".$uniq.'.'.$fileActualExt;
                    $cdnSource = "https://post-handler.000webhostapp.com/profile/".$uniq.'.'.$fileActualExt;
                    $pastImg = $_POST['pastImg'];
                    $dFile = "";
                    $c = 0;
                    for($i = 0 ; $i < strlen($pastImg) ; $i++){
                        if(substr($pastImg , $i , 1) == "/"){
                            $c++;
                        }
                        if($c >= 4){
                            $dFile .= substr($pastImg , $i , 1);
                        }
                    }
                    $dFile = ltrim($dFile,'/');
                    
                    ftp_delete($ftp_conn, "public_html/profile/" . $dFile); 
                    
                    if (ftp_put($ftp_conn, $serverSource, $fileLocation, FTP_BINARY)){
                        include 'dbManager.php';
                        $sql="UPDATE `user` SET `image` = '{$cdnSource}', `status` = '{$_POST['status']}' WHERE `uid` LIKE '{$_POST['uid']}';";
                        if(mysqli_query($conn, $sql)){
                            $sql="UPDATE `post` SET `image` = '{$cdnSource}' WHERE `uid` LIKE '{$_POST['uid']}';";
                            if(mysqli_query($conn, $sql)){
                                $sql = "INSERT INTO `notification` (`slno`, `whome`, `where`, `what`, `when`) VALUES (NULL, '{$_POST['uid']}', '{$_POST['uid']}', 'Updated Profile!!', NOW());";
                                mysqli_query($conn, $sql);
                                mysqli_close($conn);
                                $message = "Succesfully Updated!";
                                echo '<script language="javascript">';
                                echo 'alert("'.$message.'");';
                                echo 'window.location="http://mimify.ml/profile.php";';
                                echo '</script>';
                            }
                            mysqli_close($conn);
                        }else{
                            mysqli_close($conn);    
                        }
                        mysqli_close($conn);
                    }else{
                        $message = "Some error occured! Please try again after some time.";
                        echo '<script language="javascript">';
                        echo 'alert("'.$message.'");';
                        echo 'window.location="http://mimify.ml/profile.php";';
                        echo '</script>';
                    }
                }
            }
        }
    } 
        
        
    }else{
        include 'dbManager.php';
        $sql="UPDATE `user` SET `status` = '{$_POST['status']}' WHERE `uid` LIKE '{$_POST['uid']}';";
        if(mysqli_query($conn, $sql)){
            $sql = "INSERT INTO `notification` (`slno`, `whome`, `where`, `what`, `when`) VALUES (NULL, '{$_POST['uid']}', '{$_POST['uid']}', 'Updated Status!!', NOW());";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            $message = "Succesfully Updated!";
            echo '<script language="javascript">';
            echo 'alert("'.$message.'");';
            echo 'window.location="http://mimify.ml/profile.php";';
            echo '</script>';
        }else{
            mysqli_close($conn);  
        }
    }
?>
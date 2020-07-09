<?php
  if(isset($_POST['uploadBtn'])){    
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileLocation = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png');
    function randomDigits($length){
      $numbers = range(0,9);
      shuffle($numbers);
      for($i = 0;$i < $length;$i++)
        $digits .= $numbers[$i];
      return $digits;
  }
    if(in_array($fileActualExt, $allowed)){
      if($fileError === 0){
        if($fileSize < 500000){
          $uniq = uniqid();
          $ftp_server = "files.000webhost.com";
          $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
          // $login = ftp_login($ftp_conn, 'epiz_25371887', 'kwVGQtsrOG');
          $login = ftp_login($ftp_conn, 'post-handler', 'Anish6275');
          // $serverSource = "htdocs/ProfilePic/".$uid.'.'.$fileActualExt;
          // $cdnSource = "https://baatcheet.cf/ProfilePic/".$uid.'.'.$fileActualExt;
          $serverSource = "public_html/posts/".$uniq.'.'.$fileActualExt;
          $cdnSource = "https://post-handler.000webhostapp.com/posts/".$uniq.'.'.$fileActualExt;
          $cdn2Source = "https://mimify.ml/upload/uploads/".$uniq.'.'.$fileActualExt;
          // echo $cdnSource;
          // upload file
          if (ftp_put($ftp_conn, $serverSource, $fileLocation, FTP_BINARY))
            {
              include 'dbManager.php';
              $uid = $_POST['uid'];
              $tag = trim($_POST['tag']);
              $des = trim($_POST['des']);
              $finalTag = "";
              for($i = 0 ; $i <= strlen($tag) - 1 ; $i++){    
                if((substr($tag , $i , 1) == " ") || ($i == 0)){
                    if($i != 0){        
                        $finalTag .= substr($tag , $i , 1);
                        ++$i;
                    }
                    if(substr($tag , $i , 1) == "#"){
                        $finalTag .= substr($tag , $i , 1);            
                    }else{
                        $finalTag .= "#".substr($tag , $i , 1);
                    }
                }else{
                    $finalTag .= substr($tag , $i , 1 );
                }    
              }   
              
              $sql = "SELECT `name`, `image` FROM `user` WHERE `uid` LIKE '{$uid}' LIMIT 1;";
			  $result = mysqli_query($conn, $sql);
			  if ($result->num_rows > 0)
			   	$row = $result->fetch_assoc();
              $sql = "INSERT INTO `post` 
                            (`id`, `link`, `slink`, `uid`, `name`, `image`, `time`, `tag`, `des`, `likes`, `likeId`, `rate`, `rateId`, `save`) 
                      VALUES 
                            (NULL, '{$cdnSource}', '{$cdn2Source}', '{$uid}', '{$row['name']}' , '{$row['image']}', CURRENT_TIMESTAMP, '{$finalTag}', '{$des}', '0', '', '0', '','');";                    
              if(mysqli_query($conn, $sql)){
                mysqli_close($conn);  
                $targetDir = "uploads/"; 
                $watermarkImagePath = 'watermark.png'; 
                $statusMsg = ''; 
                    // File upload path 
                    $fileName = basename($fileName); 
                    $targetFilePath = $targetDir . $uniq . '.' .$fileActualExt; 
                    $fileType = strtolower(pathinfo($targetFilePath,PATHINFO_EXTENSION)); 
                    // Allow certain file formats 
                    $allowTypes = array('jpg','png','jpeg'); 
                    if(in_array($fileType, $allowTypes)){ 
                      // Upload file to the server 
                      if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                        // Load the stamp and the photo to apply the watermark to 
                        $watermarkImg = imagecreatefrompng($watermarkImagePath); 
                        switch($fileType){ 
                          case 'jpg': 
                            $im = imagecreatefromjpeg($targetFilePath);
                             
                          break; 
                          case 'jpeg': 
                            $im = imagecreatefromjpeg($targetFilePath); 
                            
                          break; 
                          case 'png': 
                            $im = imagecreatefrompng($targetFilePath); 
                            
                          break; 
                          default: 
                          $im = imagecreatefromjpeg($targetFilePath); 
                        }                                     
                        // Get the height/width of the watermark image 
                        $sx = imagesx($watermarkImg); 
                        $sy = imagesy($watermarkImg);                   
                        // Copy the watermark image onto our photo using the margin offsets and  
                        // the photo width to calculate the positioning of the watermark. 
                        imagecopy($im, $watermarkImg, (imagesx($im)/2) - ($sx/2) , (imagesy($im)/2) - ($sy/2) , 0, 0, imagesx($watermarkImg), imagesy($watermarkImg));                   
                        // Save image and free memory 
                        imagepng($im, $targetFilePath); 
                        imagedestroy($im);       
                        if(file_exists($targetFilePath)){ 
                          $message = "successfully uploaded!"; 
                          echo '<script language="javascript">';
                          echo 'alert("'.$message.'");';
                          echo 'window.location="https://mimify.ml/upload.php";';
                          echo '</script>';
                        }else{ 
                          $message = "Image upload failed, please try again."; 
                          echo '<script language="javascript">';
                          echo 'alert("'.$message.'");';
                          echo 'window.location="https://mimify.ml/upload.php";';
                          echo '</script>';
                        }  
                      }else{ 
                        $message = "Sorry, there was an error uploading your file."; 
                        echo '<script language="javascript">';
                        echo 'alert("'.$message.'");';
                        echo 'window.location="https://mimify.ml/upload.php";';
                        echo '</script>';
                      } 
                    }else{ 
                      $message = 'Sorry, only JPG, JPEG, and PNG files are allowed to upload.'; 
                      echo '<script language="javascript">';
                      echo 'alert("'.$message.'");';
                      echo 'window.location="https://mimify.ml/upload.php";';
                      echo '</script>';
                    }           
              }else{
                $message = "Error uploading";
                echo '<script language="javascript">';
                echo 'alert("'.$message.'");';
                echo 'window.location="https://mimify.ml/upload.php";';
                echo '</script>';
              }
              mysqli_close($conn);          
            }else{
              $message = "Error uploading";
              echo '<script language="javascript">';
              echo 'alert("'.$message.'");';
              echo 'window.location="https://mimify.ml/upload.php";';
              echo '</script>';  
            }
          // close connection
          ftp_close($ftp_conn);
        }else{
          $message = "Your file is too big";
          echo '<script language="javascript">';
          echo 'alert("'.$message.'");';
          echo 'window.location="https://mimify.ml/upload.php";';
          echo '</script>';
        }
      }else{
        $message = "There was an error uploading your file!";
        echo '<script language="javascript">';
        echo 'alert("'.$message.'");';
        echo 'window.location="https://mimify.ml/upload.php";';
        echo '</script>';
      }
    }else{
      $message = "You cannot upload files of this type!";
      echo '<script language="javascript">';
      echo 'alert("'.$message.'");';
      echo 'window.location="https://mimify.ml/upload.php";';
      echo '</script>';
    }
  }
?>
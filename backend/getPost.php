<?php
    include 'dbManager.php';
    $uid = $_POST['uid'];
    $subs = array();
	$sql = "SELECT `subsid`, `cpost` FROM `follow` WHERE `uid` LIKE '{$uid}' LIMIT 1;";
    $result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $cpo = $row['cpost'];
        $firstNo = "";
        $lastNo = "";
        $d = 0;
        if(strpos($cpo, '-') !== false){
            for($i = 0 ; $i < strlen($cpo) ; $i++){
                if($d == 0){
                    if(substr($cpo , $i , 1) == "-"){
                        $d++;
                    }else{
                        $firstNo .= substr($cpo , $i , 1);
                    }
                }else{
                    $lastNo .= substr($cpo , $i , 1);
                }
            }
        }else{
            $lastNo = $cpo;
        }
       
        
    /*
        LOGIC:-
            whenever request comes to  getPost they have to give uid then we will get the cpost from post,
            cpost will be like "12-18" that means they have seen 12-18 on last session now we have to supply 
            5 post after 18 and the last post id we need and we have to update cpost to "18-36" where 36 will
            be the last post seen.
    */        
        
        $subscriber = $row['subsid'];
        $curSubs = "";
        for ($i = 0 ; $i < strlen($subscriber) ; $i++){
            if(substr($subscriber , $i , 1) != ","){
                $curSubs .= substr($subscriber , $i , 1);
            }else{
                array_push($subs,$curSubs);
                $curSubs = "";
            }              
        }
        array_push($subs,$curSubs);
        $sql = "SELECT * , CURRENT_TIMESTAMP FROM `post` WHERE (";
        for($i = 1 ; $i <= sizeof($subs) ; $i++){
            if($i != sizeof($subs)){
                $sql .= "`uid` LIKE '{$subs[$i-1]}' OR ";
            }else{
                $sql .= "`uid` LIKE '{$subs[$i-1]}') ";
            }
        }
        $sql .= "AND `id` > '{$lastNo}' LIMIT 2;";           
        $result = mysqli_query($conn, $sql);
        $post = "";
        $finalId = 0;
        $run = false;
        while($res = mysqli_fetch_array($result)){
            $run = true;
            //----------------------------//
            // APPENDING RESULT GOES HERE //
            //----------------------------//
            
            $post .= "<div class='card N/A transparent'><div class='cardd'><img src='{$res[1]}' class='picture'>";
            $post .= "<div class='content'>";
            $post .= "<a style='color: black;' href='https://mimify.ml/profile.php?id={$res[3]}' class='header'>";
            $post .= "<div class='profile-pic'";
            $g = true;
            $im = "";
            for($i = 0 ; $i < strlen($res[5]) ; $i++){
                if($i < strlen($res[5]) - 1){
                    if(substr($res[5] , $i+1 , 1) == "/"){
                        if($g){
                            $g = false;
                            $im .= substr($res[5] , $i , 1) . "\\\\/";
                            $i++;
                            $i++;
                        }else{
                            $im .= substr($res[5] , $i , 1) . "\\/";
                            $i++;
                        }
                    }else{
                        $im .= substr($res[5] , $i , 1); 
                    }    
                }else{
                    $im .= substr($res[5] , $i , 1); 
                }
            }
            
            $post .= 'style="background-image: ' . str_replace(' ', '', 'url('."'{$im}'".');">');
            $post .= "</div><div class='detail'>";
            $post .= "<p class='name'>{$res[4]}</p><p class='posted'>";
            
            $date1 = strtotime($res[6]);  
            $date2 = strtotime($res[13]);   
            $diff = abs($date2 - $date1);
            $years = floor($diff / (365*60*60*24));  
            $months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));  
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60)) - 9;  
            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60) - 570;
            $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
            if($days > 0){ 
                $post .= "{$days} day ago";
            }else if($hours > 0){  
                $post .= "{$hours} hour ago";
            }else if($minutes > 0){  
                $post .= "{$minutes} min ago";
            }else{
                $post .= "Just Now";
            }
            $post .= "</p></div></a><div class='desc'>{$res[8]}</div><div class='tags'>";
            
            $tag = $res[7];
            $ctag = "";
            for($i = 0 ; $i < strlen($tag) ; $i++){
                if(substr($tag , $i , 1) != " "){
                    $ctag .= substr($tag , $i , 1);     
                }
                if(substr($tag , $i , 1) == " " || $i == strlen($tag)-1){
                    $post .= "<a href='search.php?tag=".substr($ctag, 1)."'><span>{$ctag} </span></a>";
                    $ctag = "";
                }    
            }
            
            $post .= "</div><div class='footer'>";
            
            if(strpos($res[10], $uid) !== false){
                $post .= "<div class='like' id='li{$res[0]}'";
                $post .= str_replace(' ', '', 'onclick="dislike('."'".$res[0]."','".$uid."'".')">');
                $post .= "<i class='fas fa-heart'></i><span id='s{$res[0]}'>{$res[9]}</span></div>";
            }else{
                $post .= "<div class='like' id='li{$res[0]}'";
                $post .= str_replace(' ', '', 'onclick="like('."'".$res[0]."','".$uid."'".')">');
                $post .= "<i class='far fa-heart'></i><span id='s{$res[0]}'>{$res[9]}</span></div>";
            }
            
            $post .= "<a href='{$res[2]}' download class='activator' style='color: #075e54;'>";
            $post .= "<i class='fas fa-cloud-download-alt'></i><span>Download</span></a></div></div></div></div>";
        
            $finalId = $res[0];
        
            
        }
        if($run){
            $sql = "UPDATE `follow` set `cpost` = '{$lastNo}-{$finalId}' WHERE `uid` LIKE '{$uid}';";
            mysqli_query($conn, $sql);
        }else{
            $sql = "UPDATE `follow` set `cpost` = '0' WHERE `uid` LIKE '{$uid}';";
            mysqli_query($conn, $sql);
        }
        mysqli_close($conn);
        
        echo $post;
	}
    
?>
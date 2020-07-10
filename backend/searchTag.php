<?php

    include 'dbManager.php';
    $post = "";
    $t;
    $uid = $_POST['uid'];
    if(substr($_POST['data'], 0 , 1) == "#"){
        $t = $_POST['data'];
    }else{
        $t = "#" . $_POST['data'];
    }
    if($_POST['mature'] == 0){
        $sql = "SELECT * , CURRENT_TIMESTAMP FROM `post` WHERE `tag` LIKE '{$t}%' AND `mature` = '0' ORDER BY `likes` DESC;";
    }else{
        $sql = "SELECT * , CURRENT_TIMESTAMP FROM `post` WHERE `tag` LIKE '{$t}%' ORDER BY `likes` DESC;";    
    }
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    while($res = mysqli_fetch_array($result)){
        $tag = $res[7];
        $ctag = "";
        for($i = 0 ; $i < strlen($tag) ; $i++){
            if(substr($tag , $i , 1) != " "){
                $ctag .= substr($tag , $i , 1);     
            }
            if(substr($tag , $i , 1) == " " || $i == strlen($tag)-1){
                $post .= "^{$ctag}";
                $ctag = "";
            }    
        }
        $post .= "|";
        $post .= "<div class='card N/A transparent'><div class='cardd'><img src='{$res[1]}' class='picture'>";
            $post .= "<div class='content'>";
            // if(strpos($res[13], $uid) !== false){
            //     $post .= "<div class='save' id='sa{$res[0]}'";
            //     $post .= str_replace(' ', '', 'onclick="unsave('."'".$res[0]."','".$uid."'".')">');
            //     $post .= "<i class='fas fa-bookmark'></i></div>";
            // }else{
            //     $post .= "<div class='save' id='sa{$res[0]}'";
            //     $post .= str_replace(' ', '', 'onclick="save('."'".$res[0]."','".$uid."'".')">');
            //     $post .= "<i class='far fa-bookmark'></i></div>";
            // }
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
            $date2 = strtotime($res[15]);   
            $diff = abs($date2 - $date1);
            $years = floor($diff / (365*60*60*24));  
            $months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));  
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
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
            
            $post .= "<a href='{$res[2]}' download class='activator' style='margin-right: 0%; color: #075e54;'>";
            $post .= "<i class='fas fa-cloud-download-alt'></i><span>Download</span></a>";
            
            if(strpos($res[12], $uid) !== false){
                $post .= "<div class='rate' style='padding-right: 10%; color: indigo;'><i class='fas fa-star'></i><span>Rated</span></div>";
            }else{
                $post .= "<div class='rate' id='rate{$res[0]}' style='padding-right: 10%; color: indigo;' onclick='rateOpen({$res[0]})'><i class='far fa-star'></i><span>Rate</span></div>";
            }
            $post .= "</div>";
            
            if(strpos($res[12], $uid) === false){
                $post .= "<div class='rater' id='ra{$res[0]}' style='display: none'>";
                $post .= "<div class='rates' onclick='rate({$res[0]}, 1)'><span>1</span></div>";
                $post .= "<div class='rates' onclick='rate({$res[0]}, 2)'><span>2</span></div>";
                $post .= "<div class='rates' onclick='rate({$res[0]}, 3)'><span>3</span></div>";
                $post .= "<div class='rates' onclick='rate({$res[0]}, 4)'><span>4</span></div>";
                $post .= "<div class='rates' onclick='rate({$res[0]}, 5)'><span>5</span></div></div>";
            }
            $post .="</div></div></div>|";      
    }
    echo $post;
?>
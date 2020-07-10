<?php    
    session_start();
    if((isset($_SESSION['user'])) && (isset($_SESSION['logsession']))){
		include 'dbManager.php';
        $uid = $_SESSION['user'];
        $log = $_SESSION['logsession'];
        $mature = 0;
        if(isset($_SESSION['mature'])){
            $mature = $_SESSION['mature'];
        } 
        $subs = array();
		$sql = "SELECT `subsid`, `cpost` FROM `follow` WHERE `uid` LIKE '{$uid}' LIMIT 1;";
        $result = mysqli_query($conn, $sql);
        $finalId = 0;
		if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
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
            $sql = "SELECT *, CURRENT_TIMESTAMP FROM `post` WHERE (";
            for($i = 1 ; $i <= sizeof($subs) ; $i++){
                if($i != sizeof($subs)){
                    $sql .= "`uid` LIKE '{$subs[$i-1]}' OR ";
                }else{
                    $sql .= "`uid` LIKE '{$subs[$i-1]}') ";
                }
            }
            
            $postNo = "";
            $cpo = $row['cpost'];
            if(strpos($cpo, '-') != false){
                for($i = 0 ; $i < strlen($cpo) ; $i++){
                    if(substr($cpo , $i , 1) == "-"){
                        break;
                    }else{
                        $postNo .= substr($cpo , $i , 1);
                    }
                }
            }else{
                $postNo = $cpo;
            }
            $sql .= "AND `id` > '{$postNo}' ";
            if($mature > 0){
                $sql .= "LIMIT 2;";  
            }else{
                $sql .= "AND `mature` = '0' LIMIT 2;";
            }
                
            // echo $subscriber;
            //  echo $sql;

            $result = mysqli_query($conn, $sql);
           
        }        		
    }else{
        header("Location: https://mimify.ml/Login/");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="social,media,mimify,memes,fun,laugh">
	<meta name="description" content="A Social Media Platform To Share Memes">
	<meta name="author" content="Anish Roy">
    <link rel="icon" type="image/png" href="logo.ico" />
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="transition.css">
    <script data-ad-client="ca-pub-8069173794963626" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script defer src="https://unpkg.com/swup@latest/dist/swup.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9f37ddf547.js"></script>
    <link rel="stylesheet" href="css/materialize.css">
    <script src="css/materialize.js"></script>
    <script src="js/jquery-3.5.1.js"></script>
    <title>mimify</title>
    <style>img[alt="www.000webhost.com"]{display: none;}
    .content .save {
        position: absolute;
        right: 5%;
        top: 6%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        color: #f56565;
        font-size: 22px;
    }
    .card .rater {
        display: flex;
        font-size: 15px;
        justify-content: space-around;
        margin-top: 15px;
    }
    .card .rater .rates{
        height:35px;
        width:35px;
        color:white;
        text-align: center;
        border-radius:50%;
        padding-top: 1.5%;
        background-color: #f56565;
    }
    </style>
</head>
<body>
    <br>
    <section id="swup" class="transition-fade">
        <section class="live" style="height: 125px;">
        <?php 
        $sql = "SELECT DISTINCT `uid`, `name`, `image` FROM `post` ORDER BY ((`rate`/(LENGTH(`rateId`) - LENGTH(REPLACE(`rateId`, ',', ''))))) DESC LIMIT 5;";
        $topResult = mysqli_query($conn, $sql);
        $tCounter = 0;
        while($topRes = mysqli_fetch_array($topResult)){
            $tCounter++;
            if($tCounter == 1){ ?>
                <a href="profile.php?id=<?php echo $topRes[0]; ?>" class='person live-active active1'><div class='profile-pic' style="background-image: url('<?php
                $g = true;
                $im = "";
                for($i = 0 ; $i < strlen($topRes[2]) ; $i++){
                        if($i < strlen($topRes[2]) - 1){
                            if(substr($topRes[2] , $i+1 , 1) == "/"){
                                if($g){
                                    $g = false;
                                    $im .= substr($topRes[2] , $i , 1) . "\\\\/";
                                    $i++;
                                    $i++;
                                }else{
                                    $im .= substr($topRes[2] , $i , 1) . "\\/";
                                    $i++;
                                }
                            }else{
                                $im .= substr($topRes[2] , $i , 1); 
                            }    
                        }else{
                            $im .= substr($topRes[2] , $i , 1); 
                        }
                    }
                    echo $im; ?>');"></div><p class='name' style="color: #000000;"><?php echo $topRes[1]; ?></p><span><i class='fas fa-medal'></i>&nbsp; 1st</span></a>
            <?php }else if($tCounter == 2){ ?>
                <a href="profile.php?id=<?php echo $topRes[0]; ?>" class='person live-active active2'><div class='profile-pic' style="background-image: url('<?php
                $g = true;
                $im = "";
                for($i = 0 ; $i < strlen($topRes[2]) ; $i++){
                        if($i < strlen($topRes[2]) - 1){
                            if(substr($topRes[2] , $i+1 , 1) == "/"){
                                if($g){
                                    $g = false;
                                    $im .= substr($topRes[2] , $i , 1) . "\\\\/";
                                    $i++;
                                    $i++;
                                }else{
                                    $im .= substr($topRes[2] , $i , 1) . "\\/";
                                    $i++;
                                }
                            }else{
                                $im .= substr($topRes[2] , $i , 1); 
                            }    
                        }else{
                            $im .= substr($topRes[2] , $i , 1); 
                        }
                    }
                    echo $im; ?>');"></div><p class='name' style="color: #000000;"><?php echo $topRes[1]; ?></p><span><i class='fas fa-medal'></i>&nbsp; 2nd</span></a>
            <?php }else if($tCounter == 3){ ?>
                <a href="profile.php?id=<?php echo $topRes[0]; ?>" class='person live-active active3'><div class='profile-pic' style="background-image: url('<?php
                $g = true;
                $im = "";
                for($i = 0 ; $i < strlen($topRes[2]) ; $i++){
                        if($i < strlen($topRes[2]) - 1){
                            if(substr($topRes[2] , $i+1 , 1) == "/"){
                                if($g){
                                    $g = false;
                                    $im .= substr($topRes[2] , $i , 1) . "\\\\/";
                                    $i++;
                                    $i++;
                                }else{
                                    $im .= substr($topRes[2] , $i , 1) . "\\/";
                                    $i++;
                                }
                            }else{
                                $im .= substr($topRes[2] , $i , 1); 
                            }    
                        }else{
                            $im .= substr($topRes[2] , $i , 1); 
                        }
                    }
                    echo $im; ?>');"></div><p class='name' style="color: #000000;"><?php echo $topRes[1]; ?></p><span><i class='fas fa-medal'></i>&nbsp; 3rd</span></a>
            <?php }else if($tCounter == 4){ ?>
                <a href="profile.php?id=<?php echo $topRes[0]; ?>" class='person live-active active4'><div class='profile-pic' style="background-image: url('<?php
                $g = true;
                $im = "";
                for($i = 0 ; $i < strlen($topRes[2]) ; $i++){
                        if($i < strlen($topRes[2]) - 1){
                            if(substr($topRes[2] , $i+1 , 1) == "/"){
                                if($g){
                                    $g = false;
                                    $im .= substr($topRes[2] , $i , 1) . "\\\\/";
                                    $i++;
                                    $i++;
                                }else{
                                    $im .= substr($topRes[2] , $i , 1) . "\\/";
                                    $i++;
                                }
                            }else{
                                $im .= substr($topRes[2] , $i , 1); 
                            }    
                        }else{
                            $im .= substr($topRes[2] , $i , 1); 
                        }
                    }
                    echo $im; ?>');"></div><p class='name' style="color: #000000;"><?php echo $topRes[1]; ?></p><span><i class='fas fa-medal'></i>&nbsp; 4th</span></a>
            <?php }else if($tCounter == 5){ ?>
                <a href="profile.php?id=<?php echo $topRes[0]; ?>" class='person live-active active5'><div class='profile-pic' style="background-image: url('<?php
                $g = true;
                $im = "";
                for($i = 0 ; $i < strlen($topRes[2]) ; $i++){
                        if($i < strlen($topRes[2]) - 1){
                            if(substr($topRes[2] , $i+1 , 1) == "/"){
                                if($g){
                                    $g = false;
                                    $im .= substr($topRes[2] , $i , 1) . "\\\\/";
                                    $i++;
                                    $i++;
                                }else{
                                    $im .= substr($topRes[2] , $i , 1) . "\\/";
                                    $i++;
                                }
                            }else{
                                $im .= substr($topRes[2] , $i , 1); 
                            }    
                        }else{
                            $im .= substr($topRes[2] , $i , 1); 
                        }
                    }
                    echo $im; ?>');"></div><p class='name' style="color: #000000;"><?php echo $topRes[1]; ?></p><span><i class='fas fa-medal'></i>&nbsp; 5th</span></a>
            <?php }
        }
        ?>
        </section>
    <section class="newsfeed" id="newsfeed">

            <?php while($res = mysqli_fetch_array($result)){ ?>
            <div class="card N/A transparent">
                <div class="cardd">
                    <img src="<?php echo $res[1]; ?>" class="picture">
                    <div class="content">
                        <?php if(strpos($res[13], $uid) !== false){ ?>
                            <div class="save" id="sa<?php echo $res[0]; ?>" onclick="unsave('<?php echo $res[0] . "' , '" . $uid; ?>')"><i class="fas fa-bookmark"></i></div>
                        <?php }else{ ?>
                            <div class="save" id="sa<?php echo $res[0]; ?>" onclick="save('<?php echo $res[0] . "' , '" . $uid; ?>')"><i class="far fa-bookmark"></i></div>
                        <?php } ?>
                        <a style="color: black;" href="<?php echo "https://mimify.ml/profile.php?id=". $res[3]; ?>"
                            class="header">
                            <div class="profile-pic" style="background-image: url('<?php echo $res[5]; ?>');">
                            </div>
                            <div class="detail">
                                <p class="name"><?php echo $res[4]; ?></p>
                                <p class="posted"><?php 
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
                                            echo $days ." day ago";
                                        }else if($hours > 0){  
                                            echo $hours . " hour ago";
                                        }else if($minutes > 0){  
                                            echo $minutes . " min ago";
                                        }else
                                            echo "Just Now";  ?></p>
                            </div>
                        </a>
                        <div class="desc"><?php echo $res[8] ?></div>
                        <div class="tags"><?php
                                $tag = $res[7];
                                $ctag = "";
                                for($i = 0 ; $i < strlen($tag) ; $i++){
                                    if(substr($tag , $i , 1) != " "){
                                        $ctag .= substr($tag , $i , 1);     

                                    }
                                    if(substr($tag , $i , 1) == " " || $i == strlen($tag)-1){
                                        echo "<a href='search.php?tag=".substr($ctag, 1)."'><span>{$ctag} </span></a>";
                                        $ctag = "";
                                    }    
                                }
                            ?>
                        </div>
                        <div class="footer">
                            <?php if(strpos($res[10], $uid) !== false){ ?>
                            <div class="like" id="li<?php echo $res[0]; ?>" onclick="dislike('<?php echo $res[0]."' , '". $uid ; ?>')">
                                <i class="fas fa-heart"></i>
                                <span id="s<?php echo $res[0]; ?>"><?php echo $res[9]; ?></span>
                            </div>
                            <?php }else{?>
                            <div class="like" id="li<?php echo $res[0]; ?>" onclick="like('<?php echo $res[0] . "' , '" . $uid; ?>')">
                                <i class="far fa-heart"></i>
                                <span id="s<?php echo $res[0]; ?>"><?php echo $res[9]; ?></span>
                            </div>
                            <?php } ?>
                            <a href="<?php echo $res[2]; ?>" download class="activator" style="margin-right: 0%;color: #075e54;">
                               <i class="fas fa-cloud-download-alt"></i>
                                <span>Download</span>
                            </a>
                            <?php if(strpos($res[12], $uid) !== false){ ?>
                                <div class="rate" style="padding-right: 10%; color: indigo;">
                                    <i class="fas fa-star"></i><span>Rated</span>
                                </div>
                            <?php }else{?>
                                <div class="rate" id="rate<?php echo $res[0]; ?>" style="padding-right: 10%; color: indigo;" onclick="rateOpen(<?php echo $res[0]; ?>)">
                                    <i class="far fa-star"></i><span>Rate</span>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if(strpos($res[12], $uid) === false){ ?>
                            <div class="rater" id="ra<?php echo $res[0]; ?>" style="display: none">
                                <div class="rates" onclick="rate(<?php echo $res[0]; ?> , 1)">
                                    <span>1</span>
                                </div>
                                <div class="rates" onclick="rate(<?php echo $res[0]; ?> , 2)">
                                    <span>2</span>
                                </div>
                                <div class="rates" onclick="rate(<?php echo $res[0]; ?> , 3)">
                                    <span>3</span>
                                </div>
                                <div class="rates" onclick="rate(<?php echo $res[0]; ?> , 4)">
                                    <span>4</span>
                                </div>
                                <div class="rates" onclick="rate(<?php echo $res[0]; ?> , 5)">
                                    <span>5</span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
            <?php 
                $finalId = $res[0];
            } ?>
        </section>
    
        <?php 
            $sql = "UPDATE `follow` set `cpost` = '{$postNo}-{$finalId}' WHERE `uid` LIKE '{$uid}';";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
        ?>
    </section>
    <script>
        function rateOpen(id){
            $('.rater').hide();
            $('#ra' + id).show();
        }
        function rate(id , n){
            $("#ra"+id).hide();
            $("#rate"+id).removeAttr("onclick");
            $("#rate"+id).html("<i class='fas fa-star'></i><span>Rated</span>");
            $.ajax({
                async: false,
                url:"backend/logSessionAuthenticator.php",
                type: "POST",
                data:{logSession: '<?php echo $log; ?>', uid: '<?php echo $uid; ?>'},
                success:function(data){
            		if(data == "true"){
                        $.ajax({
            				url:"profile/rate.php",
            				type: "POST",
            				data:{id: id, n: n, uid: '<?php echo $uid; ?>'},
                            success:function(data){}
                        });
            		}else{
            		    alert("You are already Signed in another device");
                        window.location.replace("https://mimify.ml/Login");
            		}
                }
            });
        }
        function like(id , uid){
            $.ajax({
                async: false,
                url:"backend/logSessionAuthenticator.php",
                type: "POST",
                data:{logSession: '<?php echo $log; ?>', uid: '<?php echo $uid; ?>'},
                success:function(data){
            		if(data == "true"){
            		    $("#li"+id).attr("onclick", "dislike('"+id+"' , '"+uid+"')");
                        $("#li"+id).html("<i class='fas fa-heart'></i><span id='s"+id+"'>"+((parseInt($('#s'+id).text()))+1)+"</span>");
                        $.ajax({
                        	url:"profile/like.php",
                        	type: "POST",
                        	data:{id: id, uid: uid},
                            success:function(data){}
                        });
            		}else{
            		    alert("You are already Signed in another device");
                        window.location.replace("https://mimify.ml/Login");
            		}
                }
        	});
        }
        function dislike(id , uid){
            $.ajax({
                async: false,
                url:"backend/logSessionAuthenticator.php",
                type: "POST",
                data:{logSession: '<?php echo $log; ?>', uid: '<?php echo $uid; ?>'},
                success:function(data){
            		if(data == "true"){
            		    $("#li"+id).attr("onclick", "like('"+id+"' , '"+uid+"')");
                        $("#li"+id).html("<i class='far fa-heart'></i><span id='s"+id+"'>"+((parseInt($('#s'+id).text()))-1)+"</span>");
                        $.ajax({
    				        url:"profile/dislike.php",
    				        type: "POST",
    				        data:{id: id, uid: uid},
                            success:function(data){}
                        });
                    }else{
                        alert("You are already Signed in another device");
                        window.location.replace("https://mimify.ml/Login");
                    }
                }
            });
        }
        
        function save(id , uid){
            $.ajax({
                async: false,
                url:"backend/logSessionAuthenticator.php",
                type: "POST",
                data:{logSession: '<?php echo $log; ?>', uid: '<?php echo $uid; ?>'},
                success:function(data){
            		if(data == "true"){
            		    $("#sa"+id).attr("onclick", "unsave('"+id+"' , '"+uid+"')");
                        $("#sa"+id).html("<i class='fas fa-bookmark'></i>");
                        $.ajax({
                        	url:"profile/save.php",
                        	type: "POST",
                        	data:{id: id, uid: uid},
                            success:function(data){}
                        });
            		}else{
            		    alert("You are already Signed in another device");
                        window.location.replace("https://mimify.ml/Login");
            		}
                }
        	});
        }
        function unsave(id , uid){
            $.ajax({
                async: false,
                url:"backend/logSessionAuthenticator.php",
                type: "POST",
                data:{logSession: '<?php echo $log; ?>', uid: '<?php echo $uid; ?>'},
                success:function(data){
            		if(data == "true"){
            		    $("#sa"+id).attr("onclick", "save('"+id+"' , '"+uid+"')");
                        $("#sa"+id).html("<i class='far fa-bookmark'></i>");
                        $.ajax({
    				        url:"profile/unsave.php",
    				        type: "POST",
    				        data:{id: id, uid: uid},
                            success:function(data){}
                        });
                    }else{
                        alert("You are already Signed in another device");
                        window.location.replace("https://mimify.ml/Login");
                    }
                }
            });
        }
        
        var action = 'inactive';
        $('.loading').hide();
        var p = 0;
        $(document).ready(function () {
            function getPost() {
                $.ajax({
                    url: "backend/getPost.php",
                    type: "POST",
                    data: { uid: '<?php echo $uid; ?>' , mature: '<?php echo $mature; ?>' },
                    success: function (data) {
                        $('#newsfeed').append(data);
                        if (data == '') {
                            $('.loading').hide();
                            action = 'active';
                        }else{
                            $('.loading').show();
                            action = "inactive";
                        }
                    }
                });
            }
            $(window).scroll(function () {
                if (($(window).scrollTop() + $(window).height() > $("#newsfeed").height()) && action == 'inactive') {
                    $('.loading').show();
                    action = 'active';
                    setTimeout(getPost(), 1000);
                }
            });
        });
    </script>

    <section class="nav">

        <div class="icon active">

            <i class="fas fa-fire"></i>

            <p>Home</p>

        </div>

        <a href="search.php">

            <div class="icon">

                <i class="fas fa-search"></i>

                <p>Search</p>

            </div>

        </a>

        <a href="upload.php">

            <div class="icon">

                <i class="fas fa-scroll"></i>

                <p>Post</p>

            </div>

        </a>

        <a href="notification.php">

            <div class="icon">

                <i class="fas fa-bell"></i>

                <p>Notifications</p>

            </div>

        </a>

        <a href="profile.php">

            <div class="icon">

                <i class="fas fa-user"></i>

                <p>Profile</p>

            </div>

        </a>

    </section>



    <div class="space"></div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.js"></script>

    <script src="assets/main.js"></script>

</body>



</html>



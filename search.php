<?php    
    session_start();
    if((isset($_SESSION['user'])) && (isset($_SESSION['logsession']))){
		$uid = $_SESSION['user'];
        $log = $_SESSION['logsession'];
        $toTag = false;
		if (isset($_GET['tag'])) {
		    $toTag = true;
		}else{
    		include 'dbManager.php';
            $sql = "SELECT *, CURRENT_TIMESTAMP FROM `post` ORDER BY `likes` DESC LIMIT 8;";
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
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
    <meta name="keywords" content="social,media,mimify,memes,fun,laugh,search">
	<meta name="description" content="A Social Media Platform To Share Memes">
	<meta name="author" content="Anish Roy">
	<link rel="icon" type="image/png" href="logo.ico" />
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9f37ddf547.js"></script>
    <title>mimify - Search</title>
    <style>img[alt="www.000webhost.com"]{display: none;}
        .content .save {
            position: absolute;
            right: 5%;
            top: 6%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            color: #f56565;
            font-size: 22px;
        }.card .rater {
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

    <header class="body-font">
        <div class="container mx-auto flex flex-wrap p-3 flex-col md:flex-row items-center">
            <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
                <img src="mimifylogo.png" style="hight: 2.5rem; width: 2.5rem;">
                <span class="ml-3 text-xl">mimify</span>
            </a>
        </div>
    </header>
    <form id="form" class="w-full max-w-sm" style="display: none;">
        <div class="flex items-center border-b border-b-2 border-teal-500 py-2">
            <input id="run"
                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="text" placeholder="Type Here" aria-label="Full name">
        </div>
    </form>
    <ul class="flex">
        <li class="flex-1 mr-2" id="exp">
            <a id="a-exp"
                class="text-center block border border-red-500 rounded py-2 px-4 bg-red-500 text-white">Explore</a>
        </li>
        <li class="flex-1 mr-2" id="us">
            <a id="a-us"
                class="text-center block border border-white rounded hover:border-gray-200 text-red-500 py-2 px-4">User</a>
        </li>
        <li class="flex-1 mr-2" id="tg">
            <a id="a-tg"
                class="text-center block border border-white rounded hover:border-gray-200 text-red-500 py-2 px-4">Tags</a>
        </li>
    </ul>


<?php if(!$toTag){ ?>
    <section class="newsfeed" id="explore">
        <br>    
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
                                        $date2 = strtotime($res[14]);  
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
            <?php } ?>
    </section>
    <?php } ?>
    <section id="userList" style="display: none;"></section>
    <br>
    <section class="newsfeed" id="tagList" style="display: none;"></section>
    
    <section class="nav">
        <a href="index.php">
            <div class="icon">
                <i class="fas fa-fire"></i>
                <p>Home</p>
            </div>
        </a>
        <a href="#">
            <div class="icon active">
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
    <script src="js/jquery-3.5.1.js"></script>
    <script>
        var relode = false;
    </script>
    <?php if($toTag){ ?>
    <script>
        relode = true;
        $('#tagList').attr("style", "display: block;");
        $('#explore').attr("style", "display: none;");
        $('#userList').attr("style", "display: none;");
        $('#form').attr("style", "display: block;");
        $('#a-tg').attr("class", "text-center block border border-red-500 rounded py-2 px-4 bg-red-500 text-white");
        $('#a-exp').attr("class", "text-center block border border-white rounded text-red-500 hover:bg-gray-200 py-2 px-4");
        $('#a-us').attr("class", "text-center block border border-white rounded text-red-500 hover:bg-gray-200 py-2 px-4");
    
        $('#run').attr("style", "display: none;");
    
        $.ajax({
            url: "backend/searchTag.php",
            type: "POST",
            data: { data: '<?php echo $_GET['tag']; ?>' , uid: '<?php echo $uid; ?>' },
            success: function (data) {
                sTag = data.split('|');
                $('#tagList').html("");
                var l = 0;
                for(var i = 0 ; i < sTag.length && l < 8 ; i+=2){
                        l++;
                        $('#tagList').append(sTag[i+1]);
                }
            }
        });
    </script>
    <?php } ?>
    <script>
        var current = 0;
        relode = false;
        $('#us').click(function () {
            current = 1;
            relode = true;
            $('#tagList').attr("style", "display: none;");
            $('#explore').attr("style", "display: none;");
            $('#userList').attr("style", "display: block;");
            $('#form').attr("style", "display: block;");
            $('#a-us').attr("class", "text-center block border border-red-500 rounded py-2 px-4 bg-red-500 text-white");
            $('#a-exp').attr("class", "text-center block border border-white rounded text-red-500 hover:bg-gray-200 py-2 px-4");
            $('#a-tg').attr("class", "text-center block border border-white rounded text-red-500 hover:bg-gray-200 py-2 px-4");
        });
        $('#exp').click(function () {
            if(relode){
                window.location.replace("https://mimify.ml/search.php");
            }
        });
        $('#tg').click(function () {
            current = 2;
            relode = true;
            $('#explore').html("");
            $('#tagList').attr("style", "display: block;");
            $('#explore').attr("style", "display: none;");
            $('#userList').attr("style", "display: none;");
            $('#form').attr("style", "display: block;");
            $('#a-tg').attr("class", "text-center block border border-red-500 rounded py-2 px-4 bg-red-500 text-white");
            $('#a-exp').attr("class", "text-center block border border-white rounded text-red-500 hover:bg-gray-200 py-2 px-4");
            $('#a-us').attr("class", "text-center block border border-white rounded text-red-500 hover:bg-gray-200 py-2 px-4");
        });
        
        var sUser = new Array();
        var sTag = new Array();
        var k = 0;
        $('#run').keyup(function () {
            if (current == 1) {
                var val = $('#run').val();
                if(val != ""){
                    if(val.length==1){
                        $.ajax({
                            url: "backend/searchUser.php",
                            type: "POST",
                            data: { data: val },
                            success: function (data) {
                                sUser = data.split('|');
                                $('#userList').html("");
                                for(var i = 0 ; i < sUser.length ; i+=2){
                                    if((sUser[i].toLowerCase()).includes('^' + val.toLowerCase())){
                                        $('#userList').append(sUser[i+1]);
                                    }
                                }
                            }
                        });
                    }else{
                        $('#userList').html("");
                        for(var i = 0 ; i < sUser.length ; i+=2){
                            if((sUser[i].toLowerCase()).includes('^' + val.toLowerCase())){
                                $('#userList').append(sUser[i+1]);
                            }
                        }
                    }                    
                }else{
                    $('#userList').html("");
                }
            } else if (current == 2) {
                var val = $('#run').val();
                if(val != ""){
                    if(val.length==1){
                        $.ajax({
                            url: "backend/searchTag.php",
                            type: "POST",
                            data: { data: val , uid: '<?php echo $uid; ?>' },
                            success: function (data) {
                                sTag = data.split('|');
                                $('#tagList').html("");
                                k = 0;
                                for(var i = 0 ; i < sTag.length && k < 8 ; i+=2){
                                    if((sTag[i].toLowerCase()).includes('^#' + val.toLowerCase()) || (sTag[i].toLowerCase()).includes('^' + val.toLowerCase())){
                                        k++;
                                        $('#tagList').append(sTag[i+1]);
                                    }
                                }
                            }
                        });
                    }else{
                        $('#tagList').html("");
                        k = 0;
                        for(var i = 0 ; i < sTag.length && k < 8 ; i+=2){
                            if((sTag[i].toLowerCase()).includes('^#' + val.toLowerCase()) || (sTag[i].toLowerCase()).includes('^' + val.toLowerCase())){
                                k++;
                                $('#tagList').append(sTag[i+1]);
                            }
                        }
                    }                    
                }else{
                    $('#tagList').html("");
                }
            }
        });
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

    </script>

</body>

</html>
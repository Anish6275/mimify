<?php    
    session_start();
    if((isset($_SESSION['user'])) && (isset($_SESSION['logsession']))){
		include 'dbManager.php';
        $uid = $_SESSION['user'];
        $log = $_SESSION['logsession'];
		$id= $uid;
		if (isset($_GET['id'])) {
			$id=$_GET['id'];
			$f = "FOLLOW";
			$sql = "SELECT * FROM `user` WHERE `uid` LIKE '{$id}' LIMIT 1;";
			$result = mysqli_query($conn, $sql);
			if ($result->num_rows > 0){
		    	$row = $result->fetch_assoc();  
		        $sql = "SELECT * FROM `follow` WHERE `uid` LIKE '{$uid}' AND `subsid` LIKE '%{$id}%';";
			    $result = mysqli_query($conn, $sql);
			    if ($result->num_rows > 0)
			        $f = "FOLLOWED";
			    
			}else{
		        $message = "No such user exists";
				echo '<script language="javascript">';
				echo 'alert("'.$message.'");';
				echo "window.location='https://mimify.ml/profile.php';";
				echo '</script>';
		    }
		    
		}else{
			$sql = "SELECT * FROM `user` WHERE `uid` LIKE '{$uid}' LIMIT 1;";
			$result = mysqli_query($conn, $sql);
			if ($result->num_rows > 0)
				$row = $result->fetch_assoc();
				//echo "own";
		}
		$sql = "SELECT `subsid` FROM `follow` WHERE `uid` LIKE '{$id}' LIMIT 1;";
		$result = mysqli_query($conn, $sql);
		if ($result->num_rows > 0){
			$rowf = $result->fetch_assoc();
			$following = substr_count($rowf['subsid'],",");
		}
		$sql = "SELECT count(uid) FROM `follow` WHERE `subsid` LIKE '%{$id}%';";
		$result = mysqli_query($conn, $sql);
		if ($result->num_rows > 0){
			$rowf = $result->fetch_assoc();			
		}

		
    }else{
        header("Location: https://mimify.ml/Login/");
    }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>mimify - Profile</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="social,media,mimify,memes,fun,laugh,user,profile">
	<meta name="description" content="A Social Media Platform To Share Memes">
	<meta name="author" content="Anish Roy">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://unpkg.com/swup@latest/dist/swup.min.js"></script>    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9f37ddf547.js"></script>
    <link rel="icon" type="image/png" href="logo.ico" />
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700%7CAllura" rel="stylesheet">
	<link href="assets/common-css/bootstrap.css" rel="stylesheet">
	<link href="assets/common-css/ionicons.css" rel="stylesheet">
	<link href="assets/common-css/fluidbox.min.css" rel="stylesheet">
	<link href="assets/01-cv-portfolio/css/styles.css" rel="stylesheet">
	<link href="assets/01-cv-portfolio/css/responsive.css" rel="stylesheet">
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
	<div class="container mx-auto flex flex-wrap p-3 flex-col md:flex-row items-center">
		<a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
			<img src="mimifylogo.png" style="hight: 2.5rem; width: 2.5rem;">
			<span class="ml-3 text-xl">mimify</span>
		</a>
	</div>
	<?php if($uid==$id){ ?>
        <div id="logout" onclick="window.location='backend/logout.php'" style="position: absolute;font-size: 28px;top: 2.5%;color: #f56565;left: 89%;">
            <i class="fas fa-sign-out-alt"></i></div>
    <?php } ?>
	<section class="intro-section" id="pro">
		<div class="container">
			<div class="row">
				<div class="col-md-1 col-lg-2"></div>
				<div class="col-md-10 col-lg-8">
					<div class="intro">
					    <div class="profile-img"><img src="<?php echo $row['image'] ?>" alt=""></div>
					    <h2><b><?php echo $row['name']; ?></b></h2>
						<h4 class="font-yellow"><?php echo $id ?></h4>
						<?php if($uid == $id){?>
						    <a class="downlad-btnn" href="#" id="edit">EDIT</a>
						<?php }else{ ?>
						    <a class="downlad-btnn" id="fo" style="color: #fff;"><?php echo $f; ?></a>
						<?php } ?>
						<ul class="information margin-tb-30" id="t"><?php echo $row['status']; ?></ul>
						<a class="downlad-btnn" href="#"><span id="s"><?php echo $rowf['count(uid)'] ?></span> subscriber</a>
						<a class="downlad-btnn" href="#"><span><?php echo $following; ?></span> followings</a>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php if($uid==$id){ ?>
        <section class="text-gray-700 body-font relative" id="editBox">
		<form action="profile/updateUser.php" method="POST" enctype="multipart/form-data">
		<div class="container px-5 py-24 mx-auto flex sm:flex-no-wrap flex-wrap">
			<h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Edit</h2>
			<img alt="content" class="object-cover object-center h-full w-full" id="show" onclick="triggerInp()"
			src="<?php echo $row['image']; ?>">
			<input type="file" name="file" value="nothing" multiple id="im" onchange="showPreview(event);" style="display: none;">
			<div 
			class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
			<input type="text" name="pastImg" value="<?php echo $row['image']; ?>" style="display: none;">
				<p class="leading-relaxed mb-5 text-gray-600"><b>Note:</b> The image must be square for better display.</p>
				<br>
				<input type="text" value="<?php echo $id; ?>" style="display: none;" name="uid">
				<textarea name="status"
					class="bg-white rounded border border-gray-400 focus:outline-none h-32 focus:border-red-500 text-base px-4 py-2 mb-4 resize-none"
					placeholder="Message"><?php echo $row['status']; ?></textarea>
				<div class="flex justify-center">
					<span class="inline-flex text-gray-700 bg-gray-200 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded text-lg edClose">Cancel</span>
					<button type="submit" name="submit"
						class="ml-4 inline-flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-300 rounded text-lg">Save</button>
				</div>
			</div>
		</div>
	</form>
	</section>
	<script>
	    function triggerInp(){
            document.querySelector('#im').click();
        }
        
        function showPreview(event){
            if(event.target.files.length > 0){
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("show");
                preview.src = src;
                preview.style.display = "block";
            }
		}
	</script>
<?php } ?>
<section class="portfolio-section section" id='pos'>
    <div class="container">
			<div class="row">
				<div class="col-sm-4">
					<div class="heading">
						<h3><b>Posts</b></h3>
						<div class="portfolioFilter clearfix margin-b-80">
						    <a id="mpbtn" style="color: #f56565;"><b>My Posts</b></a>
						   <?php if($uid==$id){ ?>
						    <a id="spbtn"><b>Saved</b></a>
						   <?php } ?>
					    </div>
					</div>
				</div>
				<div class="col-sm-8">
					
				</div>
			</div>
		</div>
	<?php
	    $sql = "SELECT *, CURRENT_TIMESTAMP FROM `post` WHERE `uid` LIKE '" . $id . "' ORDER BY `id` DESC;";    
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
	?>
	<section class="newsfeed mp" id="newsfeed">
        <?php while($res = mysqli_fetch_array($result)){ ?>
        
            <div id="a<?php echo $res[0]; ?>" class="card N/A transparent">
                <div class="cardd">
                    <img src="<?php echo $res[1]; ?>" class="picture">
                    <div class="content">
                    <?php if($uid!=$id){ ?>
                        <?php if(strpos($res[13], $uid) !== false){ ?>
                            <div class="save" id="sa<?php echo $res[0]; ?>" onclick="unsave('<?php echo $res[0] . "' , '" . $uid; ?>')"><i class="fas fa-bookmark"></i></div>
                        <?php }else{ ?>
                            <div class="save" id="sa<?php echo $res[0]; ?>" onclick="save('<?php echo $res[0] . "' , '" . $uid; ?>')"><i class="far fa-bookmark"></i></div>
                        <?php } ?>
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
    
<?php if($uid==$id){ 
    include 'dbManager.php';
    $sql = "SELECT *, CURRENT_TIMESTAMP FROM `post` WHERE `save` LIKE '%{$uid}%' ORDER BY `id` DESC;";    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
?>
    <section class="newsfeed sp" id="newsfeed" style="display: none;">
        <?php while($res = mysqli_fetch_array($result)){ ?>
        
            <div id="a<?php echo $res[0]; ?>" class="card N/A transparent">
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
</section>
<br><br><br><br>
	<section class="nav">
		<a href="index.php">
			<div class="icon">
				<i class="fas fa-fire"></i>
				<p>Home</p>
			</div>
		</a>
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
		<?php if($uid == $id){?>
		<div class="icon active">
			<i class="fas fa-user"></i>
			<p>Profile</p>
		</div>
		<?php }else{ ?>
		<a href="profile.php">
			<div class="icon active">
				<i class="fas fa-user"></i>
				<p>Notifications</p>
			</div>
		</a>
		<?php } ?>
	</section>


	<!-- SCRIPTS -->

	<script src="assets/common-js/jquery-3.2.1.min.js"></script>
	<script src="assets/common-js/tether.min.js"></script>
	<script src="assets/common-js/bootstrap.js"></script>
	<script src="assets/common-js/isotope.pkgd.min.js"></script>
	<script src="assets/common-js/jquery.waypoints.min.js"></script>
	<script src="assets/common-js/progressbar.min.js"></script>
	<script src="assets/common-js/jquery.fluidbox.min.js"></script>
	<script src="assets/common-js/scripts.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
	<script type="text/javascript">
        $('.sp').hide();
        $('#spbtn').click(function(){
            $('#mpbtn').removeAttr("style");
            $('#spbtn').attr("style","color: #f56565;");
            $('.sp').show();
            $('.mp').hide();
        });
        $('#mpbtn').click(function(){
            $('#spbtn').removeAttr("style");
            $('#mpbtn').attr("style","color: #f56565;");
            $('.sp').hide();
            $('.mp').show();
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

		$('#editBox').hide();

		$(document).ready(function(){

		    $('#edit').click(function() {

		        $('#editBox').show();

                $('#pos').hide();

                $('#pro').hide();

            });

            $('.edClose').click(function() {

                $('#pos').show();

                $('#pro').show();

                $('#editBox').hide();

            });

		});

		

		$("#fo").click(function(){
            $.ajax({
                async: false,
                url:"backend/logSessionAuthenticator.php",
                type: "POST",
                data:{logSession: '<?php echo $log; ?>', uid: '<?php echo $uid; ?>'},
                success:function(data){
            		if(data == "true"){
                        $.ajax({
            				url:"profile/follow.php",
            				type: "POST",
            				data:{id: "<?php echo $id; ?>", uid: "<?php echo $uid; ?>"},
            				success:function(data){
            					$('#fo').html(data);
            					if(data == "FOLLOWED"){
            						$('#s').text(parseInt($('#s').text())+1);
            					}else{
            						$('#s').text(parseInt($('#s').text())-1);
                                }
            				}
            
            			});
            		}else{
            		    alert("You are already Signed in another device");
                        window.location.replace("https://mimify.ml/Login");
            		}
                }
            });
		});

		

    </script>

</body>



</html>

<?php if($uid == $id){ ?>

    <div id="uploadimageModal" class="modal" role="dialog">

    	<div class="modal-dialog">

    		<div class="modal-content">

          		<div class="modal-header">

            		<button type="button" class="close" data-dismiss="modal">&times;</button>

            		<h4 class="modal-title">Upload & Crop Image</h4>

          		</div>

          		<div class="modal-body">

            		<div class="row">

      					<div class="col-md-8 text-center">

    						  <div id="image_demo" style="width:350px; margin-top:30px"></div>

      					</div>

      					<div class="col-md-4" style="padding-top:30px;">

      						<br />

      						<br />

      						<br/>

    						  <button class="btn btn-success crop_image">Crop & Upload Image</button>

    					</div>

    				</div>

          		</div>

          		<div class="modal-footer">

            		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          		</div>

        	</div>

        </div>

    </div>



<?php } ?>

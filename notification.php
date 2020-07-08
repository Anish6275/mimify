<?php    
    session_start();
    if((isset($_SESSION['user'])) && (isset($_SESSION['logsession']))){
		include 'dbManager.php';
        $uid = $_SESSION['user'];
        $log = $_SESSION['logsession'];  
        $sql = "SELECT notification.slno, user.image, user.name, notification.what, notification.when, CURRENT_TIMESTAMP, notification.where FROM notification, user WHERE notification.whome LIKE '{$uid}' AND user.uid = notification.where ORDER BY notification.slno DESC LIMIT 16;";  
        $result = mysqli_query($conn, $sql);  
        mysqli_close($conn);
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
    <meta name="keywords" content="social,media,mimify,memes,fun,laugh,notification">
	<meta name="description" content="A Social Media Platform To Share Memes">
	<meta name="author" content="Anish Roy">
	<link rel="icon" type="image/png" href="logo.ico" />
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9f37ddf547.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>mimify - Notification</title>
    <style>img[alt="www.000webhost.com"] {display: none;}
            a{color: #718096;}
            .noti{ position: relative;}
            .noti .cl{
                position: absolute;
                top: 45%;
                left: 90%;
                transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
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
    <section class="text-gray-700 body-font">
        <div class="container px-5 py-5 mx-auto">
        
        <?php 
            if ($result->num_rows > 0){
                while($res = mysqli_fetch_array($result)){ ?>
                <a href="profile.php?id=<?php echo $res[6]; ?>">
                    <div class="noti flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4" data-id="<?php echo $res[0]; ?>" id="d<?php echo $res[0]; ?>">
                        <div class="p-4 md:w-1/3 md:mb-0 mb-6 flex">
                            <div
                                class="w-12 h-12 inline-flex items-center justify-center rounded-full bg-red-100 text-red-500 mb-4 flex-shrink-0">
                                <img alt="blog" src="<?php echo $res[1]; ?>"
                                    class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center" style="margin-top: 16px;">
                            </div>
                            <div class="flex-grow pl-6">
                                <h2 class="text-gray-900 text-lg title-font font-medium mb-2" style="margin-bottom: 0; margin-top: 6px;"><?php 
                                                if($res[6] == $uid){
                                                    echo 'You';
                                                }else{
                                                    echo $res[2];                    
                                                }
                                            ?>
                                                
                                </h2>
                                <p class="leading-relaxed text-gray-600"><?php echo $res[3]; ?></p>
                                <a class="mt-3 text-red-500 inline-flex items-center" style="margin: 0;">
                                <?php 
                                        $date1 = strtotime($res[4]); 
                                        $date2 = strtotime($res[5]);   
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
                                            echo "Just Now"; 
                                ?>
                                </a>
                                <button onclick="f(<?php echo $res[0]; ?>)" id="c<?php echo $res[0]; ?>" style="display: none;" class="cl bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded">
                          Clear
                        </button>
                            </div>
                        </div>
                        
                    </div>
                </a>
        <?php   }
            }else{ ?>

            <?php } ?>
        </div>
    </section>
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
        <div class="icon active">
            <i class="fas fa-bell"></i>
            <p>Notifications</p>
        </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//rawgit.com/ngryman/jquery.finger/v0.1.2/dist/jquery.finger.js"></script>
    <script>
        function f(slno){
            $.ajax({
                async: false,
                url:"backend/logSessionAuthenticator.php",
                type: "POST",
                data:{logSession: '<?php echo $log; ?>', uid: '<?php echo $uid; ?>'},
                success:function(data){
            		if(data == "true"){
            		    $('#d' + slno).hide();
                        $.ajax({
    				        url:"backend/delNotification.php",
    				        type: "POST",
    				        data:{id: slno},
                            success:function(data){}
                        });
                    }else{
                        alert("You are already Signed in another device");
                        window.location.replace("https://mimify.ml/Login");
                    }
                }
            });
        }
        $('.noti').on('press', function (ev) {
            ev.preventDefault();
            var id = $(this).attr('data-id');
            $('.cl').hide();
            $('#c' + id).show();
        });
    </script>
</body>
</html>
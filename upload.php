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
    }else{
        header("Location: https://mimify.ml/Login/");
    }
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="social,media,mimify,memes,fun,laugh,upload">
	<meta name="description" content="A Social Media Platform To Share Memes">
	<meta name="author" content="Anish Roy">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="logo.ico" />
    <link rel="stylesheet" href="assets/delstyle.css">
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9f37ddf547.js"></script>
    <title>mimify - Upload</title>
    <style>img[alt="www.000webhost.com"] {display: none;}
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
    <ul class="flex">
        <li class="flex-1 mr-2">
            <a id="up"
                class="text-center block border border-red-500 rounded py-2 px-4 bg-red-500 text-white">Upload</a>
        </li>
        <li class="flex-1 mr-2">
            <a id="re"
                class="text-center block border border-white rounded hover:border-gray-200 text-red-500 py-2 px-4">Remove</a>
        </li>
    </ul>
    <section id="upload" class="text-gray-700 body-font overflow-hidden">
        <div class="container px-5 py-2 mx-auto">
            <form action="upload/ftpUpload.php" method="POST" enctype="multipart/form-data" class="lg:w-4/5 mx-auto flex flex-wrap">
                <img src="add.jpg" alt="ecommerce" id="preview" onclick="triggerInp()" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="add.jpg">
                <input type="file" name="file" required multiple id="file-ip-1" onchange="showPreview(event);" style="display: none;"> 

                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Details</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">Seperate two tags by blank space.</p>
                    <input name="uid" value="<?php echo $uid; ?>" style="display: none;">
                    <input name="tag"
                        class="bg-white rounded border border-gray-400 focus:outline-none focus:border-red-500 text-base px-4 py-2 mb-4"
                        placeholder="Tag" type="text">
                    <textarea name="des"
                        class="bg-white rounded border border-gray-400 focus:outline-none h-32 focus:border-red-500 text-base px-4 py-2 mb-4 resize-none"
                        placeholder="Description"></textarea>
                        <?php if($mature != 0){ ?>
                            <label class="md:w-2/3 block text-gray-500 font-bold">
                                <input class="mr-2 leading-tight" name="mature" type="checkbox">
                                <span class="text-sm">mature content</span>
                            </label>
                            <br>
                        <?php } ?>
                    <button type="submit" name="uploadBtn"
                        class="text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded text-lg">Post</button>
                    <p class="text-xs text-gray-500 mt-3">It may take some time to reflect the result.</p>
                </div>
    </form>
        </div>
    </section>
    <section id="delete">
        <div class="container-fluid">
        <div class="row">
            <div class="column" id="dpost">
            </div>
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
        <div class="icon active">
            <i class="fas fa-scroll"></i>
            <p>Post</p>
        </div>
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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var retrive = true;
        
        $('#re').click(function(){
            $('#delete').show();
            $('#upload').hide();
            $('#re').attr("class", "text-center block border border-red-500 rounded py-2 px-4 bg-red-500 text-white");
            $('#up').attr("class", "text-center block border border-white rounded text-red-500 hover:bg-gray-200 py-2 px-4");
            if(retrive){
                retrive = false;
                $.ajax({
                    url: "backend/removePost.php",
                    type: "POST",
                    data: { uid: '<?php echo $uid; ?>' },
                    success: function (data) {
                        $('#dpost').html(data);
                        $('.btn').hide();
                    }
                });
            }
        });
        $('#up').click(function(){
            $('#delete').hide();
            $('#upload').show();
            $('#up').attr("class", "text-center block border border-red-500 rounded py-2 px-4 bg-red-500 text-white");
            $('#re').attr("class", "text-center block border border-white rounded text-red-500 hover:bg-gray-200 py-2 px-4");
        });
        $('.btn').hide();
        function deletePost(id){
            $.ajax({
                async: false,
                url:"backend/logSessionAuthenticator.php",
                type: "POST",
                data:{logSession: '<?php echo $log; ?>', uid: '<?php echo $uid; ?>'},
                success:function(data){
            		if(data == "true"){
            		    if(confirm('Are you sure you want to delete this Post?')){
                            $.ajax({
                                url: "backend/deletePost.php",
                                type: "POST",
                                data: { id: id , uid: '<?php echo $uid; ?>'},
                                success: function (data) {
                                    $('#div' + id).hide();
                                }
                            });
                        }
            		}else{
            		    alert("You are already Signed in another device");
                        window.location.replace("https://mimify.ml/Login");
            		}
                }
        	});
            
        }
        function show(id) {
            $('.btn').hide();
            $('.but' + id).show();
        }
        function triggerInp(){
            document.querySelector('#file-ip-1').click();
        }
        function showPreview(event){
            if(event.target.files.length > 0){
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
</script>
</body>

</html>
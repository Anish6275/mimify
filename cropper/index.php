<!DOCTYPE html>
<html>
<head>
<title>Image Crop</title>
<link rel="stylesheet" href="croppie.css"/>
</head>
<body>
<body>  
   <div class="container">
      <br>
      <h3 align="center">Image Crop and Upload using Jquery with Php and Ajax</h3>
      <br>
      <br>
      <p style="text-align:center;">Select Profile Image</p>
     <input type="file" name="upload_image" id="upload_image" accept="image/*">
      <div id="uploadimage">
      </div>
      <button class="crop_image">Crop and Upload Image</button>
      <div id="uploaded_image"></div>
   </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="croppie.min.js"></script>
<script src="scriptsss.js"></script>
</html>
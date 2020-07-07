$(document).ready(function(){
    var wid = $(window). width() - ((2*$(window). width())/100);
    $(".crop_image").hide();
    $("#uploadimage").hide();
    $image_crop = $('#uploadimage').croppie({
       enableExif: true,
       viewport: {
         width:((2*wid)/3),
         height:((2*wid)/3),
         type:'square' //circle
       },
       boundary:{
         width:wid,
         height:wid
       }
     });
   
     $('#upload_image').on('change', function(){
        $("#uploadimage").show();  
       var reader = new FileReader();
       reader.onload = function (event) {
         $image_crop.croppie('bind', {
           url: event.target.result
         }).then(function(){
           console.log('jQuery bind complete');
         });
       }
       reader.readAsDataURL(this.files[0]);
       $(".crop_image").show();
     });
   
     $('.crop_image').click(function(event){
       $image_crop.croppie('result', {
         type: 'canvas',
         size: 'viewport'
       }).then(function(response){
        $("#uploadimage").hide();
         $.ajax({
           url:"upload.php",
           type: "POST",
           data:{"image": response},
           success:function(data)
           {
             $('#uploaded_image').html(data);
             $('.crop_image').hide();
           }
         });
       })
     });
   
   });
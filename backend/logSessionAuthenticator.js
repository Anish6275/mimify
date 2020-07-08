function logSessionAuthenticate(sessionId , uid){
    $.ajax({
        url:"backend/logSessionAuthenticator.php",
        type: "POST",
        data:{logSession: sessionId, uid: uid},
        success:function(data){
    		if(data == "true"){
    		    return true;    
    		}else{
    		    return false;
    		}
        }
	});
}
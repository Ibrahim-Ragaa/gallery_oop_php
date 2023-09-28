$(document).ready(function(){
    
    var user_href;
    var user_href_splitted;
    var user_id;
    var image_src;
    var image_src_splitted;
    var image_name;
    
    
    $(".modal-thumbnail").click(function(){
        
        $("#set_user_image").prop('disabled',false);
        
        user_href = $("#user_id").prop('href');
        user_href_splitted = user_href.split("=");
        user_id = user_href_splitted[user_href_splitted.length -1];
        
        image_src = $(this).prop('src');
        image_src_splitted = image_src.split("/");
        image_name = image_src_splitted[image_src_splitted.length -1];
        
//        alert(image_name);        
    });
    
    
    
    
    $("#set_user_image").click(function(){
        $.ajax({
            url: "includes/ajax_code.php",
            data:{user_id: user_id, image_name: image_name},
            type: "POST",
            success: function(data){
                if(!data.error){
                    let theAtt1 = document.getElementById("ibrahim1").attributes[2];
                    theAtt1.nodeValue = "images/"+image_name;                
                    // $(".user_image_box a img").prop('src', data);
                    // location.reload(true);
                    // alert(image_name); 
                }
            }
        });        
    });
    
    
    
    
    
    
    
    
    
    // tinymce.init({selector: 'textarea'})
});
/**********
JS FILES FOR ADMIN SETTINGS - AZR
***********/

jQuery(document).ready(function($){
  
    $("#sfl_setting_checkbox").on("click", function(){
        let checked = 0 ;
        if($(this).prop("checked")) {
            // checked
            checked = 1;
        }
       // alert(checked);
        var data = {
    			'action': 'sflSwitchSettingPost',
    			'checked': checked
    			
    	};
    		
    	$.ajax ({
            url: ajaxurl,
            type: "POST",
            data: data,
            dataType: "json",
            success: function(response){
                   $("#successmsg").fadeIn(1000);
                   
                   setTimeout(function(){
                       $("#successmsg").fadeOut(1000);
                   }, 4000);
            }
        });
    });
});
    

    
  


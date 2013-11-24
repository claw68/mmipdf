// JavaScript Document
$(function()
        { 
                         			
                                			
            //confirm buttons                                                                                                                                                   			

                                                                
            ///////////////aaaaaaaaaaaaddddddddddddddddddddddmmmmmmmmmmmiiiiiiiiiiiinnnnnnnnnnnn                    
            $('#total1').attr("disabled", true);        
            

            $("#proj").button().width(200).click(function() {  
                                         window.location = 'mmi_c/proj';
                                			});
            $("#logout_a").button().width(200).click(function() {  
                                               window.location = 'mmi_c/logout';
                                               
                                			});
  
              
            
            $("#logout").button();
            
            
             //////////////////////////////////////////// end aaaaaaaaadddddddddddddddddddddmmmmmmiiiiiinnnnn
            
            /////////////////////////pppppppppprrrrrrrrrrrrrrroooooooooooooooooojjjjjjjjjjjjjjjjjj
               $("#toggle_lcol").button().click(function() {
               $(".leftcol").toggle();
               });
                              $("#toggle_rcol").button().click(function() {
               $(".rightcol").toggle();
               });
                              $("#toggle_ccol").button().click(function() {
               $(".centercol").toggle();
               });
            
            
            ////////////////////////////end pppppppprrrrrrrrrooooooooooojjjjjjjjjjjj
            
            
            
            $("#login").dialog({
                        height: 'auto',
                        width: 'auto',
                        closeOnEscape: false,
                  			buttons: {
                            Submit: function(){
                                            $.ajax({
      type: "POST",
      url: "mmi_c/ajax_user_login",
      data: $("#login_form").serialize(),
      success: function(data) {
             if(data == 'OK') // LOGIN OK?
          {  
        window.location = '';   
           }
           else if(data == 'admin')
           {
           window.location = ''; 
           }
           ////put error something in login
           }
           
           });
                                
    
                            }
                        }
            }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();  
            
                            $('#login').keyup(function(e) {
    if (e.keyCode == 13) {
        $.ajax({
            type: "POST",
            url: "mmi_c/ajax_user_login",
            data: $("#login_form").serialize(),
            success: function(data) {
                if(data == 'OK'){
                    window.location = '';
                }
                           else if(data == 'admin')
           {
           window.location = ''; 
           }
                else{
                   $("#error").dialog('open');    //window.location = '';
                  // $("#error").focus();
                }
           ////put error something in login
           }

           });
    }
});  
            
            
          $("#success").dialog({
                autoOpen: false,
          			show: 'blind',
          			hide: 'explode',
          			width: 380,
          			modal: true,
          			buttons: {
                
                      OK: function() {
            					$(this).dialog('close');
            				}
                }
          });    
          
          $("#before").dialog({
                autoOpen: false,
          			show: 'blind',
          			hide: 'explode',
          			width: 380,
          			modal: true,
          });
          
          $("#complete").dialog({
                autoOpen: false,
          			show: 'blind',
          			hide: 'explode',
          			width: 380,
          			modal: true,
          });
          
          $("#error").dialog({
                autoOpen: false,
          			show: 'blind',
          			hide: 'explode',
          			width: 380,
          			modal: true,
          			buttons: {
                
                      OK: function() {
            					$(this).dialog('close');
            				}
                }
          });
        
});

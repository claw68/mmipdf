$(function()
        { 
<?php foreach($event as $row){?>
$("#cbtn<?php echo $row->event_id; ?>").button().click(function() {
			                                   var  txt1 = "<?php echo $row->event_name?>";
                                				$('#cat_dis').text(txt1);
                             
                                        $(this).css("background", "#f58400");
                                  
                  
                                			});
<?php }?>}                                			
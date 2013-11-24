<script type="text/javascript">	      
$(function()
{   ///onload

<?php if($eventInfo->status != 1){?>
 $(".score_field_m").attr("disabled", "disabled");
          $("#conbtn_m").attr("disabled", "disabled");   
<?php } ?>



   	$("#total_m").text("0");
   	var total_m = 0; 
		$(".score_field_m").each(function() {
			total_m += +this.value*$(this).prev().val();
			total_m = Math.round(total_m*100)/100;
		});
		$("#total_m").text(total_m);
      
//validation if <0,>100 and is not int, change the value to zero
<?php for($i=0;$i<sizeof($crit);$i++){?>
$("#score_m<?php echo $i;?>").bind("keyup", function(){
var regexp = /^\d*\.?\d*$/;
if(this.value<0|| $(this).val() >100 || this.value=="" || !( regexp.test( $(this).val() ))){
$(this).val("0"); 
                                                                }
});

<?php } ?>


$(".score_field_m").bind("keyup", function(){
var total_m = 0; 
		$(".score_field_m").each(function() {
			total_m += +this.value*$(this).prev().val();
			total_m = Math.round(total_m*100)/100;
		});
		$("#total_m").text(total_m);
		});
				$(".score_field_m").focus(function(){
    // Select input field contents
    this.select();
    
});
		$(".score_field_m").click(function(){
    // Select input field contents
    this.select();
});


$("#conbtn_m").button().click(function () {  
            
      $.ajax({
      type: "POST",
      url: "mmi_c/ajax_set_score_m",
      data:  $("#score_submit_m").serialize(),
      success: function() {
      //$('.j_table').trigger('reloadGrid');
      $("#success").dialog('open');
                         $.ajax({
      type: "POST",
      url: "mmi_c/bottom_grid",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".j_table").html(data);
           }
           });  
        
        //$("#error").dialog('open'); 

      },
      beforeSend: function()
      {
         $(".score_field_m").attr("disabled", "disabled");
          $("#conbtn_m").attr("disabled", "disabled");   
      },
      complete: function()
      {
        $(".score_field_m").attr("disabled", "");
         $("#conbtn_m").attr("disabled", "");
         $("#conbtn_m").css("background", "");  
                
      },
      error: function()
      {
        $("#error").dialog('open');   
      }
           });

           return false;                 
});
});
                                 
                                </script>  
   	  <fieldset class="text ui-widget-content ui-corner-all" style="margin-top:20px;height: 1050px; border: 1px solid #bbb;font-family:lucida calligraphy;">
  	  <legend style="font-size: 30px; font-weight: bold;">Male</legend>
 <div class="cm1">
  <img style="background-color:#fff" src="files/<?php echo $contInfo->cont_pic;?>" />
 </div>
  	     <form id="score_submit_m" method="post"> 
  	      <input type="hidden" name='valid' value='1'/>
  	     <table class="criteria"> 
  	    
  	     <input type="hidden" name="cont_id_m" id="cont_id_m" value="<?php echo $contInfo->cont_id;?>"/>
  	     <input type="hidden" name="event_id_m" id="event_id_m" value="<?php echo $event_id?>"/>
  	     <input type="hidden" name="judge_id_m" id="judge_id_m" value="<?php echo $this->session->userdata('judge_id')?>"/>
  	     
  	        <?php for($i=0;$i<sizeof($crit);$i++){?>
           <tr>
            <td><?php echo $crit[$i]->crit_name?></td>
            <td><?php echo $crit[$i]->crit_percent*100?>%</td>  
            <td class="quantity">
              <input type="hidden" name="crit_id_m[]" value="<?php echo $crit[$i]->crit_id?>" />
              <input type="hidden" value="<?php echo $crit[$i]->crit_percent?>" /> 
              <input type="text" class="score_field_m" name="score_m[]" id="score_m<?php echo $i;?>" <?php if($allScore_m){?> value="<?php echo $allScore_m[$i]->score?>" <?php }else {?> value="0"<?php } ?> />
            </td> 
           </tr>  
            <?php }?>
  
          
           <tr>
            <td style="padding-top:70px"> Total </td>
            <td></td> 
            <td style="padding-top:70px" id="total_m"></td> 
           </tr>
             
  	     </table>
  	       </form>   
  	     <div style="margin-top:20px"><input  id="conbtn_m" type="submit" value="CONFIRM" /></div>
  	      </fieldset>

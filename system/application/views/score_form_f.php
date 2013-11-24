<script type="text/javascript">	      
$(function()
{


<?php if($eventInfo->status != 1){?>
 $(".score_field_f").attr("disabled", "disabled");
          $("#conbtn_f").attr("disabled", "disabled");   
<?php } ?>
 ///onload
   	$("#total_f").text("0");
   	var total_f = 0; 
		$(".score_field_f").each(function() {
			total_f += +this.value*$(this).prev().val();
		});
		total_f = Math.round(total_f*100)/100;
		$("#total_f").text(total_f);
		
//validation if <0,>100 and is not int, change the value to zero
<?php for($i=0;$i<sizeof($crit);$i++){?>
$("#score_f<?php echo $i;?>").bind("keyup", function(){
var regexp = /^\d*\.?\d*$/;
if(this.value<0|| $(this).val() >100 || this.value=="" || !( regexp.test( $(this).val() ))){
$(this).val("0"); 
                                                                }
});

<?php } ?>


$(".score_field_f").bind("keyup", function(){
var total_f = 0; 
		$(".score_field_f").each(function() {
			total_f += +this.value*$(this).prev().val();
		});
		total_f = Math.round(total_f*100)/100;
			$("#total_f").text(total_f);
		});
		
		$(".score_field_f").focus(function(){
    // Select input field contents
    this.select();
});
		$(".score_field_f").click(function(){
    // Select input field contents
    this.select();
});
 

$("#conbtn_f").button().click(function () {  
            
      $.ajax({
      type: "POST",
      url: "mmi_c/ajax_set_score_f",
      data:  $("#score_submit_f").serialize(),
      success: function() {
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
         $(".score_field_f").attr("disabled", "disabled");
          $("#conbtn_f").attr("disabled", "disabled");   
      },
      complete: function()
      {
        $(".score_field_f").attr("disabled", "");
         $("#conbtn_f").attr("disabled", "");
         $("#conbtn_f").css("background", "");  
                
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
  	  <legend style="font-size: 30px; font-weight: bold;">Female</legend>
       <div class="cf1">
        <img style="background-color:#fff" src="files/<?php echo $contInfo->cont_pic;?>" />
       </div>
  	     <form id="score_submit_f" method="post"> 
  	     <input type="hidden" name='valid' value='1'/>
  	     <table class="criteria"> 
  	    
  	     <input type="hidden" name="cont_id_f" id="cont_id_f" value="<?php echo $contInfo->cont_id;?>"/>
  	     <input type="hidden" name="event_id_f" id="event_id_f" value="<?php echo $event_id?>"/>
  	     <input type="hidden" name="judge_id_f" id="judge_id_f" value="<?php echo $this->session->userdata('judge_id')?>"/>
  	     
  	        <?php for($i=0;$i<sizeof($crit);$i++){?>
           <tr>
            <td><?php echo $crit[$i]->crit_name?></td>
            <td><?php echo $crit[$i]->crit_percent*100?>%</td> 
            <td class="quantity">
              <input type="hidden" name="crit_id_f[]" value="<?php echo $crit[$i]->crit_id?>" />
              <input type="hidden" value="<?php echo $crit[$i]->crit_percent?>" /> 
              <input type="text" class="score_field_f" name="score_f[]" id="score_f<?php echo $i;?>" <?php if($allScore_f){?> value="<?php echo $allScore_f[$i]->score?>" <?php }else {?> value="0"<?php } ?> />
            </td> 
           </tr>  
            <?php } ?>
  
          
           <tr>
            <td style="padding-top:70px"> Total </td> 
            <td></td>
            <td style="padding-top:70px" id="total_f"></td> 
           </tr>
             
  	     </table>
  	       </form>   
  	     <div style="margin-top:20px"><input  id="conbtn_f" type="submit" value="CONFIRM" /></div>
  	      </fieldset>
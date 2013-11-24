
   	  <fieldset class="text ui-widget-content ui-corner-all" style="width:430px;height: 600px; border: 1px solid #bbb;font-family:lucida calligraphy;">
  	  <legend style="font-size: 30px; font-weight: bold;">Male</legend>
 <div class="cm1">
  <img style="background-color:#fff" src="../files/<?php echo $contInfo->cont_pic;?>" />
 </div>
  	  
  	   
  	     <table style="padding-left:30px" class="criteria"> 
  	        <?php for($i=0;$i<sizeof($judge);$i++){?>
           <tr>
            <td style="font-size:30px">Judge</td>
            
            <td class="quantity">
              
            </td> 
            <td style="font-size:30px">
             <?php echo $total[$i]['total']?>
            </td>
           </tr>  
            <?php } ?>
  
          
             
  	     </table>
  	   
  	  
  	      </fieldset>

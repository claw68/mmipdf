<script type="text/javascript">
var cont_num = 1;
var event_num = 1;
var event_name = new Array();
<?php foreach($event as $row){?>
event_name[<?php echo $row->event_id;?>] = "<?php echo $row->event_name;?>";
<?php } ?>

$(function()
{
//onkeypress functions
function checkKey(e){
  switch (e.keyCode) {
  
    case 83://down
      if(event_num > 1){
        event_num--;
      }
      else{
        event_num = <?php echo sizeof($event);?>;
      } 
      $('#event_id').val(event_num);
      var txt1 = event_name[event_num];
      $('#cat_dis').html(txt1).addClass('newClass');  
      setTimeout(function() {
        $('#cat_dis').removeClass('newClass', 1000);
      }, 500);
      update_data();
      break;
        
    case 87://up
      if(event_num < <?php echo sizeof($event);?>){
        event_num++;
      }
      else{
        event_num = 1;
      }
      $('#event_id').val(event_num);
      var txt1 = event_name[event_num];
      $('#cat_dis').html(txt1).addClass('newClass');  
      setTimeout(function() {
        $('#cat_dis').removeClass('newClass', 1000);
      }, 500);
      update_data();
      break;
    
    case 65://left
      if(cont_num > 1){
        cont_num--;
      }
      else{
        cont_num = <?php echo $countCont/2;?>;
      }
      $('#cont_id').val(cont_num);
      var  txt = "Contestant #"+cont_num;
      $('#id_dis').text(txt).addClass('newClass');  
      setTimeout(function() {
        $('#id_dis').removeClass('newClass', 1000);
      }, 500);
      update_data();
      break;
    
    case 68://right
      if(cont_num < <?php echo $countCont/2;?>){
        cont_num++;
      }
      else{
        cont_num = 1;
      }
      $('#cont_id').val(cont_num);
      var  txt = "Contestant #"+cont_num;
      $('#id_dis').text(txt).addClass('newClass');  
      setTimeout(function() {
        $('#id_dis').removeClass('newClass', 1000);
      }, 500);
      update_data();
      break;
    
    default:
              
  }
  }
  function update_data(){
      
  $.ajax({
    type: "POST",
    url: "../mmi_c/proj_m",
    data: $("#global_data").serialize(),
    success: function(data) {
      $(".leftcol").html(data);
    }
  });
  
  $.ajax({
    type: "POST",
    url: "../mmi_c/proj_f",
    data: $("#global_data").serialize(),
    success: function(data) {
    $(".rightcol").html(data);
    }
  });
    <?php for($ii=1;$ii<=$countCont/2;$ii++){?> 
$("#cont_id<?php echo $ii; ?>").css("background", "");
<?php }?>
  $("#cont_id"+cont_num).css("background", "#f58400");
          
}

if ($.browser.mozilla) {
  $(document).keydown (checkKey);
} 
else {
  $(document).keydown (checkKey);
}


 
//onload functions here!
$("#cbtn1").css("background", "#f58400");    
$("#cont_id1").css("background", "#f58400"); 
$('#cat_dis').text("<?php echo $event[0]->event_name;?>");
$('#id_dis').text("Contestant #1");
$('#cont_id').val("1");
$('#event_id').val("1");

      $.ajax({
      type: "POST",
      url: "../mmi_c/proj_m",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".leftcol").html(data);
           }
           });
      $.ajax({
      type: "POST",
      url: "../mmi_c/proj_f",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".rightcol").html(data);
           }
           });
          

//select event (category)
<?php foreach($event as $row){?>
$("#cbtn<?php echo $row->event_id; ?>").button().click(function() {
    var  txt1 = "<?php echo $row->event_name?>";
    $('#cat_dis').html(txt1).addClass('newClass');  
            			setTimeout(function() {
            				$('#cat_dis').removeClass('newClass', 1000);
            			}, 500);

    <?php foreach($event as $row1){?>$("#cbtn<?php echo $row1->event_id?>").css("background", "");<?php }?>
    $(this).css("background", "#f58400");
     $('#event_id').val("<?php echo $row->event_id; ?>");
      $.ajax({
      type: "POST",
      url: "../mmi_c/proj_m",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".leftcol").html(data);
           }
           });
      $.ajax({
      type: "POST",
      url: "../mmi_c/proj_f",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".rightcol").html(data);
           }
           }); 
                                		
  });
<?php }?>

//select contestant
<?php for($i=1;$i<=$countCont/2;$i++){?> 
$("#cont_id<?php echo $i; ?>").click(function() {  
var  txt = "<?php echo "Contestant #".$i;?>";
$('#id_dis').text(txt).addClass('newClass');  
            			setTimeout(function() {
            				$('#id_dis').removeClass('newClass', 1000);
            			}, 500); 
<?php for($ii=1;$ii<=$countCont/2;$ii++){?> 
$("#cont_id<?php echo $ii; ?>").css("background", "");
<?php }?>
$(this).css("background", "#f58400");
$('#cont_id').val("<?php echo $i; ?>");
      $.ajax({
      type: "POST",
      url: "../mmi_c/proj_m",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".leftcol").html(data);
           }
           });
      $.ajax({
      type: "POST",
      url: "../mmi_c/proj_f",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".rightcol").html(data);
           }
           });
});
<?php }?>
     
});

</script>
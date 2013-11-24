<script type="text/javascript">
$(function()
{
 
//onload functions here!
$("#cbtn1").css("background", "#f58400");    
$("#cont_id1").css("background", "#f58400"); 
$('#cat_dis').text("<?php echo $event[0]->event_name;?>");
$('#id_dis').text("Contestant #1");
$('#cont_id').val("1");
$('#event_id').val("1");

      $.ajax({
      type: "POST",
      url: "mmi_c/score_form_m",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".leftcol").html(data);
           }
           });
            $.ajax({
      type: "POST",
      url: "mmi_c/score_form_f",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".rightcol").html(data);
           }
           });
$.ajax({
      type: "POST",
      url: "mmi_c/bottom_grid",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".j_table").html(data);
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
     $('#event_id').val("<?php echo $row->event_id;?>");
     $('#cont_id').val("1");
     $('#id_dis').text("Contestant #1");
      <?php for($ii=1;$ii<=$countCont/2;$ii++){?> 
$("#cont_id<?php echo $ii; ?>").css("background", "");
<?php }?>
      $('#cont_id1').css("background", "#f58400");
     
      $.ajax({
      type: "POST",
      url: "mmi_c/score_form_m",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".leftcol").html(data);
           }
           });
            $.ajax({
      type: "POST",
      url: "mmi_c/score_form_f",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".rightcol").html(data);
           }
           });
           $.ajax({
      type: "POST",
      url: "mmi_c/bottom_grid",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".j_table").html(data);
           }
           });
                                		
  });
<?php }?>

//select contestant
<?php for($i=1;$i<=$countCont/2;$i++){?> 
$("#cont_id<?php echo $i?>").click(function() {  
var  txt = "<?php echo "Contestant #".$i;?>";
$('#id_dis').text(txt).addClass('newClass');  
            			setTimeout(function() {
            				$('#id_dis').removeClass('newClass', 1000);
            			}, 500); 
<?php for($ii=1;$ii<=$countCont/2;$ii++){?> 
$("#cont_id<?php echo $ii?>").css("background", "");
<?php }?>
$(this).css("background", "#f58400");
$('#cont_id').val("<?php echo $i?>");
$.ajax({
      type: "POST",
      url: "mmi_c/score_form_m",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".leftcol").html(data);
           }
           });
            $.ajax({
      type: "POST",
      url: "mmi_c/score_form_f",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".rightcol").html(data);
           }
           });
           $.ajax({
      type: "POST",
      url: "mmi_c/bottom_grid",
      data: $("#global_data").serialize(),
      success: function(data) {
           $(".j_table").html(data);
           }
           });
});
<?php }?>
 
});
</script>
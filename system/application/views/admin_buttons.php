
<script type="text/javascript">
$(function()
{
///onload

$('#judge_id').val("1");
$('#event_id').val("1");
$('#a_print_btn').attr('href','reports/generate_judge/'+$('#judge_id').val()+'/'+$('#event_id').val());
$('#a_print_best').attr('href','reports/generate_best/'+$('#event_id').val());
$('#a_print_top').attr('href','reports/generate_top');

$("#j_btn1").css("background", "#f58400");    
$("#h_btn1").css("background", "#f58400"); 
$.ajax({
  type: "POST",
  url: "mmi_c/show_grid_m",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_up").html(data);
    }
      });
$.ajax({
  type: "POST",
  url: "mmi_c/show_grid_f",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_down").html(data);
    }
      });
      
<?php foreach($allJudge as $row){?>
$("#j_btn<?php echo $row->judge_id; ?>").button().width(200).click(function() {
<?php foreach($allJudge as $row1){?>$("#j_btn<?php echo $row1->judge_id?>").css("background", "");<?php }?>
$("#best").css("background", "");
$("#top").css("background", "");
$(this).css("background", "#f58400");
$('#judge_id').val("<?php echo $row->judge_id;?>");
$('#a_print_btn').attr('href','reports/generate_judge/'+$('#judge_id').val()+'/'+$('#event_id').val());
$('#a_print_best').attr('href','reports/generate_best/'+$('#event_id').val());
$.ajax({
  type: "POST",
  url: "mmi_c/show_grid_m",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_up").html(data);
    }
      });
$.ajax({
  type: "POST",
  url: "mmi_c/show_grid_f",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_down").html(data);
    }
      });
  });
<?php } ?>

<?php foreach($event as $row){?>
$("#h_btn<?php echo $row->event_id; ?>").button().click(function() {
<?php foreach($event as $row1){?>$("#h_btn<?php echo $row1->event_id?>").css("background", "");<?php }?>
$(this).css("background", "#f58400");
$("#best").css("background", "");
$("#top").css("background", "");
$('#event_id').val("<?php echo $row->event_id;?>");
$('#a_print_btn').attr('href','reports/generate_judge/'+$('#judge_id').val()+'/'+$('#event_id').val());
$('#a_print_best').attr('href','reports/generate_best/'+$('#event_id').val());
$.ajax({
  type: "POST",
  url: "mmi_c/show_grid_m",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_up").html(data);
    }
      });
$.ajax({
  type: "POST",
  url: "mmi_c/show_grid_f",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_down").html(data);
    }
      });
});
$("#h_btn_status<?php echo $row->event_id; ?>").button().click(function() {
	$.ajax({
		type: "POST",
		url: "mmi_c/ajax_set_event_status",
		data: 'event_id=<?php echo $row->event_id; ?>&status='+$(this).find('span').html(),
		success: function(data) {
			$("#h_btn_status<?php echo $row->event_id; ?>").find('span').html(data);
		}
	});
});
<?php } ?>

$("#best").button().width(200).click(function() {  
$("#best").css("background", "");
$("#top").css("background", "");
$(this).css("background", "#f58400");
$.ajax({
  type: "POST",
  url: "mmi_c/show_best_grid_m",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_up").html(data);
    }
      });
$.ajax({
  type: "POST",
  url: "mmi_c/show_best_grid_f",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_down").html(data);
    }
      });
});
            
$("#top").button().width(200).click(function() {  
$("#best").css("background", "");
$("#top").css("background", "");
$(this).css("background", "#f58400");
$.ajax({
  type: "POST",
  url: "mmi_c/show_top_grid_m",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_up").html(data);
    }
      }); 
$.ajax({
  type: "POST",
  url: "mmi_c/show_top_grid_f",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".a_grid_down").html(data);
    }
      });
});
 
/*$("#a_print_btn").button().width(200).click(function() {  
$.ajax({
  type: "POST",
  url: "mmi_c/print_output",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".entire").html(data);
    }
      }); 
});*/
$("#a_print_btn").button().width(200);
$("#a_print_best").button().width(200);
$("#a_print_top").button().width(200);
/*$("#a_print_best").button().width(200).click(function() {  
$.ajax({
  type: "POST",
  url: "mmi_c/print_output_best",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".entire").html(data);
    }
      }); 
});
$("#a_print_top").button().width(200).click(function() {  
$.ajax({
  type: "POST",
  url: "mmi_c/print_output_top",
  data: $("#global_data").serialize(),
  success: function(data) {
    $(".entire").html(data);
    }
      }); 
});
*/
});
</script>
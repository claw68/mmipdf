<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mr & Miss Bukidnon State University 2013</title>

<link rel="stylesheet" type="text/css" media="screen" href="../system/application/static/mmi_css.css" />  
<link rel="stylesheet" type="text/css" media="screen" href="../system/application/static/JQ/css/custom-theme/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../jqGrid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../jqGrid/themes/custom-theme/jquery-ui-1.8.4.custom.css" />

<script src="../system/application/static/JQ/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="../system/application/static/JQ/js/jquery-ui-1.8.4.custom.min.js" type="text/javascript"></script>
<script src="../system/application/static/JQ/js/jquery.validate.js" type="text/javascript"></script>

<script src="../system/application/static/my_func.js" type="text/javascript"></script>

<script src="../system/application/static/JQ/ui/jquery.ui.core.js" type="text/javascript"></script>
<script src="../system/application/static/JQ/ui/jquery.effects.core.js" type="text/javascript"></script>
<script src="../system/application/static/JQ/ui/jquery.ui.widget.js" type="text/javascript"></script>

<script src="../jqGrid/js/jquery.layout.js" type="text/javascript"></script>
<script src="../jqGrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="../jqGrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="../jqGrid/js/jquery.tablednd.js" type="text/javascript"></script>
<script src="../jqGrid/js/jquery.contextmenu.js" type="text/javascript"></script>
<script src="../jqGrid/js/jquery.json-2.2.js" type="text/javascript"></script>


<?php $this->load->view('proj_buttons');?>                              				



<script> var gridimgpath = 'themes/basic/images';</script>


</head>

<body>
    
  	<form id="global_data">
  	<input type="hidden" name="event_id" id="event_id" value="1"/>
  	<input type="hidden" name="cont_id" id="cont_id" value="1"/>
  	</form>


<div class="entire">
 
  <!-- HEADER SECTION -->
  <div class="header">
                             
              
      <div class="headert">Mr & Miss Bukidnon State University 2013</div>
      <!---<div style="font-size:30px;color:yellow;padding-bottom:30px" class="headert">External Studies Center</div>--->
      
      <div class="headert">Official Score Sheet</div>
       <div class="categbtn">
       <a id="toggle_lcol" style="margin-left:40px;margin-bottom:30px;">Show/Hide Male</a>
       <a id="toggle_ccol" style="margin-left:40px;margin-bottom:30px;">Show/Hide Cont</a>
      <a id="toggle_rcol" style="margin-left:40px;margin-bottom:30px;">Show/Hide Female</a>
       </div>
      <div class="categbtn">
      <?php foreach ($event as $row){?>
          <a id="cbtn<?php echo $row->event_id; ?>" style="margin-left:40px;margin-bottom:30px;"><?php echo $row->event_name?></a>
      <?php }?>
     
      </div>
      
      <div class="sub_head" style="margin-top:250px">
          	<div id="cat_dis"></div>
          	<div id="id_dis"></div>
	    </div>
      
	</div>
	
	
  <div class="whole" style="padding-bottom:150px; width: 1200px;">	
  
  	<!-- LEFT SECTION -->

  	<div class="leftcol">

  	</div>	
  	
  	<!-- CENTER SECTION -->
  	<div class="centercol" style="margin-top:25px;margin-left:490px;">
    <?php for($i=1;$i<=$countCont/2;$i++){?>  
  	   <div id="cont_id<?php echo $i?>" class="num_pad">
          
          <div class="cont_pic_m">
            <img src="../files/cont_thumb/<?php echo $i?>m.png" />
          </div>
          
            <div class="num"><?php echo $i;?></div>
          
          <div class="cont_pic_f">
            <img src="../files/cont_thumb/<?php echo $i?>f.png" />
          </div>
          
       </div>
    <?php }?>        
  	</div>	
  	
  	<!-- RIGHT SECTION -->
  	<div class="rightcol" style="margin-right: 0px;">

  	</div>	
  	
  
  </div>	
    		<!--BOTTOm SECTION -->
  	<div class="j_table">
  	 
  	                    
    
    </div>
    
    
    <div id="success" title="Success">
          <p>Successful</p>
    </div>
    
    
    <div id="error" title="Error(s)">
          <p>Error</p>
    </div>

  
</div>
</body>
</html>



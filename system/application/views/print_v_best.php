<p style = "font-size:2em; font-weight: bold;">Best in <?php echo $eventInfo->event_name?></p> 
        <div style = "font-size:1.5em; font-family: Arial; height: 600px; margin-top: -10px;">
        <table id="grid_male" class="scroll" cellpadding="0" cellspacing="0" style="cursor: pointer; -moz-user-select: none;"></table></div>
        <div class="clearer">&nbsp;</div>
             <div class="clearer">&nbsp;</div>
      <div class="clearer">&nbsp;</div>
       <div class="clearer">&nbsp;</div>
    <div style = "font-size:1.5em; font-weight: bold; margin-top: -30px; margin-bottom: 20px;">Certified True and Correct:</div>
    <br /><br />
        <div class="clearer">&nbsp;</div>
 
    
     <div style="width: 1300px; margin:auto;"> 
     <?php foreach($judge as $row){?>
      
     <div style="margin:auto; width: <?php echo strlen($row->print_name)*20;?>px;float:left;">
     <center>
      <a>_<?php for($i=0;$i<strlen($row->print_name);$i++){echo "__";}?>_</a> <br />
           
           <a style="font-size:1.5em; font-weight: bold;"><?php echo $row->print_name?></a><br />
           <a style="font-size:1.5em; font-weight: bold;"><?php echo $row->judge_name?></a>
      </center>           
      </div>
      
      <?php } ?>
      </div>
      <div class="clearer">&nbsp;</div>
      <br /><br />
      
      <center>
      
      <div style="margin-top: 100px;">
      <a>______________________________________</a> <br />
           <a style="font-size:1.5em; font-weight: bold;">Rozanne Tuesday G. Flores</a><br />
           <a style="font-size:1.5em; font-weight: bold;">Head Tabulator</a>      
      </div></center> <br /><br /><br /><br />
      
      
      
       <p style = "font-size:2em; font-weight: bold;">Best in <?php echo $eventInfo->event_name?></p>  
        <div style = "font-size:1.5em; font-family: Arial;height: 600px; margin-top: -10px;">
        <table id="grid_female" class="scroll" cellpadding="0" cellspacing="0" style="cursor: pointer; -moz-user-select: none;"></table></div>
        
                     <div class="clearer">&nbsp;</div>
      <div class="clearer">&nbsp;</div>
       <div class="clearer">&nbsp;</div>
    <div style = "font-size:1.5em; font-weight: bold; margin-top: -30px; margin-bottom: 20px;">Certified True and Correct:</div>
    <br /><br />
        <div class="clearer">&nbsp;</div>
 
     <center>
     <div style="width: 1300px; margin:auto;"> 
     <?php foreach($judge as $row){?>
      
     <div style="margin:auto; width: <?php echo strlen($row->print_name)*20;?>px;float:left;">
     <center>
      <a>_<?php for($i=0;$i<strlen($row->print_name);$i++){echo "__";}?>_</a> <br />
           
           <a style="font-size:1.5em; font-weight: bold;"><?php echo $row->print_name?></a><br />
           <a style="font-size:1.5em; font-weight: bold;"><?php echo $row->judge_name?></a>
      </center>           
      </div>
      
      <?php } ?>
      </div>
      <div class="clearer">&nbsp;</div>
      <br /><br />
      <center><div style="margin-top: 100px;">
      <a>______________________________________</a> <br />
           <a style="font-size:1.5em; font-weight: bold;">Rozanne Tuesday G. Flores</a><br />
           <a style="font-size:1.5em; font-weight: bold;">Head Tabulator</a>      
      </div></center>
    <script type="text/javascript">
    
    $("#grid_male").jqGrid({
            
            // url:'http://localhost/MMI/?mmi_c/function_grid',
            url:'?mmi_c/best_grid_data_m',
            datatype: "json",
             colNames:['Candidate Number',<?php foreach($judge as $row){?>'<?php echo $row->judge_name?>',<?php } ?>'Total','Rank'],
            colModel:[
                    {name:'num',index:'num',align:"center", sortable: true,sorttype:'int'},
                    <?php foreach($judge as $row){?>
                    {name:'crit_f_<?php echo $row->judge_id?>',index:'crit_f_<?php echo $row->judge_id?>',align:"center", sortable: true,sorttype:'int'},
                    <?php } ?>
                    {name:'total',index:'total',sortable: true,align:"center", sorttype:'int'},
                    {name:'rank',index:'rank',sortable: true,align:"center", sorttype:'int'},
                    
            ],
            mtype: "POST",
            postData:{passvalue1: $("#event_id").val(), passvalue2: $("#judge_id").val()},
            imgpath: gridimgpath,
            loadonce: true,  
            caption:"Male Category",
            height: '250',
            width: '1500',

    }); 
    
    $("#grid_female").jqGrid({
            scrollrows: true,
            url:'?mmi_c/best_grid_data_f',
            datatype: "json",
            colNames:['Candidate Number',<?php foreach($judge as $row){?>'<?php echo $row->judge_name?>',<?php } ?>'Total','Rank'],
            colModel:[
                    {name:'num',index:'num',align:"center", sortable: true,sorttype:'int'},
                    <?php foreach($judge as $row){?>
                    {name:'crit_f_<?php echo $row->judge_id?>',index:'crit_f_<?php echo $row->judge_id?>',align:"center", sortable: true,sorttype:'int'},
                    <?php } ?>
                    {name:'total',index:'total',sortable: true,align:"center", sorttype:'int'},
                    {name:'rank',index:'rank',sortable: true,align:"center", sorttype:'int'},
                    
            ],
            mtype: "POST",
            postData:{passvalue1: $("#event_id").val(), passvalue2: $("#judge_id").val()},
            imgpath: gridimgpath, 
            loadonce: true, 
            caption:"Female Category",
            height: '250',
            width: '1500',
             
            

    }); 
    </script>   

<p style = "font-size:2em; font-weight: bold;">Judge: <?php echo $judgeInfo->judge_name?></p> 
        <div style = "font-size:1.5em; font-family: Arial; height: 750px;"><table id="grid_male" class="scroll" cellpadding="0" cellspacing="0" style="cursor: pointer; -moz-user-select: none;"></table></div>
        <div class="clearer">&nbsp;</div>
             <div class="clearer">&nbsp;</div>
      <div class="clearer">&nbsp;</div>
       <div class="clearer">&nbsp;</div>
    <div style = "font-size:1.5em; font-weight: bold;">Certified True and Correct:</div>
        <div class="clearer">&nbsp;</div>
 
     <center> <div style="margin-right: 500px;" >
           <a>______________________________________</a> <br />
           <a style="font-size:1.5em; font-weight: bold;"><?php echo $judgeInfo->print_name?></a><br />
           <a style="font-size:1.5em; font-weight: bold;"><?php echo $judgeInfo->judge_name?></a>
                 
      </div>
      <div style="margin-left: 500px; margin-top: -75px;">
           <a>______________________________________</a> <br />
           <a style="font-size:1.5em; font-weight: bold;">Rozanne Tuesday G. Flores</a><br />
           <a style="font-size:1.5em; font-weight: bold;">Head Tabulator</a>      
      </div></center>
      <br /> <br /> <br /> <br /> <br /> 
<p style = "font-size:2em; font-weight: bold;">Judge: <?php echo $judgeInfo->judge_name?></p>      
        <div style = "font-size:1.5em; font-family: Arial; height: 750px;"><table id="grid_female" class="scroll" cellpadding="0" cellspacing="0" style="cursor: pointer; -moz-user-select: none;"></table></div>
    <script type="text/javascript">
    
    $("#grid_male").jqGrid({
            
            // url:'http://localhost/MMI/?mmi_c/function_grid',
            url:'?mmi_c/admin_grid_data_m',
            datatype: "json",
             colNames:['Candidate Number',<?php foreach($crit_m as $row){?>'<?php echo $row->crit_name?>',<?php } ?>'Total','Rank'],
            colModel:[
                    {name:'num',index:'num',align:"center", sortable: true,sorttype:'int'},
                    <?php foreach($crit_f as $row){?>
                    {name:'crit_f_<?php echo $row->crit_id?>',index:'crit_f_<?php echo $row->crit_id?>',align:"center", sortable: true,sorttype:'int'},
                    <?php } ?>
                    {name:'total',index:'total',sortable: true,align:"center", sorttype:'int'},
                    {name:'rank',index:'rank',sortable: true,align:"center", sorttype:'int'},
                    
            ],
            mtype: "POST",
            postData:{passvalue1: $("#event_id").val(), passvalue2: $("#judge_id").val()},
            imgpath: gridimgpath,
            loadonce: true,  
            caption:"Event: <?php echo $eventInfo->event_name?> - Male",
            height: '600',
            width: '1500',

    }); 
    
    $("#grid_female").jqGrid({
            scrollrows: true,
            url:'?mmi_c/admin_grid_data_f',
            datatype: "json",
            colNames:['Candidate Number',<?php foreach($crit_f as $row){?>'<?php echo $row->crit_name?>',<?php } ?>'Total','Rank'],
            colModel:[
                    {name:'num',index:'num',align:"center", sortable: true,sorttype:'int'},
                    <?php foreach($crit_f as $row){?>
                    {name:'crit_f_<?php echo $row->crit_id?>',index:'crit_f_<?php echo $row->crit_id?>',align:"center", sortable: true,sorttype:'int'},
                    <?php } ?>
                    {name:'total',index:'total',sortable: true,align:"center", sorttype:'int'},
                    {name:'rank',index:'rank',sortable: true,align:"center", sorttype:'int'},
                    
            ],
            mtype: "POST",
            postData:{passvalue1: $("#event_id").val(), passvalue2: $("#judge_id").val()},
            imgpath: gridimgpath, 
            loadonce: true, 
            caption:"Event: <?php echo $eventInfo->event_name?> - Female",
            height: '600',
            width: '1500',
             
            

    }); 
    </script>   
     <div class="clearer">&nbsp;</div>
      <div class="clearer">&nbsp;</div>
       <div class="clearer">&nbsp;</div>
    <div style = "font-size:1.5em; font-weight: bold;">Certified True and Correct:</div>
        <div class="clearer">&nbsp;</div>
 
     <center> <div style="margin-right: 500px;" >
           <a>______________________________________</a> <br />
           <a style="font-size:1.5em; font-weight: bold;"><?php echo $judgeInfo->print_name?></a><br />
           <a style="font-size:1.5em; font-weight: bold;"><?php echo $judgeInfo->judge_name?></a>
                 
      </div>
      <div style="margin-left: 500px; margin-top: -75px;">
           <a>______________________________________</a> <br />
           <a style="font-size:1.5em; font-weight: bold;">Rozanne Tuesday G. Flores</a><br />
           <a style="font-size:1.5em; font-weight: bold;">Head Tabulator</a>      
      </div></center>
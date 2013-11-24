<div class="a_grid_female">      
  <table id="a_grid_f" class="scroll" cellpadding="0" cellspacing="0" style="cursor: pointer; -moz-user-select: none;">
  </table>
<div id="grid_script_f"></div>
                     
<script type="text/javascript">                      
    $("#a_grid_f").jqGrid({
            scrollrows: true,
            url:'?mmi_c/top_grid_data_f',
            datatype: "json",
            colNames:['Contestant Number',<?php foreach($event as $row){?>'<?php echo $row->event_name?>',<?php } ?>'Total','Rank'],
            colModel:[
                    {name:'num',index:'num',align:"center", sortable: true,sorttype:'int'},
                    <?php foreach($event as $row){?>
                    {name:'event_<?php echo $row->event_id?>',index:'event_<?php echo $row->event_id?>',align:"center", sortable: true,sorttype:'int'},
                    <?php } ?>
                    {name:'total',index:'total',sortable: true,align:"center", sorttype:'int'},
                    {name:'rank',index:'rank',sortable: true,align:"center", sorttype:'int'},
            ],
            mtype: "POST",
            postData:{passvalue1: $("#event_id").val(), passvalue2: $("#judge_id").val()},
            imgpath: gridimgpath, 
            sortname: 'id',
            rownumbers: true,
            loadonce: true, 
            viewrecords: true, 
            sortorder: "desc", 
            caption:"FEMALE",
            height: '340',
            width: '950',
            loadComplete:function(){
            }
    });
</script>
</div>  
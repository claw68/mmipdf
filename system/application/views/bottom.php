<table id="j_grid" class="scroll" cellpadding="0" cellspacing="0" style="cursor: pointer; -moz-user-select: none;"></table>
                        <div id="j_grid_pager" class="scroll" style="text-align:center;"></div>
                        
                        <script type="text/javascript">   
                           
                        $("#j_grid").jqGrid({
                                scrollrows: true,
                                url:'?mmi_c/bottom_grid_data',
                                datatype: "json",
                                colNames:['Gender',<?php for($i=0;$i<$countcont/2;$i++){?>'C<?php echo $i+1; ?>',<?php } ?>],
                                colModel:[
                                        {name:'gender',width:'250',index:'gender',align:"center", sortable: false},
                                        <?php for($i=0;$i<$countcont/2;$i++){?>
                                        {name:'C<?php echo $i+1; ?>',index:'C<?php echo $i+1; ?>',align:"center", sortable: false},
                                        <?php } ?>
                 
                                ],
                                mtype: "POST",
                                postData:{passvalue1: $("#event_id").val()},
                                imgpath: gridimgpath,  
                         
                                
                               
                                caption:"SUMMARY",
                                height: '52',
                                width: '1200',
               
                        });
                        </script> 
<div class="container_for_prjcts">
    <div class="row for head_of_prjct">  
       <div class="col-md d-table-cell hlogo">
            <img src="<?php  echo base_url('dist')?>/img/logo_p.png">
        </div>
            <div class="col-md-6 d-table-cell hspan">
                    <span id='project_id_<?php echo $newID; ?>' class='nameOfProject'><?php echo $name; ?></span>
            </div>
            <div class="col-md d-table-cell buttons">
                <div class="hidd">
                    <a href="" class="edit" style="display:none;background: url(<?php  echo base_url('dist')?>/img/edit_pr.png) no-repeat;padding-right: 16px;"></a>
                    <a href="" class="bordered"></a>
                    <a href="" class="delete" style="display:none;background: url(<?php  echo base_url('dist')?>/img/del_pr.png) no-repeat;padding-right: 16px;"></a>
                </div>  
            </div>
        <!--END OF ROW -->      
    </div>
    <div class="row for add_task" style="<?php
if($showAdd == "Y"){
echo "display:block;";
}else{
echo "display: none;"; 
} ?>
">
            <div class="col-md-1 d-table-cell plus">
                <img src="<?php  echo base_url('dist')?>/img/a-11.png">
            </div>
            <div class="col-md-8 d-table-cell dinpt">
                <input type="text" class="inputTask" placeholder="Start typing here to create a task...">
            </div>
            <div class="col-md-3 d-table-cell buttons">
                <a href="#" class="save_add" style="">Add Task</a>
            </div>
    </div>
    <div class="row for tasks" style="<?php if($showAdd == "Y"){ echo "display:block;"; }else{ echo "display: none;"; } ?>">
        <?php 
        if(isset($Tasks)){
             print_r($Tasks);
        }
        ?>
    </div>
</div>


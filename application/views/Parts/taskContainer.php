<div class="task" id="<?php echo $taskId ?>">
  <div class="col-md-1 d-table-cell checkboh">
      <input type="checkbox" class="task_status"<?php if(isset($status)){
      if($status == 0){
      echo "checked";}} ?>>
      <label for=""></label>
  </div>
  <div class="borderedTask d-table-cell"></div>
  <div class="col-md-8 d-table-cell containerTask">
    <span class="taskName"  <?php if(isset($status)){
      if($status == 0){ echo "style='text-decoration:line-through;'";}}?> >
        <?php echo $taskName?>
    </span>
  </div>
  <div class="col-md-2 d-table-cell Btns">
    <div class="deadline">
        <?php echo $deadline?>
    </div>
    <div class="row out_edit" style="display:none;">
      <div class="lvlBtns">
        <div class="up"></div>
        <div class="border"></div>
        <div class="down"></div>
      </div>
          <a class="border"></a>
          <a href="" class="edit curenntTask"></a>
          <a class="border"></a>
          <input  type="hidden" id="input_<?php echo $taskId ?>">
          <a href="" class="deadline" onfocus="picker()" id="deadline_<?php echo $taskId ?>"></a>
          <a class="border"></a>
          <a href="" class="deleteTask"></a>
    </div>
    <div class="in_edit" style="display:none;">
        <a href="" class="save"></a>
        <a class="border"></a>
        <a href="" class="cancel"></a>
    </div>
  </div>
</div>

//Function "Replacer" 
 function replacer(whatChk,whereStr){
      return whereStr.replace(whatChk, '');
 }    
 
  //Datepicker start
  //For new appended tasks
 function picker() {
jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}

$(':regex(id,^deadline_)').datepicker({format:'yyyy-mm-dd'});
  $(':regex(id,^deadline_)').on('changeDate', function() {
      var deadline = $(this).attr('id');//deadline_113
      var inpt = deadline.replace('deadline_','input_');
      $('#'+inpt).val($('#'+deadline).datepicker('getFormattedDate'));
      $('#'+deadline).datepicker('hide');
      //----------------------------
      var oldDeadline = $('#'+inpt).parent().siblings('div.deadline');
      //set new date to div deadline
      oldDeadline.text($('#'+inpt).val());
      //Send new deadline to the base
      var newDeadline = $('#'+inpt).val();
      var IdTask =  replacer('deadline_',deadline);  
      
      
       var request = $.ajax ({
							  url : '/zub/todolist/Main/EditDeadlineTask', 
							  type: 'POST',
							  data: {
							    "id": IdTask,
							    "newDeadline":newDeadline
							  }
                        });
         request.done(function() {
         console.log("Deadline success set");
         });
         request.fail(function() {
         console.log("request fail");
         });
  });
};
//For loaded guns
$(picker());

//---Datepicker END

$(document).ready(function() { 
  
           $(document).on("click","a.deadline", function(){
         return false;
     });
     
     
      $(document).on("click","a.cancel", function(){
           var row = $(this).closest('div.row.new_prjct');
           $("#name_new_prjct").val('');
           row.css('display','none');
         return false;
     });

    //Show and Hide Btns(edit/delete) on the project
$(document).on('mouseenter','div.hidd', function () {
        $(this).children('a.edit, a.delete').show();
    });
    
 $(document).on('mouseleave','div.hidd', function () {
        $(this).children('a.edit, a.delete').hide();
    });   
  //Show and Hide Btns(edit/delete) on the project----------------END  
  //Show and Hide Btns(4 btns on task)
  $(document).on('mouseenter','div.deadline', function () {
     var state = $(this).css('display');
      if(state === 'block'){
      //hide this block
      $(this).css('display','none');
      //Show block with navigate btns of tasks
      $(this).siblings('div.row.out_edit').css('display','block');
      //Then check clicked btn "edit task name" -> change block to block with 2 btns(save/clear)
      }
  });

      $(document).on('mouseleave','div.row.out_edit', function () {
          $(this).css('display','none');
          $(this).siblings('div.deadline').css('display','block');
     }
  );
   //Hide and Show Tasks 
    $(document).on("click","div.row.for.head_of_prjct", function(){
        var addTask = $(this).siblings("div.row.for.add_task");
        var tasks = $(this).siblings("div.row.for.tasks");
        var show = addTask.css('display');
        if(show === 'none'){
       addTask.css('display','block');
        tasks.css('display','block');
        }else{
        addTask.css('display','none');
        tasks.css('display','none'); 
        }
    });
    //Hide and Show Tasks ------------ END

// Up/down btns for tasks
$(document).on("click","div.lvlBtns", function(event){
    var row = $(this).closest('.task');  
    var btn = event.target.className;
    if(btn === "up"){
        row.insertBefore(row.prev()); 
    }else{
        row.insertAfter(row.next());
    }
});
//-------------------------------------START edit task--------------------
 $(document).on("click","a.edit.curenntTask", function(){
      var row = $(this).closest('.task');
      var TaskId = row.attr("id");
      var span = row.children('.containerTask').children('.taskName');
      var OldTaskName = span.html();
      OldTaskName = OldTaskName.trim();
      //change span to textarea
      var textArea = $("<textarea  style='width:auto;max-height:30px;'/>");
      textArea.val(OldTaskName);
      span.replaceWith(textArea); // replace span with textarea
      textArea.focus();  // focus on textarea
      textArea.change(function () {
         //берем новое значение названия проекта  после смены 
      var newTaskName = textArea.val();
         //записываем в спан новое значение имени проекта
      span.text(newTaskName);
         //меняем обратно
      textArea.replaceWith(span);
      var request = $.ajax ({
							  url : '/zub/todolist/Main/EditTask', 
							  type: 'POST',
							  data: {
							    "NewName": newTaskName,
							    "id": TaskId
							  }
                        });
         request.done(function() {
         console.log("task success renamed");
         });
         request.fail(function() {
         console.log("request 'renamed' task fail");
         });
      
      
       });
 });
//END tesk edit
//Delete task

$(document).on("click","a.deleteTask", function(){
      var row = $(this).closest('.task');
      var IdTask = row.attr('id');
      
      var request = $.ajax ({
							  url : '/zub/todolist/Main/DeleteTask', 
							  type: 'POST',
							  data: {
							    "id": IdTask
							  }
                        });
         request.done(function() {
         console.log("task success removed");
         row.css('display','none');
         });
         
         request.fail(function() {
         console.log("request 'remove' task fail");
         
         });
 return false;//чтоб не ребутить страницу
         
});



//-----Change status of task
$(document).on('click', '.task_status', function(){
      var row = $(this).closest('.task');
      var TaskId = row.attr('id');
      var status = $(this).prop('checked');//true - on checked,false - on not checked
      var span = row.children('.containerTask').children('.taskName');
      if(status === true){
          span.css('text-decoration','line-through');
          var state = 0;
      }else{
          span.css('text-decoration','none');
          state = 1;
      }
      var re = /[\d]/;
      if(re.test(TaskId)){
        var request = $.ajax ({
							  url : '/zub/todolist/Main/EditStatusTask', 
							  type: 'POST',
							  data: {
							    "status": state,
							    "id": TaskId
							  }
                        });
         request.done(function() {
         console.log("task status changed success ");
         });
         request.fail(function() {
         console.log("task status changed fail");
         });
      }else{
          console.log('nexyutytwamanitb!');
      }
      
      
      //console.log(status);
});


//-------------------------------------START EDIT Project------------------------------------------------------------
 $(document).on("click","a.edit", function(){
     var span = $(this).parent().parent().parent().children("div.col-md-6").children("span");
     var prjct_id = span.attr("id");
     var prjct_name = span.html();
     var textArea = $("<textarea style='width:auto;max-height:30px;' />");   // create new text area
     textArea.val(prjct_name);  // put value to text area
     span.replaceWith(textArea); // replace span with textarea
     textArea.focus();  // focus on textarea
     textArea.change(function () {
         //берем новое значение названия проекта  после смены 
         var newNamePrjct = textArea.val();
         //записываем в спан новое значение имени проекта
         span.text(newNamePrjct);
         textArea.replaceWith(span);
         //Записываем новое название проекта в БД
         var NewPrjct_id = replacer('project_id_',prjct_id);
         var request = $.ajax ({
							  url : '/zub/todolist/Main/EditProject', 
							  type: 'POST',
							  data: {
							    "NewName": newNamePrjct,
							    "id": NewPrjct_id
							  }
                        });
         request.done(function() {
         console.log("project success renamed");
         });
         request.fail(function() {
         console.log("request fail");
         });
     });
     //On change textarea END function
    return false;//чтоб не ребутить страницу
 });
//--------------------------------------------------------------------END EDIT---------------------------------------------
//------------------------------------------DELETE Project start------------------------------------------------------------
$(document).on("click","a.delete", function(){
     var BigDiv = $(this).closest("div.row.for.head_of_prjct");
     var DivSpan = BigDiv.children(".col-md-6");
     var span = DivSpan.children("span");
     var prjct_id = span.attr("id");
     var prjct_name = span.html();
     var NewPrjct_id = replacer('project_id_',prjct_id);
     var request = $.ajax ({
							  url : '/zub/todolist/Main/DeleteProject', 
							  type: 'POST',
							  data: {
							    "id": NewPrjct_id
							  }
                        });
         //---------------------
         request.done(function() {
         //удаляем блок с проектом
         BigDiv.closest("div.container_for_prjcts").remove();
         });
         request.fail(function() {
         console.log("request fail");
         });
    return false;//чтоб не ребутить страницу
});
//-------------------------- Delete project end
 //------------------------------------------Add new task to project------------------------------------------------------------
$(document).on("click","a.save_add", function(){
     //Div with Add task
     var DivAdd_task = $(this).closest("div.row.for.add_task");
     //Div with header of project
     var BigDiv = DivAdd_task.siblings("div.row.for.head_of_prjct");
     var NameNewTask = DivAdd_task.children("div.col-md-8").children("input").val();
     var prjct_id = BigDiv.children(".col-md-6").children("span").attr("id");
     var prjct = replacer('project_id_',prjct_id);
     var today = new Date();
     var dd = today.getDate();
     var mm = today.getMonth()+1; //January is 0!
     var yyyy = today.getFullYear();
    if(dd<10) {
        dd = '0'+dd
        } 
    if(mm<10) {
    mm = '0'+mm
} 
today = yyyy + '-' + mm + '-' + dd;


if(NameNewTask.length >5){
         var request = $.ajax ({
							  url : '/zub/todolist/Main/AddNewTask', 
							  type: 'POST',
							  data: {
							    "project_id": prjct,
							    "taskName": NameNewTask,
							    "deadline": today
							  }
                        });
         //---------------------
         request.done(function(newTask) {
         //add row with new task
         DivAdd_task.parent().children("div.row.for.tasks").append(newTask);
         //очищаем поле для заведения новой задачи
         DivAdd_task.children("div.col-md-8").children("input").val("");
         });
         request.fail(function() {
         console.log("request save new project fail");
         });
         
}else{
    alert("name of task must be more than 5 symbols")
    
}
         
    return false;//чтоб не ребутить страницу
    
    
});
//-------------------------- Add new task end

    //Submit button add project
    $('#add_prjct').click(function(){
        //отрисовываем форму заполнения нового проекта
        $("div.row.new_prjct").css('display','block');//открываем блок
    });
     //ловим submit form-ы для новых проектов
            $('#save_new_prjct').click(function(){
                //берем имя нового проекта
                var name = $('#name_new_prjct').val();
                //check name length
                if(name.length > 0){
                    //если поле заполнили
                    if(name.length > 5){
                        //если имя больше 5 символов, записываем в базу название нового проекта
                        var request = $.ajax ({
							  url : '/zub/todolist/Main/saveNewProject', 
							  type: 'POST',
							  data: {
							    "name": name
							  }
                        });
                        //-------------------------------------------------
                        //Если запись в базу прошла успешно
                        request.done(function(result) {
                        //очищаем значение textarea
                        $('#name_new_prjct').val("");
                        //прячем блок с добавлением нового проекта
						$("div.row.new_prjct").css('display','none');
                        //Добавляем выше кнопки "новый проект"
                            $("div.row.new_prjct").before(result);
                        });
                        //------------------------------------------------
                        //если записать в базу новый проект не удалось
                        request.fail(function() {
                        console.log("request fail");
                            });
                    }else{
                        //если имя меньше 5 символов но больше нуля
                    alert('text must be more then 5 letters');
                    }
                }else{
                    //если поле оставили пустым
                alert('text must be passed!');
                }
                return false;//останавливаем перезагрузку страницы при submit
            });
            //end function submit add project
});
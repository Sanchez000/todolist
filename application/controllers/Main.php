<?php
class Main extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('todolist_model');
                $this->load->helper('url_helper');
        }

/*
        public function index()
        {

          $allPrjcts = $this->todolist_model->get_all_projects();
          $allTasks = $this->todolist_model->get_all_tasks();
          
          if(count($allPrjcts) > 0){
              
           $compleateHtml = ''; 
          foreach($allPrjcts as $item){
             $data['name'] = $item['name'];
    		 $data['newID'] = $item['id'];
    		 $data['showAdd'] = "N";
    		 $strTask = '';
    		 for($i=0;$i<count($allTasks);$i++){
                    if($allTasks[$i]['project_id'] == $item['id']){
                        $data['taskName'] = $allTasks[$i]['name'];
                        $data['taskId'] = $allTasks[$i]['id'];
                        $data['deadline'] = $allTasks[$i]['deadline'];
                        $data['status'] = $allTasks[$i]['status'];
                        $strTask .= $this->load->view('Parts/taskContainer', $data, TRUE);
                }
    		 }
    		 $data['Tasks'] = $strTask;
    		 $compleateHtml .= $this->load->view('Parts/HeaderForProjects', $data, TRUE);
          }
          //When project selected
            $data['Prjcts'] = $compleateHtml;
            $this->load->view('Parts/header');
            $this->load->view('Parts/body',$data);
            $this->load->view('Parts/new_project');
            $this->load->view('Parts/footer');
            
            //When no projects in DB
          }else{
            $this->load->view('Parts/header');
            $this->load->view('Parts/body');
            $this->load->view('Parts/new_project');
            $this->load->view('Parts/footer');
          }
          
          
          
          
		}
		
	*/	
		public function EditTask()
		{
		    $NewName = $this->input->post('NewName');
		    $id = $this->input->post('id');
		    
		    
		    $data = array(
						'NewName' => $NewName,
						'id' => $id
						);
			$this->todolist_model->edit_task($data);
		}
		
		
		
		
		public function EditDeadlineTask()
		{
		    $deadline = $this->input->post('newDeadline');
		    $id = $this->input->post('id');
		    $data = array(
						'deadline' => $deadline,
						'id' => $id
						);
			$this->todolist_model->edit_deadline_task($data);
		}
		
		
		
		
		
		
		
		public function EditStatusTask()
		{
		    $status = $this->input->post('status');
		    $id = $this->input->post('id');
		    
		    
		    $data = array(
						'status' => $status,
						'id' => $id
						);
			$this->todolist_model->edit_status_task($data);
		}
		

		public function EditProject()
		{
		    $NewName = $this->input->post('NewName');
		    $id = $this->input->post('id');
		    
		    
		    $data = array(
						'NewName' => $NewName,
						'id' => $id,
						'owner' => 'zub'//пока записывается статически
						);
			$this->todolist_model->edit_prjct($data);
		}
		
		
		
		//Delete project
		
		public function DeleteProject()
		{
		    $id = $this->input->post('id');
			//$id = int($id);
			//Вызываем метод в моделе
			$this->todolist_model->delete_prjct($id);
			//print_r("ok");
		}
		
			public function DeleteTask()
		{
		    $id = $this->input->post('id');
			$this->todolist_model->delete_task($id);
		}
		

		public function saveNewProject()
		{
			$nameNewProject = $this->input->post('name');
			$data = array(
						'name' => $nameNewProject,
						'owner' => 'zub'//пока записывается статически
						);
			//записываем все данные которые пришли
		$res = $this->todolist_model->put_new_prjct($data);

		
		if($res){
		   
		 $data['name'] = $nameNewProject;
		 $data['newID'] = $res;
		 //сразу разворачиваем поле для заведения новой задачи
		 //HeaderForProjects ---- шапка проекта и поле для записи новой задачи
		 
		 $data['showAdd'] = "Y";
		 $Header = $this->load->view('Parts/HeaderForProjects', $data, TRUE);

		 print_r($Header);
		 
		    }else{
		        print_r('Model_error');
		    }
		}
		

			public function AddNewTask()
		{
		     $project_id = $this->input->post('project_id');
		     $taskName = $this->input->post('taskName');
		     $deadline = $this->input->post('deadline');
		      $unixtime = $this->input->post('unixtime');
		    			$data = array(
		    			'status' => 1,
						'project_id' => intval($project_id),
						'name' => $taskName,
						'deadline' => $deadline
						);
		$NewIdTask = $this->todolist_model->put_new_task($data);
		$result = $this->load->view('Parts/taskContainer', array('taskId' => $NewIdTask, 'taskName' => $taskName,'deadline' => $deadline), TRUE);
		print_r($result);
		}
		
		
}
?>
<?php
class Todolist_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        
		//get all tasks
		public function get_all_tasks($project_id  = FALSE)
		{
        if ($project_id === FALSE)
        {
                $query = $this->db->get('Tasks');
                return $query->result_array();
        }
        $query = $this->db->get_where('Tasks', array('project_id' => $project_id));
        return $query->row_array();
		}
		
		
		//get all projects
		public function get_all_projects($id = FALSE)
		{
        if ($id === FALSE)
        {
                $query = $this->db->get('Projects');
                return $query->result_array();
        }
        $query = $this->db->get_where('Projects', array('id' => $id));
        return $query->row_array();
		}
		
		//Insert new project
		public function put_new_prjct($data)
		{
		$this->db->insert('Projects', $data);//Projects -- таблица с проектами "name" "id" "owner" 
		$insert_id = $this->db->insert_id();
        return  $insert_id;
		}
		
		
		//Edit name of project
		public function edit_prjct($data)
		{
		  $this->db->set('name',$data['NewName']);
          $this->db->where('id',$data['id']);
          $this->db->update('Projects');
          return "ok";// gives UPDATE mytable SET field = field+1 WHERE id = 2  
	    //$this->db->update('Tasks', array('id' => $id, 'name' => $name));
		}
		
		
		//Delete project
		public function delete_prjct($id)
		{
          $this->db->delete('Projects', array('id' => $id));
          $this->db->delete('Tasks', array('project_id' => $id));
          //return "ok";
		}
		
		//Delete task
		public function delete_task($id)
		{
          $this->db->delete('Tasks', array('id' => $id));
		}
		
		
		//Insert new task
		public function put_new_task($data)
		{
		$this->db->insert('Tasks', $data);
		$insert_id = $this->db->insert_id();
        return  $insert_id;
		}
		
		//Edit name of task
		public function edit_task($data)
		{
		  $this->db->set('name',$data['NewName']);
          $this->db->where('id',$data['id']);
          $this->db->update('Tasks');
		}
		
		//Edit status of task
		public function edit_status_task($data)
		{
		  $this->db->set('status',$data['status']);
          $this->db->where('id',$data['id']);
          $this->db->update('Tasks');
		}


        //Edit deadline of task
		public function edit_deadline_task($data)
		{
		  $this->db->set('deadline',$data['deadline']);
          $this->db->where('id',$data['id']);
          $this->db->update('Tasks');
		}
		
}



?>

